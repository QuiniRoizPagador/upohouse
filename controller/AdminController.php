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
        $this->adModel = new AdModel();
    }

    /**
     * Página principal del usuario
     */
    public function dashboard($errors = NULL, $pag = NULL) {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        switch ($show) {
            case "ads":
                $this->ads($errors, $show);
                break;
            case "users":
            default:
                $this->users($errors, $show, $pag);
        }
    }

    private function ads($errors, $show) {
        //TODO: según el usuario se mostrará la dashboard del admin 
        // por defecto o su página de administración básica
        //Conseguimos todos los anuncios.
        $numAds = $this->adModel->countAds();
        $allAds = $this->adModel->getAllPaginated();
        //Cargamos la vista index y le pasamos valores
        $this->view("dashboard", array(
            'title' => "P&aacute;gina de Gesti&oacute;n",
            "allAds" => $allAds,
            "numAds" => $numAds,
            "errors" => $errors,
            "show" => $show
        ));
    }

    private function users($errors, $show, $pag) {
        //TODO: según el usuario se mostrará la dashboard del admin 
        // por defecto o su página de administración básica
        //Conseguimos todos los usuarios
        if ($pag == NULL) {
            $pag = 0;
        }
        $numUsers = $this->userModel->countUsers();
        $allusers = $this->userModel->getAllPaginated($pag);
        $countRegistrations = $this->userModel->countRegistrations();
        //Cargamos la vista index y le pasamos valores
        $this->view("dashboard", array(
            'title' => "P&aacute;gina de Gesti&oacute;n",
            "allusers" => $allusers,
            "numUsers" => $numUsers,
            "errors" => $errors,
            "countRegistrations" => $countRegistrations,
            "show" => $show,
            "pag" => $pag,
        ));
    }

    public function createUser() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
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
            if ($save != 1) {
                $errors['createUser']['query'] = $save;
            } else {
                // si todo ha ido correcto, nos vamos a la web principal
                $this->redirect("Admin", "dashboard", array("show" => "$show"));
            }
        }
        if (isset($errors["createUser"])) {
            //Conseguimos todos los usuarios
            $numUsers = $this->userModel->countUsers();
            $allusers = $this->userModel->getAllPaginated(0);

            //Cargamos la vista index y le pasamos valores
            $this->view("dashboard", array(
                'title' => "P&aacute;gina de Gesti&oacute;n",
                "allusers" => $allusers,
                "numUsers" => $numUsers,
                "errors" => $errors,
                "show" => $show
            ));
        }
    }

    /**
     * Actualización de usuario 
     */
    public function updateUser() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        $values = array("uuid" => "text", "user_role" => "number", "name" => "text", "surname" => "text",
            "phone" => "phone", "password" => "text");
        $errors[$_POST['uuid']] = RegularUtils::filtrarPorTipo($values, "updateUser");
        $noRequired = array("name", "surname", "phone", "password");
        $errors[$_POST['uuid']] = RegularUtils::camposNoRequeridos($errors[$_POST['uuid']], "updateUser", $noRequired);
        if (!isset($errors["updateUser"]) && filter_var($_POST["user_role"], FILTER_VALIDATE_INT, array("options" => array("min_range" => 0, "max_range" => 1))) === false) {
            $errors = array_merge($errors, array($_POST['uuid'] => array("user_role" => "formato_incorrecto")));
        }
        if (!isset($errors[$_POST['uuid']])) {
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
            if ($save != 1) {
                $errors['updateUser'][$_POST['uuid']]['query'] = "error_update_user";
            } else {
                $this->redirect("Admin", "dashboard", array("show" => "$show"));
            }
        } else {
            $this->dashboard($errors, $_POST['pag']);
        }
    }

    public function blockUser() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->userModel->block($id);
            if ($rem == 0) {
                $errors['blockUser'][$_POST['uuid']]['query'] = "error_block_user";
            }
        } else {
            $errors['blockUser']['uuid'] = "requerido";
        }
        if (isset($errors['blockUser'])) {
            $this->dashboard($errors);
        } else {
            $this->redirect("Admin", "dashboard", array("show" => "$show"));
        }
    }

    public function unlockUser() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->userModel->unlock($id);
            if ($rem == 0) {
                $errors['unlockUser'][$_POST['uuid']]['query'] = "error_unlock_user";
            }
        } else {
            $errors['unlockUser']['uuid'] = "requerido";
        }
        if (isset($errors['unlockUser'])) {
            $this->dashboard($errors);
        } else {
            $this->redirect("Admin", "dashboard" . array("show" => "$show"));
        }
    }

    public function removeUser() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid")) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->userModel->delete($id);
            if ($rem == 0) {
                $errors['removeUser'][$_POST['uuid']]['query'] = "error_remove_user";
            }
        } else {
            $errors['removeUser']['uuid'] = "requerido";
        }
        if (isset($errors['removeUser'])) {
            $this->dashboard($errors);
        } else {
            $this->redirect("Admin", "dashboard", array("show" => "$show"));
        }
    }

}
