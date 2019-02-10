<?php

require_once "core/AbstractModel.php";
require_once "model/dao/MunicipalityDao.php";

use core\AbstractModel;

/**
 * Clase especialización del modelo de municipios.
 */
class MunicipalityModel extends AbstractModel {

    private $municipalityDao;

    /**
     * Constructor por defecto
     */
    public function __construct() {
        $this->municipalityDao = new MunicipalityDao();
        parent::__construct($this->municipalityDao);
    }

    /**
     * Método que devuelve un municipio.
     * @param Int $id Id del municipio.
     * @return Object Municipio.
     */
    public function readId($id) {
        return $this->municipalityDao->readId($id);
    }

}
