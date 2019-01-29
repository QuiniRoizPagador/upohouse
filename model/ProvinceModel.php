<?php

require_once "core/AbstractModel.php";
require_once "model/dao/ProvinceDao.php";

use core\AbstractModel;

/**
 * Clase especialización del modelo de provincias.
 */
class ProvinceModel extends AbstractModel {

    private $provinceDao;

    /**
     * Constructor por defecto
     */
    public function __construct() {
        $this->provinceDao = new ProvinceDao();
        parent::__construct($this->provinceDao);
    }

    /**
     * Método que devuelve una provincia.
     * @param Int $id Id de la provincia.
     * @return Object Provincia.
     */
    public function readId($id) {
        return $this->provinceDao->readId($id);
    }

}
