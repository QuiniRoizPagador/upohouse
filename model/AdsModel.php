<?php

require_once "core/AbstractModel.php";
require_once "model/dao/AdsDao.php";

use core\AbstractModel;

class AdsModel extends AbstractModel {

    private $adsDao;

    public function __construct() {
        $this->adsDao = new AdsDao();
        parent::__construct($this->adsDao);
    }

}
