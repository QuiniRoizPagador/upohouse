<?php

require_once "core/AbstractModel.php";
require_once "model/dao/HousingTypeDao.php";

use core\AbstractModel;

class HousingTypeModel {

    private $housingTypeDao;

    public function __construct() {
        $this->housingTypeDao = new HousingTypeDao();
        parent::__construct($this->housingTypeDao);
    }

}
