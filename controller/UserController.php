<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/User.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\User;

class UserController extends AbstractController {

    private $userModel;
    private $adModel;
    private $commentModel;
    private $requestModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->adModel = new AdModel();
        $this->commentModel = new CommentModel();
        $this->requestModel = new RequestModel();
    }

    /**
     * Página principal del usuario
     */
    public function index() {
        //TODO: según el usuario se mostrará la dashboard del admin 
        // por defecto o su página de administración básica
        //Conseguimos todos los usuarios
        //Cargamos la vista index y le pasamos valores
        $this->view("index", array(
            'title' => "P&aacute;gina principal"
        ));
    }

    public function readUser() {
        if (filter_has_var(INPUT_GET, "uuid")) {
            $id = RegularUtils::sanearStrings(array('uuid'), "GET")['uuid'];
            $user = $this->userModel->read($id);

            if (!isset($user->id) || $user->state == STATES['ELIMINADO']) {
                $this->redirect("user", "index");
            } else {
                $userAds = $this->adModel->countUserAds($user->id);
                $userComments = $this->commentModel->countUserComments($user->id);
                $numRequests = $this->requestModel->countUserRequests($user->id);
                $requests = $this->requestModel->listUserRequest($user);
                $this->view("profile", array(
                    'title' => "Perfil $user->name",
                    "user" => $user,
                    "userAds" => $userAds,
                    "userComments" => $userComments,
                    "requests" => $requests,
                    "numRequests" => $numRequests
                ));
            }
        } else {
            $this->redirect("user", "index");
        }
    }

    /**
     * Registro desde la propia aplicación
     */
    public function register() {
        $values = array("name" => "text", "login" => "text", "surname" => "text",
            "email" => "email", "password" => "text", "password2" => "text",
            "phone" => "phone");
        $errors = RegularUtils::filtrarPorTipo($values, "createUser");
        if ($_POST['password'] != $_POST['password2']) {
            $errors["createUser"]["password"] = $errors["createUser"]["password2"] = "no_match";
        }
        if (!isset($errors["createUser"]) && $_POST['password'] == $_POST['password2']) {
            $values = array("name", "login", "surname",
                "email", "password", "phone");
            $filtrado = RegularUtils::sanearStrings($values);
            //Creamos un usuario
            $usuario = new User();
            $usuario->setName($filtrado["name"]);
            $usuario->setSurname($filtrado["surname"]);
            $usuario->setPhone($filtrado["phone"]);
            $usuario->setEmail($filtrado["email"]);
            $usuario->setLogiN($filtrado['login']);
            $usuario->setPassword($filtrado["password"]);
            $usuario->setUuid(RegularUtils::uuid());
            $usuario->setUserRole(ROLES['USER']);

            $save = $this->userModel->create($usuario);
            if ($save != 1) {
                $errors['createUser']['query'] = $save;
            } else {
                // si todo ha ido correcto, nos vamos a la web principal
                $this->redirect("session", "login");
            }
        }
        if (isset($errors["createUser"])) {
            //Conseguimos todos los usuarios
            //Cargamos la vista index y le pasamos valores
            $this->view("login", array(
                "title" => "login",
                "errors" => $errors
            ));
        }
    }

    /**
     * Actualización de usuario 
     */
    public function updateProfile() {
        $values = array("uuid" => "text", "name" => "text", "surname" => "text",
            "phone" => "phone", "password" => "text");
        $errors[$_POST['uuid']] = RegularUtils::filtrarPorTipo($values, "updateUser");
        $noRequired = array("name", "surname", "phone", "password");
        $errors[$_POST['uuid']] = RegularUtils::camposNoRequeridos($errors[$_POST['uuid']], "updateUser", $noRequired);
        if (!isset($errors[$_POST['uuid']])) {
            $values = array("name", "surname", "password", "uuid", "phone");
            $filtrado = RegularUtils::sanearStrings($values);
//Creamos un usuario
            $usuario = new User();
            $usuario->setUuid($filtrado['uuid']);
            if (isset($filtrado["name"]) && trim($filtrado["name"]) != "") {
                $usuario->setName($filtrado['name']);
            }
            if (isset($filtrado["surname"]) && trim($filtrado["name"]) != "") {
                $usuario->setSurname($filtrado["surname"]);
            }
            if (isset($filtrado["phone"]) && trim($filtrado["phone"]) != "") {
                $usuario->setPhone($filtrado["phone"]);
            }
            if (isset($filtrado["password"]) && trim($filtrado["password"]) != "") {
                $usuario->setPassword($filtrado["password"]);
            }
            $save = $this->userModel->update($usuario);
            if ($save != 1) {
                $errors['updateUser'][$_POST['uuid']]['query'] = "error_update_user";
            } else {
                $this->redirect("user", "readUser", array("uuid" => $_POST['uuid']));
            }
        } else {
            $this->redirect("user", "readUser", array("uuid" => $_POST['uuid'], "errors" => $errors));
        }
    }

}
