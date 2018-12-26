<?php

require_once "core/AbstractModel.php";
require_once "model/dao/ProvinceDao.php";

use core\AbstractModel;

class ProvinceModel extends AbstractModel {

    private $provinceDao;

    public function __construct() {
        $this->provinceDao = new ProvinceDao();
        parent::__construct($this->provinceDao);
    }

}
