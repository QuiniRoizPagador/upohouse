<?php

use core\AbstractController;

/**
 * Controladora de webservice encargada de atendes peticiones ajax 
 */
class WSController extends AbstractController {

    private $userModel;
    private $municipalityModel;
    private $adModel;
    private $housingTypeModel;
    private $commentModel;
    private $reportModel;
    private $operationTypeModel;
    private $requestModel;

    /**
     * Método constructor
     */
    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->provinceModel = new ProvinceModel();
        $this->municipalityModel = new MunicipalityModel();
        $this->adModel = new AdModel();
        $this->commentModel = new CommentModel();
        $this->housingTypeModel = new HousingTypeModel();
        $this->operationTypeModel = new OperationTypeModel();
        $this->reportModel = new ReportModel();
        $this->requestModel = new RequestModel();
    }

    /**
     * Método de búsqueda global. recibirá lo escrito por el usuario y realizará una búsqueda
     * global en la base de datos para devolver en formato JSON.
     */
    public function globalSearch() {
        if (filter_has_var(INPUT_POST, "str") && trim($_POST['str']) != "") {
            $str = filter_var($_POST['str'], FILTER_SANITIZE_STRING);
            $list = $this->adModel->globalSearch($str);
            header('Content-type: application/json');
            echo json_encode($list);
        } else {
            $this->redirect();
        }
    }

    /**
     * Método que recibe el número de página de la tabla de usuarios del administrador
     * y devuelve los usuarios correspondientes.
     */
    public function paginateUsers() {
        if (filter_has_var(INPUT_POST, "userPag") && trim($_POST['userPag']) != "") {
            $num = filter_var($_POST['userPag'], FILTER_SANITIZE_NUMBER_INT);
            $allusers = $this->userModel->getAllPaginated($num);
            header('Content-type: application/json');
            echo json_encode($allusers);
        } else {
            $this->redirect();
        }
    }

    public function paginateAds() {
        if (filter_has_var(INPUT_POST, "adPag")) {
            $num = filter_var($_POST['adPag'], FILTER_SANITIZE_NUMBER_INT);
            $allAds = $this->adModel->getAllPaginated($num);
            header('Content-type: application/json');
            echo json_encode($allAds);
        } else {
            $this->redirect();
        }
    }

    public function provincesByCommunity() {
        if (filter_has_var(INPUT_POST, "communityId")) {
            $communityId = filter_var($_POST['communityId'], FILTER_SANITIZE_NUMBER_INT);
            $allProvinces = $this->provinceModel->search('community_id', $communityId);
            header('Content-type: application/json');
            echo json_encode($allProvinces);
        } else {
            $this->redirect();
        }
    }

    public function municipalitiesByProvince() {
        if (filter_has_var(INPUT_POST, "provinceId")) {
            $provinceId = filter_var($_POST['provinceId'], FILTER_SANITIZE_NUMBER_INT);
            $allProvinces = $this->municipalityModel->search('province_id', $provinceId);
            header('Content-type: application/json');
            echo json_encode($allProvinces);
        } else {
            $this->redirect();
        }
    }

    /**
     * Método que llama a la paginación de comentarios
     */
    public function paginateComments() {
        if (filter_has_var(INPUT_POST, "commentPag")) {
            $num = filter_var($_POST['commentPag'], FILTER_SANITIZE_NUMBER_INT);
            $allComments = $this->commentModel->getAllPaginated($num);
            header('Content-type: application/json');
            echo json_encode($allComments);
        } else {
            $this->redirect();
        }
    }

    /**
     * Método que llama a la paginación de tipos de casas
     */
    public function paginateHousingTypes() {
        if (filter_has_var(INPUT_POST, "housingTypePag")) {
            $num = filter_var($_POST['housingTypePag'], FILTER_SANITIZE_NUMBER_INT);
            $allHousingTypes = $this->housingTypeModel->getAllPaginated($num);
            header('Content-type: application/json');
            echo json_encode($allHousingTypes);
        } else {
            $this->redirect();
        }
    }

    /**
     * Método que llama a la paginación de tipos de operaciones
     */
    public function paginateOperationTypes() {
        if (filter_has_var(INPUT_POST, "operationTypePag")) {
            $num = filter_var($_POST['operationTypePag'], FILTER_SANITIZE_NUMBER_INT);
            $allOperationTypes = $this->operationTypeModel->getAllPaginated($num);
            header('Content-type: application/json');
            echo json_encode($allOperationTypes);
        } else {
            $this->redirect();
        }
    }

    /**
     * Método que llama a la paginación de usuarios denunciados
     */
    public function paginateReportsUser() {
        if (filter_has_var(INPUT_POST, "reportsUserPag")) {
            $num = filter_var($_POST['reportsUserPag'], FILTER_SANITIZE_NUMBER_INT);
            $allReportsUsers = $this->reportModel->getAllReportUserPaginated($num);
            header('Content-type: application/json');
            echo json_encode($allReportsUsers);
        } else {
            $this->redirect();
        }
    }

    /**
     * Método que llama a la paginación de anuncios denunciados
     */
    public function paginateReportsAd() {
        if (filter_has_var(INPUT_POST, "reportsAdPag")) {
            $num = filter_var($_POST['reportsAdPag'], FILTER_SANITIZE_NUMBER_INT);
            $allReportsAds = $this->reportModel->getAllReportAdPaginated($num);
            header('Content-type: application/json');
            echo json_encode($allReportsAds);
        } else {
            $this->redirect();
        }
    }

    /**
     * Método que llama a la paginación de comentarios denunciados
     */
    public function paginateReportsComment() {
        if (filter_has_var(INPUT_POST, "reportsCommentPag")) {
            $num = filter_var($_POST['reportsCommentPag'], FILTER_SANITIZE_NUMBER_INT);
            $allReportsComments = $this->reportModel->getAllReportCommentPaginated($num);
            header('Content-type: application/json');
            echo json_encode($allReportsComments);
        } else {
            $this->redirect();
        }
    }

    /**
     * Método que llama a la paginación de peticiones denunciadas
     */
    public function paginateReportsRequest() {
        if (filter_has_var(INPUT_POST, "reportsRequestPag")) {
            $num = filter_var($_POST['reportsRequestPag'], FILTER_SANITIZE_NUMBER_INT);
            $allReportsRequests = $this->reportModel->getAllReportRequestPaginated($num);
            header('Content-type: application/json');
            echo json_encode($allReportsRequests);
        } else {
            $this->redirect();
        }
    }

    /**
     * Método que llama a la paginación de peticiones
     */
    public function paginateRequests() {
        if (filter_has_var(INPUT_POST, 'pag')) {
            $pag = filter_var($_POST['pag'], FILTER_SANITIZE_NUMBER_INT);
            $user = $this->userModel->read($_SESSION['id']);
            $requests = $this->requestModel->listUserRequest($user, $pag);
            header('Content-type: application/json');
            echo json_encode($requests);
        } else {
            $this->redirect();
        }
    }

    /**
     * Método que llama a la paginación de los comentarios de un anuncio concreto
     */
    public function paginateCommentsAd() {
        if (filter_has_var(INPUT_POST, 'commentsAdPag') && filter_has_var(INPUT_POST, 'uuid')) {
            $pag = filter_var($_POST['commentsAdPag'], FILTER_SANITIZE_NUMBER_INT);
            $uuid = filter_var($_POST["uuid"], FILTER_SANITIZE_STRING);
            $ad = $this->adModel->read($uuid);
            $comments = $this->commentModel->getComments($ad->id, $pag);
            header('Content-type: application/json');
            echo json_encode($comments);
        } else {
            $this->redirect();
        }
    }

}
