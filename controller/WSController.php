<?php

use core\AbstractController;

class WSController extends AbstractController {

    private $userModel;
    private $provincesModel;
    private $municipalityModel;
    private $adModel;
    private $housingTypeModel;
    private $commentModel;
    private $operationTypeModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->provinceModel = new ProvinceModel();
        $this->municipalityModel = new MunicipalityModel();
        $this->adModel = new AdModel();
        $this->commentModel = new CommentModel();
        $this->housingTypeModel = new HousingTypeModel();
        $this->operationTypeModel = new OperationTypeModel();
    }

    /* public function prueba() {
      // TODO: controlar encapsulando solo los atributos necesarios por seguridad
      if (filter_has_var(INPUT_POST, "nombre")) {
      $nombre = $this->userModel->sanearStrings(array('nombre'))['nombre'];
      echo json_encode(array($this->userModel->search("nombre", $nombre)));
      } else {
      $this->redirect();
      }
      } */

    public function paginateUsers() {
        if (filter_has_var(INPUT_POST, "userPag")) {
            $num = filter_var($_POST['userPag'], FILTER_SANITIZE_NUMBER_INT);
            $allusers = $this->userModel->getAllPaginated($num);
            echo json_encode($allusers);
        } else {
            $this->redirect();
        }
    }

    public function paginateAds() {
        if (filter_has_var(INPUT_POST, "adPag")) {
            $num = filter_var($_POST['adPag'], FILTER_SANITIZE_NUMBER_INT);
            $allAds = $this->adModel->getAllPaginated($num);
            echo json_encode($allAds);
        } else {
            $this->redirect();
        }
    }

    public function provincesByCommunity() {
        if (filter_has_var(INPUT_POST, "communityId")) {
            $communityId = filter_var($_POST['communityId'], FILTER_SANITIZE_NUMBER_INT);
            $allProvinces = $this->provinceModel->search('community_id', $communityId);
            echo json_encode($allProvinces);
        } else {
            $this->redirect();
        }
    }

    public function municipalitiesByProvince() {
        if (filter_has_var(INPUT_POST, "provinceId")) {
            $provinceId = filter_var($_POST['provinceId'], FILTER_SANITIZE_NUMBER_INT);
            $allProvinces = $this->municipalityModel->search('province_id', $provinceId);
            echo json_encode($allProvinces);
        } else {
            $this->redirect();
        }
    }

    public function paginateComments() {
        if (filter_has_var(INPUT_POST, "commentPag")) {
            $num = filter_var($_POST['commentPag'], FILTER_SANITIZE_NUMBER_INT);
            $allComments = $this->commentModel->getAllPaginated($num);
            echo json_encode($allComments);
        } else {
            $this->redirect();
        }
    }

    public function paginateHousingTypes() {
        if (filter_has_var(INPUT_POST, "housingTypePag")) {
            $num = filter_var($_POST['housingTypePag'], FILTER_SANITIZE_NUMBER_INT);
            $allHousingTypes = $this->housingTypeModel->getAllPaginated($num);
            echo json_encode($allHousingTypes);
        } else {
            $this->redirect();
        }
    }

    public function paginateOperationTypes() {
        if (filter_has_var(INPUT_POST, "operationTypePag")) {
            $num = filter_var($_POST['operationTypePag'], FILTER_SANITIZE_NUMBER_INT);
            $allOperationTypes = $this->operationTypeModel->getAllPaginated($num);
            echo json_encode($allOperationTypes);
        } else {
            $this->redirect();
        }
    }

}
