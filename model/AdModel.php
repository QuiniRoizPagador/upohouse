<?php

require_once "core/AbstractModel.php";
require_once "model/dao/AdDao.php";

use core\AbstractModel;

class AdModel extends AbstractModel {

    private $adDao;

    public function __construct() {
        $this->adDao = new AdDao();
        parent::__construct($this->adDao);
    }

}
