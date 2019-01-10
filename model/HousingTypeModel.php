<?php

require_once "core/AbstractModel.php";
require_once "model/dao/HousingTypeDao.php";

use core\AbstractModel;

class HousingTypeModel extends AbstractModel {

    private $housingTypeDao;

    public function __construct() {
        $this->housingTypeDao = new HousingTypeDao();
        parent::__construct($this->housingTypeDao);
    }

    public function countHousingTypes($close = TRUE) {
        return $this->housingTypeDao->countHousingTypes($close);
    }


    public function getAllPaginated($pag = 0, $close = TRUE) {
        return $this->housingTypeDao->getAllPaginated($pag, $close);
    }

}
