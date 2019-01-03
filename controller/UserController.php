<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/User.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\User;

class UserController extends AbstractController {

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
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
        if (filter_has_var(INPUT_POST, "uuid")) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $user = $this->userModel->read($id);
            if (!isset($user->id)) {
                $this->redirect("User", "index");
            } else {
                $this->view("perfil", array(
                    'title' => "Perfil $user->name",
                    "user" => $user
                ));
            }
        } else {
            $this->redirect("User", "index");
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
            if ($save !== 1) {
                $errors['createUser']['query'] = $save;
            } else {
                // si todo ha ido correcto, nos vamos a la web principal
                $this->redirect("Session", "login");
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

}
