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
                    'adUuid' => $ad->uuid
                ));
            }
        } else {
            $this->redirect("User", "index");
        }
    }

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
                    "rooms" => "number", "m2" => "number", "bath" => "number", "images" => "image", "description" => "text", "community" => "number",
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
                                $imgObj->setImage($image);
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
                            'adUuid' => $adOld->uuid
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
                'adUuid' => $adOld->uuid
            ));
        }
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
                $images = $this->imageModel->readByAd($ad->id);
                $this->view("readAd", array(
                    'title' => "Anuncio",
                    "ad" => $ad,
                    "housingType" => $housingType,
                    "operationType" => $operationType,
                    "community" => $community,
                    "province" => $province,
                    "municipality" => $municipality,
                    "images" => $images
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

    /**
     * Creación de un usuario por parte del admin
     */
    /* public function create() {
      $values = array("name", "login", "surname", "email", "password");
      $errors = RegularUtils::filtrarVariable($values);
      if ($errors == null) {
      $filtrado = RegularUtils::sanearStrings($values);
      //Creamos un usuario
      $usuario = new User();
      $usuario->setName($filtrado["name"]);
      $usuario->setSurname($filtrado["surname"]);
      $usuario->setEmail($filtrado["email"]);
      $usuario->setLogiN($filtrado['login']);
      $usuario->setPassword($filtrado["password"]);
      $usuario->setUuid(RegularUtils::uuid());
      $usuario->setUserRole(1);

      try {
      $save = $this->userModel->create($usuario);
      if ($save == 0) {
      $errors['query'] = "Error al insertar Usuario";
      } else {
      // si todo ha ido correcto, nos vamos a la web principal
      $this->redirect("User", "index");
      }
      } catch (UnexpectedValueException $e) {
      die("Error al insertar usuario");
      } catch (Exception $ex) {
      die("Error al insertar usuario");
      }
      }
      if (isset($errors)) {
      //Conseguimos todos los usuarios
      $allusers = $this->userModel->getAll();

      //Cargamos la vista index y le pasamos valores
      $this->view("index", array(
      'title' => "P&aacute;gina principal",
      "allusers" => $allusers,
      "errors" => $errors
      ));
      }
      } */

    /* public function readUser() {
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
      } */

    /**
     * Registro desde la propia aplicación
     */
    /* public function register() {
      //TODO: mostrar errores
      $values = array("name", "surname", "mail", "password");
      $errors = RegularUtils::filtrarVariable($values);
      if ($errors == null) {
      $filtrado = RegularUtils::sanearStrings($values);
      //Creamos un usuario
      $usuario = new User();
      $usuario->setName($filtrado["name"]);
      $usuario->setSurname($filtrado["surname"]);
      $usuario->setEmail($filtrado["mail"]);
      $usuario->setPassword($filtrado["password"]);
      $usuario->setUuid(RegularUtils::uuid());
      $usuario->setRole(2);
      try {
      $save = $this->userModel->create($usuario);
      if ($save == 0) {
      die("Error al insertar usuario");
      }
      } catch (UnexpectedValueException $e) {
      die("Error al insertar usuario");
      } catch (Exception $ex) {
      die("Error al insertar usuario");
      }
      }
      $this->redirect();
      } */

    /**
     * Actualización de usuario 
     */
    /* public function update() {
      // TODO: same user or admin
      $values = array("uuid");
      $errors = RegularUtils::filtrarVariable($values);
      if ($errors == null) {
      $values = array("name", "surname", "password", "uuid");
      $filtrado = RegularUtils::sanearStrings($values);
      //Creamos un usuario
      $usuario = new User();
      $usuario->setUuid($filtrado['uuid']);
      if (isset($filtrado["name"])) {
      $usuario->setName($filtrado['name']);
      }
      if (isset($filtrado["surname"])) {
      $usuario->setSurname($filtrado["surname"]);
      }
      if (isset($filtrado["password"])) {
      $usuario->setPassword($filtrado["password"]);
      }
      try {
      $save = $this->userModel->update($usuario);
      if ($save == 0) {
      die("Error al insertar usuario");
      } else {
      $this->redirect("User", "index");
      }
      } catch (UnexpectedValueException $e) {
      die("Error al insertar usuario");
      } catch (Exception $ex) {
      die("Error al insertar usuario");
      }
      } else {
      $allusers = $this->userModel->getAll();

      //Cargamos la vista index y le pasamos valores
      $this->view("index", array(
      'title' => "P&aacute;gina principal",
      "allusers" => $allusers,
      "errors" => $errors
      ));
      }
      } */

    /* public function blockUser() {
      if (filter_has_var(INPUT_POST, "uuid") && (verifyIsAdmin())) {
      $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
      $rem = $this->userModel->block($id);
      if ($rem == 0) {
      die("Error al bloquear usuario");
      }
      }
      $this->redirect("User", "index");
      } */

    /* public function remove() {
      if (filter_has_var(INPUT_POST, "uuid") && (verifyIsAdmin())) {
      $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
      $rem = $this->userModel->delete($id);
      if ($rem == 0) {
      die("Error al eliminar usuario");
      }
      }
      $this->redirect("User", "index");
      }
      || verifyIsSame() - after verifyIsAdmin()
     */
}
