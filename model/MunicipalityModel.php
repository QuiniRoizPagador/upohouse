<?php

require_once "core/AbstractModel.php";
require_once "model/dao/MunicipalityDao.php";

use core\AbstractModel;

class MunicipalityModel extends AbstractModel {

    private $municipalityDao;

    public function __construct() {
        $this->municipalityDao = new MunicipalityDao();
        parent::__construct($this->municipalityDao);
    }

}
