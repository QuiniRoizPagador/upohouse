<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/User.php';
require_once 'model/dao/dto/Housing_type.php';
require_once 'model/dao/dto/Operation_type.php';
require_once 'model/dao/dto/Report.php';
require_once 'model/dao/dto/Request.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\User;
use model\dao\dto\Housing_type;
use model\dao\dto\Operation_type;
use model\dao\dto\Report;
use model\dao\dto\Request;

class AdminController extends AbstractController {

    private $userModel;
    private $commentModel;
    private $housingTypeModel;
    private $reportModel;
    private $operationTypeModel;
    private $requestModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->adModel = new AdModel();
        $this->commentModel = new CommentModel();
        $this->housingTypeModel = new HousingTypeModel();
        $this->reportModel = new ReportModel();
        $this->operationTypeModel = new OperationTypeModel();
        $this->requestModel = new RequestModel();
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
            case "comentarios":
                $this->comments($errors, $show, $pag);
                break;
            case "tipos":
                $this->types($errors, $show, $pag);
                break;
            case "denuncias":
                $this->reports($errors, $show, $pag);
                break;
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
            'title' => "dashboard",
            "allAds" => $allAds,
            "numAds" => $numAds,
            "errors" => $errors,
            "show" => $show
        ));
    }

    private function users($errors, $show, $pag = NULL) {
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
            'title' => "dashboard",
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

                $this->redirect("admin", "dashboard", array("show" => "$show"));
            }
        }
        if (isset($errors["createUser"])) {
//Conseguimos todos los usuarios
            $numUsers = $this->userModel->countUsers();
            $allusers = $this->userModel->getAllPaginated(0);

//Cargamos la vista index y le pasamos valores
            $this->view("dashboard", array(
                'title' => "dashboard",
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
            if (isset($filtrado["password"]) && trim($filtrado["password"]) != "") {
                $usuario->setPassword($filtrado["password"]);
            }
            $save = $this->userModel->update($usuario);
            if ($save != 1) {
                $errors['updateUser'][$_POST['uuid']]['query'] = "error_update_user";
            } else {
                $this->redirect("admin", "dashboard", array("show" => "$show"));
            }
        } else {
            if (isset($_POST['pag'])) {
                $pag = $_POST['pag'];
            } else {
                $pag = NULL;
            }
            $this->dashboard($errors, $pag);
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
            $this->redirect("admin", "dashboard", array("show" => "$show"));
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
            $this->redirect("admin", "dashboard", array("show" => "$show"));
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
            $this->redirect("admin", "dashboard", array("show" => "$show"));
        }
    }

    public function removeComment() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid")) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->commentModel->delete($id);
            if ($rem == 0) {
                $errors['removeComment']['uuid'] = "requerido";
            }
        } else {
            $errors['removeComment']['uuid'] = "requerido";
        }
        if (isset($errors['removeComment'])) {
            $this->dashboard($errors);
        } else {
            $this->redirect("admin", "dashboard", array("show" => "$show"));
        }
    }

    public function createHousingTypes() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        $values = array("name" => "text");
        $errors = RegularUtils::filtrarPorTipo($values, "createHousingTypes");
        if (!isset($errors["createHousingTypes"])) {
            $values = array("name");
            $filtrado = RegularUtils::sanearStrings($values);

//Creamos un tipo de vivienda
            $housingType = new Housing_type();
            $housingType->setName($filtrado["name"]);
            $housingType->setUuid(RegularUtils::uuid());

            $save = $this->housingTypeModel->create($housingType);
            if ($save != 1) {
                $errors['createHousingTypes']['query'] = $save;
            } else {
// si todo ha ido correcto, nos vamos a la web principal

                $this->redirect("admin", "dashboard", array("show" => "$show"));
            }

            if (isset($errors["createHousingTypes"])) {
//Conseguimos todos los tipos de vivienda
                $numHousingTypes = $this->housingTypeModel->countHousingTypes(FALSE);
                $allHousingTypes = $this->housingTypeModel->getAllPaginated(0);
//Cargamos la vista index y le pasamos valores
                $this->view("dashboard", array(
                    'title' => "dashboard",
                    "allHousingTypes" => $allHousingTypes,
                    "numHousingTypes" => $numHousingTypes,
                    "errors" => $errors,
                    "show" => $show
                ));
            }
        }
    }

    public function createOperationTypes() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        $values = array("name" => "text");
        $errors = RegularUtils::filtrarPorTipo($values, "createOperationTypes");
        if (!isset($errors["createOperationTypes"])) {
            $values = array("name");
            $filtrado = RegularUtils::sanearStrings($values);

//Creamos un tipo de vivienda
            $operationType = new Housing_type();
            $operationType->setName($filtrado["name"]);
            $operationType->setUuid(RegularUtils::uuid());

            $save = $this->operationTypeModel->create($operationType);
            if ($save != 1) {
                $errors['createOperationTypes']['query'] = $save;
            } else {
// si todo ha ido correcto, nos vamos a la web principal

                $this->redirect("admin", "dashboard", array("show" => "$show"));
            }

            if (isset($errors["createOperationTypes"])) {
//Conseguimos todos los tipos de vivienda
                $numOperationTypes = $this->operationTypeModel->countOperationTypes(FALSE);
                $allOperationTypes = $this->operationTypeModel->getAllPaginated(0, FALSE);
//Cargamos la vista index y le pasamos valores
                $this->view("dashboard", array(
                    'title' => "P&aacute;gina de Gesti&oacute;n",
                    "allOperationTypes" => $allOperationTypes,
                    "numOperationTypes" => $numOperationTypes,
                    "errors" => $errors,
                    "show" => $show
                ));
            }
        }
    }

    public function removeHousingType() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid")) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->housingTypeModel->delete($id);
            if ($rem == 0) {
                $errors['removeHousingType']['uuid'] = "requerido";
            }
        } else {
            $errors['removeHousingType']['uuid'] = "requerido";
        }
        if (isset($errors['removeHousingType'])) {
            $this->dashboard($errors);
        } else {
            $this->redirect("admin", "dashboard", array("show" => "$show"));
        }
    }

    public function removeOperationType() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid")) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->operationTypeModel->delete($id);
            if ($rem == 0) {
                $errors['removeOperationType']['uuid'] = "requerido";
            }
        } else {
            $errors['removeOperationType']['uuid'] = "requerido";
        }
        if (isset($errors['removeOperationType'])) {
            $this->dashboard($errors);
        } else {
            $this->redirect("admin", "dashboard", array("show" => "$show"));
        }
    }

    public function updateHousingTypes() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        $values = array("uuid" => "text", "name" => "text");
        $errors[$_POST['uuid']] = RegularUtils::filtrarPorTipo($values, "updateHousingTypes");

        if (!isset($errors[$_POST['uuid']])) {
            $values = array("name", "uuid");
            $filtrado = RegularUtils::sanearStrings($values);

            //Creamos un tipo de vivienda
            $housingType = new Housing_type();
            $housingType->setUuid($filtrado['uuid']);
            if (isset($filtrado["name"]) && trim($filtrado["name"]) != "") {
                $housingType->setName($filtrado['name']);
            }
            $save = $this->housingTypeModel->update($housingType);

            if ($save != 1) {
                $errors['updateHousingTypes'][$_POST['uuid']]['query'] = "error_update_housingType";
            } else {
                $this->redirect("admin", "dashboard", array("show" => "$show"));
            }
        } else {
            if (isset($_POST['pag'])) {
                $pag = $_POST['pag'];
            } else {
                $pag = NULL;
            }
            $this->dashboard($errors, $pag);
        }
    }

    public function updateOperationTypes() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        $values = array("uuid" => "text", "name" => "text");
        $errors[$_POST['uuid']] = RegularUtils::filtrarPorTipo($values, "updateOperationTypes");

        if (!isset($errors[$_POST['uuid']])) {
            $values = array("name", "uuid");
            $filtrado = RegularUtils::sanearStrings($values);

            //Creamos un tipo de vivienda
            $operationType = new Operation_type();
            $operationType->setUuid($filtrado['uuid']);
            if (isset($filtrado["name"]) && trim($filtrado["name"]) != "") {
                $operationType->setName($filtrado['name']);
            }
            $save = $this->operationTypeModel->update($operationType);

            if ($save != 1) {
                $errors['updateOperationTypes'][$_POST['uuid']]['query'] = "error_update_operationType";
            } else {
                $this->redirect("admin", "dashboard", array("show" => "$show"));
            }
        } else {
            if (isset($_POST['pag'])) {
                $pag = $_POST['pag'];
            } else {
                $pag = NULL;
            }
            $this->dashboard($errors, $pag);
        }
    }

    private function comments($errors, $show, $pag) {
        if ($pag == NULL) {
            $pag = 0;
        }

        $numComments = $this->commentModel->countComments(FALSE);
        $allComments = $this->commentModel->getAllPaginated(0, FALSE);
        $countComments = $this->commentModel->countRegistrationComments(FALSE);

        $this->view("dashboard", array(
            'title' => "dashboard",
            "allComments" => $allComments,
            "numComments" => $numComments,
            "countComments" => $countComments,
            "show" => $show,
            "pag" => $pag,
        ));
    }

    private function types($errors, $show, $pag) {
        if ($pag == NULL) {
            $pag = 0;
        }
        $numHousingTypes = $this->housingTypeModel->countHousingTypes(FALSE);
        $allHousingTypes = $this->housingTypeModel->getAllPaginated(0, FALSE);
        $numOperationTypes = $this->operationTypeModel->countOperationTypes(FALSE);
        $allOperationTypes = $this->operationTypeModel->getAllPaginated(0, FALSE);
        $this->view("dashboard", array(
            'title' => "dashboard",
            "numHousingTypes" => $numHousingTypes,
            "allHousingTypes" => $allHousingTypes,
            "numOperationTypes" => $numOperationTypes,
            "allOperationTypes" => $allOperationTypes,
            "show" => $show,
            "pag" => $pag,
        ));
    }

    private function reports($errors, $show, $pag) {
        if ($pag == NULL) {
            $pag = 0;
        }

        $allReportsUsers = $this->reportModel->getAllReportUserPaginated(0, FALSE);
        $numReportsUsers = $this->reportModel->countReportUsers(FALSE);
        $allReportsAds = $this->reportModel->getAllReportAdPaginated(0, FALSE);
        $numReportsAds = $this->reportModel->countReportAds(FALSE);
        $allReportsComments = $this->reportModel->getAllReportCommentPaginated(0, FALSE);
        $numReportsComments = $this->reportModel->countReportComments(FALSE);
        $allReportsRequests = $this->reportModel->getAllReportRequestPaginated(0, FALSE);
        $numReportsRequests = $this->reportModel->countReportRequests(FALSE);

        $this->view("dashboard", array(
            'title' => "dashboard",
            "numReportsUsers" => $numReportsUsers,
            "allReportsUsers" => $allReportsUsers,
            "numReportsAds" => $numReportsAds,
            "allReportsAds" => $allReportsAds,
            "numReportsComments" => $numReportsComments,
            "allReportsComments" => $allReportsComments,
            "numReportsRequests" => $numReportsRequests,
            "allReportsRequests" => $allReportsRequests,
            "show" => $show,
            "pag" => $pag,
        ));
    }

    public function acceptReportComment() {

        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid") && filter_has_var(INPUT_POST, "comment_uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->reportModel->modifyState($id, "Aceptar");
            //$rem = $this->commentModel->block($id);
            if ($rem == 0) {
                $errors['acceptReportComment'][$_POST['uuid']]['query'] = "error_accept_report";
            }
        }
        if (isset($errors['acceptReportComment'])) {
            $this->dashboard($errors);
        } else {
            $id = RegularUtils::sanearStrings(array('comment_uuid'))['comment_uuid'];
            $rem = $this->commentModel->removeComment($id);
            if ($rem == 0) {
                $errors['acceptReportComment'][$_POST['comment_uuid']]['query'] = "error_block_comment";
                $this->dashboard($errors);
            } else {
                $this->redirect("admin", "dashboard", array("show" => "$show"));
            }
        }
    }

    public function denyReportComment() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid") && filter_has_var(INPUT_POST, "comment_uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->reportModel->modifyState($id, "Denegar");
            //$rem = $this->commentModel->block($id);
            if ($rem == 0) {
                $errors['denyReportComment'][$_POST['uuid']]['query'] = "error_deny_report";
            }
        }
        if (isset($errors['denyReportComment'])) {
            $this->dashboard($errors);
        } else {
            $this->redirect("admin", "dashboard", array("show" => "$show"));
        }
    }

    public function acceptReportRequest() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid") && filter_has_var(INPUT_POST, "request_uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->reportModel->modifyState($id, "Aceptar");
            if ($rem == 0) {
                $errors['acceptReportRequest'][$_POST['uuid']]['query'] = "error_accept_report";
            }
        }
        if (isset($errors['acceptReportRequest'])) {
            $this->dashboard($errors);
        } else {
            $id = RegularUtils::sanearStrings(array('request_uuid'))['request_uuid'];
            $rem = $this->requestModel->removeRequest($id);
            if ($rem == 0) {
                $errors['acceptReportRequest'][$_POST['request_uuid']]['query'] = "error_block_request";
                $this->dashboard($errors);
            } else {
                $this->redirect("admin", "dashboard", array("show" => "$show"));
            }
        }
    }

    public function denyReportRequest() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid") && filter_has_var(INPUT_POST, "request_uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->reportModel->modifyState($id, "Denegar");
            if ($rem == 0) {
                $errors['denyReportRequest'][$_POST['uuid']]['query'] = "error_deny_report";
            }
        }
        if (isset($errors['denyReportRequest'])) {
            $this->dashboard($errors);
        } else {
            $this->redirect("admin", "dashboard", array("show" => "$show"));
        }
    }

    public function acceptReportAd() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid") && filter_has_var(INPUT_POST, "ad_uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->reportModel->modifyState($id, "Aceptar");
            //$rem = $this->commentModel->block($id);
            if ($rem == 0) {
                $errors['acceptReportAd'][$_POST['uuid']]['query'] = "error_accept_report";
            }
        }
        if (isset($errors['acceptReportAd'])) {
            $this->dashboard($errors);
        } else {
            $id = RegularUtils::sanearStrings(array('ad_uuid'))['ad_uuid'];
            $rem = $this->adModel->block($id);
            if ($rem == 0) {
                $errors['acceptReportAd'][$_POST['ad_uuid']]['query'] = "error_block_ad";
                $this->dashboard($errors);
            } else {
                $this->redirect("admin", "dashboard", array("show" => "$show"));
            }
        }
    }

    public function denyReportAd() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid") && filter_has_var(INPUT_POST, "ad_uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->reportModel->modifyState($id, "Denegar");
            //$rem = $this->commentModel->block($id);
            if ($rem == 0) {
                $errors['denyReportAd'][$_POST['uuid']]['query'] = "error_deny_report";
            }
        }
        if (isset($errors['denyReportAd'])) {
            $this->dashboard($errors);
        } else {
            $this->redirect("admin", "dashboard", array("show" => "$show"));
        }
    }

    public function acceptReportUser() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid") && filter_has_var(INPUT_POST, "user_uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->reportModel->modifyState($id, "Aceptar");
            //$rem = $this->commentModel->block($id);
            if ($rem == 0) {
                $errors['acceptReportUser'][$_POST['uuid']]['query'] = "error_accept_report";
            }
        }
        if (isset($errors['acceptReportUser'])) {
            $this->dashboard($errors);
        } else {
            $id = RegularUtils::sanearStrings(array('user_uuid'))['user_uuid'];
            $rem = $this->userModel->block($id);
            if ($rem == 0) {
                $errors['acceptReportUser'][$_POST['user_uuid']]['query'] = "error_block_user";
                $this->dashboard($errors);
            } else {
                $this->redirect("admin", "dashboard", array("show" => "$show"));
            }
        }
    }

    public function denyReportUser() {
        $show = null;
        if (isset($_GET["show"])) {
            $show = $_GET["show"];
        }
        if (filter_has_var(INPUT_POST, "uuid") && filter_has_var(INPUT_POST, "user_uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->reportModel->modifyState($id, "Denegar");
            //$rem = $this->commentModel->block($id);
            if ($rem == 0) {
                $errors['denyReportUser'][$_POST['uuid']]['query'] = "error_deny_report";
            }
        }
        if (isset($errors['denyReportUser'])) {
            $this->dashboard($errors);
        } else {
            $this->redirect("admin", "dashboard", array("show" => "$show"));
        }
    }

}
