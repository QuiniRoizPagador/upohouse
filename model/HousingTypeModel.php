<?php

require_once "core/AbstractModel.php";
require_once "model/dao/HousingTypeDao.php";

use core\AbstractModel;

class HousingTypeModel extends AbstractModel {

    private $housingTypeDao;

    /**
     * Método constructor
     */
    public function __construct() {
        $this->housingTypeDao = new HousingTypeDao();
        parent::__construct($this->housingTypeDao);
    }

    /**
     * Método que devuelve el número de tipos de casas 
     */
    public function countHousingTypes() {
        return $this->housingTypeDao->countHousingTypes();
    }

    /**
     * Método que devuelve los tipos de casas paginados
     * @param Integer $pag offset de la paginacion de tipos de casas
     */
    public function getAllPaginated($pag = 0) {
        return $this->housingTypeDao->getAllPaginated($pag);
    }

}
