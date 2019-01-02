<?php

use core\AbstractController;

class WSController extends AbstractController {

    private $userModel;
    private $provincesModel;
    private $municipalityModel;
            
    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->provinceModel = new ProvinceModel();
        $this->municipalityModel = new MunicipalityModel();
    }

    /*public function prueba() {
        // TODO: controlar encapsulando solo los atributos necesarios por seguridad
        if (filter_has_var(INPUT_POST, "nombre")) {
            $nombre = $this->userModel->sanearStrings(array('nombre'))['nombre'];
            echo json_encode(array($this->userModel->search("nombre", $nombre)));
        } else {
            $this->redirect();
        }
    }*/

    public function paginateUsers() {
        if (filter_has_var(INPUT_POST, "userPag")) {
            $num = filter_var($_POST['userPag'], FILTER_SANITIZE_NUMBER_INT);
            $allusers = $this->userModel->getAllPaginated($num);
            echo json_encode($allusers);
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

}
