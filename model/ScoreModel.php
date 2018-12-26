<?php

require_once "core/AbstractModel.php";
require_once "model/dao/ScoreDao.php";

use core\AbstractModel;

class ScoreModel extends AbstractModel {

    private $scoreDao;

    public function __construct() {
        $this->scoreDao = new AdsDao();
        parent::__construct($this->scoreDao);
    }

}
