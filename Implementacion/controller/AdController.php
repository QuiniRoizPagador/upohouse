<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/Ad.php';
require_once 'model/dao/dto/Image.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\Ad;
use model\dao\dto\Image;

/**
 * Clase controladora de anuncios y sus acciones básicas relacionadas
 */
class AdController extends AbstractController {

    private $adModel;
    private $housingTypeModel;
    private $operationTypeModel;
    private $communityModel;
    private $provinceModel;
    private $municipalityModel;
    private $imageModel;
    private $requestModel;
    private $commentModel;
    private $scoreModel;
    private $userModel;
    private $reportModel;

    /**
     * Método constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->adModel = new AdModel();
        $this->housingTypeModel = new HousingTypeModel();
        $this->operationTypeModel = new OperationTypeModel();
        $this->communityModel = new CommunityModel();
        $this->provinceModel = new ProvinceModel();
        $this->municipalityModel = new MunicipalityModel();
        $this->imageModel = new ImageModel();
        $this->requestModel = new RequestModel();
        $this->commentModel = new CommentModel();
        $this->scoreModel = new ScoreModel();
        $this->userModel = new UserModel();
        $this->reportModel = new ReportModel();
    }

    /**
     * Método que muestra una vista que permite modificar un anuncio existente.
     * Dicho anuncio viene determinado por un parámetro recibido por GET.
     */
    public function modifyView() {
        if (filter_has_var(INPUT_GET, "uuid")) {
            $uuid = RegularUtils::sanearStrings(array('uuid'), 'GET')['uuid'];
            $ad = $this->adModel->read($uuid);
            if (!isset($ad->uuid)) {
                $this->redirect("User", "index");
            } else {
                $allHousingTypes = $this->housingTypeModel->getAll();
                $allOperationTypes = $this->operationTypeModel->getAll();
                $allCommunities = $this->communityModel->getAll();
                //Cargamos la vista adView y le pasamos valores
                $this->view("modifyAd", array(
                    'title' => "Modificar un anuncio",
                    'allHousingTypes' => $allHousingTypes,
                    'allOperationTypes' => $allOperationTypes,
                    'allCommunities' => $allCommunities,
                    'ad' => $ad
                ));
            }
        } else {
            $this->redirect("User", "index");
        }
    }

    /**
     * Método que lleva a cabo la modificación de un anuncio existente, el cual viene
     * determinado por un parámetro GET. El nuevo valor de los campos son recibidos por POST
     * y se conservarán los valores de los campos no modificados.
     */
    public function modify() {
        if (filter_has_var(INPUT_GET, "uuid")) {
            $uuid = RegularUtils::sanearStrings(array('uuid'), 'GET')['uuid'];
            $adOld = $this->adModel->read($uuid);
            if (!isset($adOld->uuid)) {
                $this->redirect("User", "index");
            } else {
                $allHousingTypes = $this->housingTypeModel->getAll();
                $allOperationTypes = $this->operationTypeModel->getAll();
                $allCommunities = $this->communityModel->getAll();
                $values = array("housingType" => "text", "operationType" => "text", "price" => "float",
                    "rooms" => "number", "m2" => "number", "bath" => "number", "images" => "image", "description" => "longText", "community" => "number",
                    "province" => "number", "municipality" => "number");
                $noRequired = array("housingType", "operationType", "price", "rooms",
                    "m2", "bath", "images", "description", "community", "province", "municipality");
                $errors = RegularUtils::filtrarPorTipo($values, "modify");
                $errors = RegularUtils::camposNoRequeridos($errors, "modify", $noRequired);
                if (isset($errors["modify"]["community"]) && !is_numeric($_POST["community"])) {
                    unset($errors["modify"]["community"]);
                    if (count($errors["modify"]) == 0) {
                        $errors = null;
                    }
                }
                if (!isset($errors["modify"])) {
                    $strValues = array("housingType", "operationType", "description");
                    $intValues = array("rooms", "m2", "bath", "community", "province", "municipality");
                    $fltValues = array("price");
                    $strFiltrado = RegularUtils::sanearStrings($strValues);
                    $intFiltrado = RegularUtils::sanearIntegers($intValues);
                    $fltFiltrado = RegularUtils::sanearFloats($fltValues);
                    $filtrado = array_merge($strFiltrado, $intFiltrado, $fltFiltrado);
                    //Creamos un anuncio
                    $ad = new Ad();
                    $ad->setUuid($adOld->uuid);
                    $ad->setHousing_type($this->housingTypeModel->read($filtrado["housingType"])->id);
                    $ad->setOperation_type($this->operationTypeModel->read($filtrado["operationType"])->id);
                    if (!$filtrado["price"]) {
                        $ad->setPrice($adOld->price);
                    } else {
                        $ad->setPrice($filtrado["price"]);
                    }
                    if (!$filtrado["rooms"]) {
                        $ad->setRooms($adOld->rooms);
                    } else {
                        $ad->setRooms($filtrado["rooms"]);
                    }
                    if (!$filtrado["m2"]) {
                        $ad->setM_2($adOld->m_2);
                    } else {
                        $ad->setM_2($filtrado["m2"]);
                    }
                    if (!$filtrado["bath"]) {
                        $ad->setBath($adOld->bath);
                    } else {
                        $ad->setBath($filtrado["bath"]);
                    }
                    if (!$filtrado["description"]) {
                        $ad->setDescription($adOld->description);
                    } else {
                        $ad->setDescription($filtrado["description"]);
                    }
                    if (!$filtrado["community"]) {
                        $ad->setCommunity_id($adOld->community_id);
                    } else {
                        $ad->setCommunity_id($filtrado["community"]);
                    }
                    if (!$filtrado["province"]) {
                        $ad->setProvince_id($adOld->province_id);
                    } else {
                        $ad->setProvince_id($filtrado["province"]);
                    }
                    if (!$filtrado["municipality"]) {
                        $ad->setMunicipality_id($adOld->municipality_id);
                    } else {
                        $ad->setMunicipality_id($filtrado["municipality"]);
                    }
                    $save = $this->adModel->update($ad);
                    if ($save != 1) {
                        $errors['modify']['query'] = $save;
                    } else {
                        if ($_FILES["images"]["name"][0]) {
                            $id = $adOld->id;
                            RegularUtils::removeAdImages($ad->getUuid());
                            $this->imageModel->deleteAllByAd($adOld->id);
                            $images = RegularUtils::saveAdImages("images", $ad->getUuid());
                            foreach ($images as $image) {
                                $imgObj = new Image();
                                $imgObj->setUuid(RegularUtils::uuid());
                                $imgObj->setImage($image['image']);
                                $imgObj->setThumbnail($image['thumbnail']);
                                $imgObj->setAd_id($id);
                                $this->imageModel->create($imgObj);
                            }
                        }
                        // si todo ha ido correcto, nos vamos a la web principal
                        $this->view("modifyAd", array(
                            'title' => "Modificar un anuncio",
                            'allHousingTypes' => $allHousingTypes,
                            'allOperationTypes' => $allOperationTypes,
                            'allCommunities' => $allCommunities,
                            'success' => TRUE,
                            'ad' => $ad
                        ));
                    }
                }
            }
        }
        if (isset($errors["modify"])) {
            //Cargamos la vista adView y le pasamos valores
            $this->view("modifyAd", array(
                'title' => "Modificar un anuncio",
                'allHousingTypes' => $allHousingTypes,
                'allOperationTypes' => $allOperationTypes,
                'allCommunities' => $allCommunities,
                'errors' => $errors,
                'ad' => $adOld
            ));
        }
    }

    /**
     * El método muestra una vista, la cual permite la creación de un anuncio.
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

    /**
     * El método permite crear un nuevo anuncio en la base de datos. Recibiendo todos los valores
     * necesarios a través de POST. Además, muestra el mensaje relacionado con el estado final de la
     * transacción.
     */
    public function create() {
        $allHousingTypes = $this->housingTypeModel->getAll();
        $allOperationTypes = $this->operationTypeModel->getAll();
        $allCommunities = $this->communityModel->getAll();
        $values = array("housingType" => "text", "operationType" => "text", "price" => "float",
            "rooms" => "number", "m2" => "number", "bath" => "number", "images" => "image", "description" => "longText", "community" => "number",
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
            $ad->setHousing_type($this->housingTypeModel->read($filtrado["housingType"])->id);
            $ad->setOperation_type($this->operationTypeModel->read($filtrado["operationType"])->id);
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
                    $imgObj->setImage($image['image']);
                    $imgObj->setThumbnail($image['thumbnail']);
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

    /**
     * Método que muestra los datos de un anuncio. Dicho anuncio es identificado mediante
     * un parámetro vía GET.
     */
    public function read($pag = NULL) {
        if (filter_has_var(INPUT_GET, "uuid")) {

            if ($pag == NULL) {
                $pag = 0;
            }
            $uuid = RegularUtils::sanearStrings(array('uuid'), 'GET')['uuid'];
            $ad = $this->adModel->read($uuid);
            if (!isset($ad->uuid)) {
                $this->redirect("User", "index");
            } else {
                if (($ad->state == STATES["BLOQUEADO"] && !verifyIsAdmin()) || ($ad->accepted_request != NULL && !verifyIsAdmin() && $ad->user_id != $_SESSION["id"]) || $ad->state == STATES["ELIMINADO"]) {
                    $this->redirect("User", "index");
                } else {
                    $housingType = $this->housingTypeModel->read($ad->housing_type);
                    $operationType = $this->operationTypeModel->read($ad->operation_type);
                    $community = $this->communityModel->readId($ad->community_id);
                    $province = $this->provinceModel->readId($ad->province_id);
                    $municipality = $this->municipalityModel->readId($ad->municipality_id);
                    $user = $this->userModel->read($ad->user_id);
                    $images = $this->imageModel->readByAd($ad->id);
                    $hasUserRequest = FALSE;
                    $haveReportedAd = FALSE;
                    $isSame = FALSE;
                    $isScored = false;
                    $userScore = null;
                    $comments = $this->commentModel->getComments($ad->id);
                    $numComments = $this->commentModel->countCommentsAd($ad->id);

                    if (verifySession()) {
                        $hasUserRequest = $this->requestModel->verifyExist($_SESSION['id'], $ad->id);
                        $haveReportedAd = $this->reportModel->isReportedAd($_SESSION['id'], $ad->id);
                        $isSame = $ad->user_id == $_SESSION['id'];
                        $isScored = $this->scoreModel->isUserScored($_SESSION['id'], $ad->id);
                        if ($isScored) {
                            $userScore = $this->scoreModel->getUserScore($_SESSION['id'], $ad->id);
                        }
                    }
                    $this->view("readAd", array(
                        'title' => "anuncio",
                        "ad" => $ad,
                        "housingType" => $housingType,
                        "operationType" => $operationType,
                        "community" => $community,
                        "province" => $province,
                        "municipality" => $municipality,
                        "user" => $user,
                        "images" => $images,
                        "hasUserRequest" => $hasUserRequest,
                        "isSame" => $isSame,
                        "comments" => $comments,
                        "numComments" => $numComments,
                        "pag" => $pag,
                        "isScored" => $isScored,
                        "userScore" => $userScore,
                        "haveReportedAd" => $haveReportedAd
                    ));
                }
            }
        } else {
            $this->redirect("User", "index");
        }
    }

    /**
     * Método que tiene como objetivo bloquear un anuncio identificado mediante
     * un parámetro recibido por GET.
     */
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

    /**
     * Método que tiene como objetivo desbloquear un anuncio identificado mediante
     * un parámetro recibido por GET.
     */
    public function unblock() {
        if (filter_has_var(INPUT_GET, "uuid") && (verifyIsAdmin())) {
            $id = RegularUtils::sanearStrings(array('uuid'), 'GET')['uuid'];
            $rem = $this->adModel->unblock($id);
            if ($rem == 0) {
                die("Error al desbloquear usuario");
            }
        }
        $this->redirect("Admin", "dashboard", array("show" => "ads"));
    }

    /**
     * Método que tiene como objetivo eliminar un anuncio identificado mediante
     * un parámetro recibido por GET.
     */
    public function remove() {
        if (filter_has_var(INPUT_GET, "uuid")) {
            $id = RegularUtils::sanearStrings(array('uuid'), 'GET')['uuid'];
            $rem = $this->adModel->delete($id);
            if ($rem == 0) {
                die("Error al eliminar usuario");
            } else {
                //RegularUtils::removeAdImages($id);
            }
        }
        $this->redirect("User", "index", array("show" => "ads"));
    }

    /**
     * Método que tiene como objetivo devolver un conjunto de anuncios en función de un parámetro offset.
     */
    public function paginate() {
        if (filter_has_var(INPUT_GET, 'query') && trim($_GET['query']) != "") {
            $pag = 0;
            if (filter_has_var(INPUT_GET, 'pag') && trim($_GET['pag']) != "") {
                $pag = filter_var($_GET['pag'], FILTER_SANITIZE_NUMBER_INT);
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

    /**
     * Método que muestra un listado de anuncios en función de algunos parámetros
     * recibidos mediante GET.
     */
    public function listAds() {
        $house = null;
        $operation = null;
        $user = null;
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

        if (filter_has_var(INPUT_GET, 'user') && trim($_GET['user']) != "") {
            $user = filter_var($_GET['user'], FILTER_SANITIZE_STRING);
        }
        $countAds = $this->adModel->countListAds($house, $operation, $user);
        $ads = $this->adModel->listAds($house, $operation, $pag, $user);
        $houses = $this->housingTypeModel->getAll();
        $operations = $this->operationTypeModel->getAll();
        $this->view("listAds", array(
            'title' => "anuncios",
            "results" => $ads,
            "countList" => $countAds,
            "pag" => $pag,
            "houses" => $houses,
            "operations" => $operations,
            "user" => $user
        ));
    }

}
