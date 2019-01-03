<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/User.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\User;

class AdminController extends AbstractController {

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    /**
     * Página principal del usuario
     */
    public function dashboard($errors = NULL) {
        //TODO: según el usuario se mostrará la dashboard del admin 
        // por defecto o su página de administración básica
        //Conseguimos todos los usuarios
        $numUsers = $this->userModel->countUsers(FALSE);
        $allusers = $this->userModel->getAllPaginated(0, FALSE);
        $countRegistrations = $this->userModel->countRegistrations();
        //Cargamos la vista index y le pasamos valores
        $this->view("dashboard", array(
            'title' => "P&aacute;gina de Gesti&oacute;n",
            "allusers" => $allusers,
            "numUsers" => $numUsers,
            "errors" => $errors,
            "countRegistrations" => $countRegistrations,
        ));
    }

    /**
     * Creación de un usuario por parte del admin
     */
    public function createUser() {
        $values = array("name" => "text", "login" => "text", "surname" => "text",
            "email" => "email", "password" => "text", "password2" => "text",
            "phone" => "phone", "user_role" => 'number');
        $errors = RegularUtils::filtrarPorTipo($values, "createUser");
        if ($_POST['password'] != $_POST['password2']) {
            $errors["createUser"]["password"] = $errors["createUser"]["password2"] = "no_match";
        }
        if (!isset($errors["createUser"]) && $_POST['password'] == $_POST['password2']) {
            $values = array("name", "login", "surname",
                "email", "password",
                "user_role", "phone");
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
            $usuario->setUserRole($filtrado["user_role"]);

            $save = $this->userModel->create($usuario);
            if ($save !== 1) {
                $errors['createUser']['query'] = $save;
            } else {
                // si todo ha ido correcto, nos vamos a la web principal
                $this->redirect("Admin", "dashboard");
            }
        }
        if (isset($errors["createUser"])) {
            //Conseguimos todos los usuarios
            $numUsers = $this->userModel->countUsers(FALSE);
            $allusers = $this->userModel->getAllPaginated(0);

            //Cargamos la vista index y le pasamos valores
            $this->view("dashboard", array(
                'title' => "P&aacute;gina de Gesti&oacute;n",
                "allusers" => $allusers,
                "numUsers" => $numUsers,
                "errors" => $errors
            ));
        }
    }

    /**
     * Actualización de usuario 
     */
    public function updateUser() {
        $values = array("uuid" => "text", "user_role" => "number");
        $errors = RegularUtils::filtrarPorTipo($values, "actualizar");
        if (!isset($errors['actualizar'])) {
            $errors = array();
        }
        if (!isset($errors["actualizar"]) && filter_var($_POST["user_role"], FILTER_VALIDATE_INT, array("options" => array("min_range" => 0, "max_range" => 1))) === false) {
            $errors = array_merge($errors, array($_POST['uuid'] => array("user_role" => "formato_incorrecto")));
        }
        if (!isset($errors["actualizar"]) && !isset($errors[$_POST['uuid']])) {
            $errors = array();
            if (isset($_POST['name']) && $_POST['name'] != "") {
                $nameErrors = RegularUtils::filtrarPorTipo(array("name" => "text"), $_POST['uuid']);
                if (isset($nameErrors[$_POST['uuid']])) {
                    $errors = array_merge($errors, $nameErrors);
                }
            }

            if (isset($_POST['surname']) && $_POST['surname'] != "") {
                $surnameErrors = RegularUtils::filtrarPorTipo(array("surname" => "text"), $_POST['uuid']);
                if (isset($surnameErrors[$_POST['uuid']])) {
                    $errors = array_merge($errors, $surnameErrors);
                }
            }

            if (isset($_POST['phone']) && $_POST['phone'] != "") {
                $phoneErrors = RegularUtils::filtrarPorTipo(array("phone" => "phone"), $_POST['uuid']);
                if (isset($phoneErrors[$_POST['uuid']])) {
                    $errors = array_merge($errors, $phoneErrors);
                }
            }

            if (isset($_POST['password']) && $_POST['password'] != "") {
                $passwordErrors = RegularUtils::filtrarPorTipo(array("password" => "text"), $_POST['uuid']);
                if (isset($passwordErrors[$_POST['uuid']])) {
                    $errors = array_merge($errors, $passwordErrors);
                }
            }
        }
        if (!isset($errors["actualizar"]) && !isset($errors[$_POST['uuid']])) {
            $values = array("name", "surname", "password", "uuid", "user_role", "phone");
            $filtrado = RegularUtils::sanearStrings($values);
            //Creamos un usuario
            $usuario = new User();
            $usuario->setUuid($filtrado['uuid']);
            $usuario->setUserRole($filtrado['user_role']);
            if (isset($filtrado["name"]) && trim($filtrado["name"]) != "") {
                $usuario->setName($filtrado['name']);
            }
            if (isset($filtrado["surname"]) && trim($filtrado["name"]) != "") {
                $usuario->setSurname($filtrado["surname"]);
            }
            if (isset($filtrado["phone"]) && trim($filtrado["phone"]) != "") {
                $usuario->setPhone($filtrado["phone"]);
            }
            if (isset($filtrado["password"]) && trim($filtrado["name"]) != "") {
                $usuario->setPassword($filtrado["password"]);
            }
            $save = $this->userModel->update($usuario);
            if ($save == 0) {
                die("Error al insertar usuario");
            } else {
                $this->redirect("Admin", "dashboard");
            }
        } else {
            $this->dashboard($errors);
        }
    }

    public function blockUser() {
        if (filter_has_var(INPUT_POST, "uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->userModel->block($id);
            if ($rem == 0) {
                die("Error al bloquear usuario");
            }
        }
        $this->redirect("Admin", "dashboard");
    }

    public function removeUser() {
        if (filter_has_var(INPUT_POST, "uuid")) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->userModel->delete($id);
            if ($rem == 0) {
                die("Error al eliminar usuario");
            }
        }
        $this->redirect("Admin", "dashboard");
    }

}
