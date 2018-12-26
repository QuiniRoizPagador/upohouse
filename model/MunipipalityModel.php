<?php

require_once "core/AbstractModel.php";
require_once "model/dao/MunipipalityDao.php";

use core\AbstractModel;

class MunipipalityModel extends AbstractModel {

    private $munipipalityDao;

    public function __construct() {
        $this->munipipalityDao = new MunipipalityDao();
        parent::__construct($this->munipipalityDao);
    }

}
