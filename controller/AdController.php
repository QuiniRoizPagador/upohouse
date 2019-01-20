<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/Ad.php';
require_once 'model/dao/dto/Image.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\Ad;
use model\dao\dto\Image;

class AdController extends AbstractController {

    private $adModel;
    private $housingTypeModel;
    private $operationTypeModel;
    private $communityModel;
    private $provinceModel;
    private $municipalityModel;
    private $imageModel;

    public function __construct() {
        parent::__construct();
        $this->adModel = new AdModel();
        $this->housingTypeModel = new HousingTypeModel();
        $this->operationTypeModel = new OperationTypeModel();
        $this->communityModel = new CommunityModel();
        $this->provinceModel = new ProvinceModel();
        $this->municipalityModel = new MunicipalityModel();
        $this->imageModel = new ImageModel();
    }

    /**
     * Página para crear anuncio.
     */
    public function createView() {
        $allHousingTypes = $this->housingTypeModel->getAll();
        $allOperationTypes = $this->operationTypeModel->getAll();
        $allCommunities = $this->communityModel->getAll();
        //Cargamos la vista adView y le pasamos valores
        $this->view("createAd", array(
            'title' => "Crear un anuncio",
            'allHousingTypes' => $allHousingTypes,
            'allOperationTypes' => $allOperationTypes,
            'allCommunities' => $allCommunities
        ));
    }

    public function create() {
        $allHousingTypes = $this->housingTypeModel->getAll();
        $allOperationTypes = $this->operationTypeModel->getAll();
        $allCommunities = $this->communityModel->getAll();
        $values = array("housingType" => "text", "operationType" => "text", "price" => "float",
            "rooms" => "number", "m2" => "number", "bath" => "number", "images" => "image", "description" => "text", "community" => "number",
            "province" => "number", "municipality" => "number");
        $noRequired = array("images", "description");
        $errors = RegularUtils::filtrarPorTipo($values, "create");
        $errors = RegularUtils::camposNoRequeridos($errors, "create", $noRequired);
        if (!isset($errors["create"])) {
            $strValues = array("housingType", "operationType", "description");
            $intValues = array("rooms", "m2", "bath", "community", "province", "municipality");
            $fltValues = array("price");
            $strFiltrado = RegularUtils::sanearStrings($strValues);
            $intFiltrado = RegularUtils::sanearIntegers($intValues);
            $fltFiltrado = RegularUtils::sanearFloats($fltValues);
            $filtrado = array_merge($strFiltrado, $intFiltrado, $fltFiltrado);

            //Creamos un anuncio
            $ad = new Ad();
            $ad->setUuid(RegularUtils::uuid());
            $ad->setUser_id($_SESSION["id"]);
            $ad->setHousing_type($this->housingTypeModel->read($filtrado["housingType"], FALSE)->id);
            $ad->setOperation_type($this->operationTypeModel->read($filtrado["operationType"], FALSE)->id);
            $ad->setPrice($filtrado["price"]);
            $ad->setRooms($filtrado["rooms"]);
            $ad->setM_2($filtrado["m2"]);
            $ad->setBath($filtrado["bath"]);
            $ad->setDescription($filtrado['description']);
            $ad->setCommunity_id($filtrado["community"]);
            $ad->setProvince_id($filtrado["province"]);
            $ad->setMunicipality_id($filtrado["municipality"]);
            $ad->setState(1);
            $save = $this->adModel->create($ad);
            if ($save != 1) {
                $errors['create']['query'] = $save;
            } else {
                $id = $this->adModel->read($ad->getUuid())->id;
                $images = RegularUtils::saveAdImages("images", $ad->getUuid());
                foreach ($images as $image) {
                    $imgObj = new Image();
                    $imgObj->setUuid(RegularUtils::uuid());
                    $imgObj->setImage($image);
                    $imgObj->setAd_id($id);
                    $this->imageModel->create($imgObj);
                }
                // si todo ha ido correcto, nos vamos a la web principal
                $this->view("createAd", array(
                    'title' => "Crear un anuncio",
                    'allHousingTypes' => $allHousingTypes,
                    'allOperationTypes' => $allOperationTypes,
                    'allCommunities' => $allCommunities,
                    'success' => TRUE
                ));
            }
        }
        if (isset($errors["create"])) {
            //Cargamos la vista adView y le pasamos valores
            $this->view("createAd", array(
                'title' => "Crear un anuncio",
                'allHousingTypes' => $allHousingTypes,
                'allOperationTypes' => $allOperationTypes,
                'allCommunities' => $allCommunities,
                'errors' => $errors
            ));
        }
    }

    public function read() {
        if (filter_has_var(INPUT_GET, "uuid")) {
            $uuid = RegularUtils::sanearStrings(array('uuid'), 'GET')['uuid'];
            $ad = $this->adModel->read($uuid);
            if (!isset($ad->uuid)) {
                $this->redirect("User", "index");
            } else {
                $housingType = $this->housingTypeModel->read($ad->housing_type);
                $operationType = $this->operationTypeModel->read($ad->operation_type);
                $community = $this->communityModel->readId($ad->community_id);
                $province = $this->provinceModel->readId($ad->province_id);
                $municipality = $this->municipalityModel->readId($ad->municipality_id);
                $this->view("readAd", array(
                    'title' => "Anuncio",
                    "ad" => $ad,
                    "housingType" => $housingType,
                    "operationType" => $operationType,
                    "community" => $community,
                    "province" => $province,
                    "municipality" => $municipality,
                ));
            }
        } else {
            $this->redirect("User", "index");
        }
    }

    public function block() {
        if (filter_has_var(INPUT_GET, "uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'), 'GET')['uuid'];
            $rem = $this->adModel->block($id);
            if ($rem == 0) {
                die("Error al bloquear usuario");
            }
        }
        $this->redirect("Admin", "dashboard", array("show" => "ads"));
    }

    public function remove() {
        if (filter_has_var(INPUT_GET, "uuid")) {
            $id = RegularUtils::sanearStrings(array('uuid'), 'GET')['uuid'];
            $rem = $this->adModel->delete($id);
            if ($rem == 0) {
                die("Error al eliminar usuario");
            } else {
                RegularUtils::removeAdImages($id);
            }
        }
        $this->redirect("Admin", "dashboard", array("show" => "ads"));
    }

    public function paginate() {
        if (filter_has_var(INPUT_GET, 'query') && trim($_GET['query']) != "") {
            $pag = 0;
            if (filter_has_var(INPUT_GET, 'pag') && trim($_GET['pag']) != "") {
                $pag = filter_var($GET['pag'], FILTER_SANITIZE_NUMBER_INT);
            }
            $str = filter_var($_GET['query'], FILTER_SANITIZE_STRING);
            $list = array();
            $countList = $this->adModel->globalCount($str);
            if ($countList > 0) {
                $list = $this->adModel->globalSearch($str);
            }
            $this->view("searchAds", array(
                'title' => "Resultados Obtenidos",
                "results" => $list,
                "countList" => $countList,
                "pag" => $pag,
                "query" => $str
            ));
        } else {
            $this->redirect();
        }
    }

    public function listAds() {
        $house = null;
        $operation = null;
        $pag = 0;
        if (filter_has_var(INPUT_GET, "type_house") && trim($_GET['type_house']) != "") {
            $house = filter_var($_GET['type_house'], FILTER_SANITIZE_STRING);
        }
        if (filter_has_var(INPUT_GET, "type_operation") && trim($_GET['type_operation']) != "") {
            $operation = filter_var($_GET['type_operation'], FILTER_SANITIZE_STRING);
        }
        if (filter_has_var(INPUT_GET, 'pag') && trim($_GET['pag']) != "") {
            $pag = filter_var($_GET['pag'], FILTER_SANITIZE_NUMBER_INT);
        }
        $countAds = $this->adModel->countListAds($house, $operation);
        $ads = $this->adModel->listAds($house, $operation, $pag);
        $houses = $this->housingTypeModel->getAll();
        $operations = $this->operationTypeModel->getAll();
        $this->view("listAds", array(
            'title' => "Resultados Obtenidos",
            "results" => $ads,
            "countList" => $countAds,
            "pag" => $pag,
            "houses" => $houses,
            "operations" => $operations
        ));
    }

}
