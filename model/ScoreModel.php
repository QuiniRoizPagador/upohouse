<?php

require_once "core/AbstractModel.php";
require_once "model/dao/ScoreDao.php";

use core\AbstractModel;

class ScoreModel extends AbstractModel {

    private $scoreDao;

    public function __construct() {
        $this->scoreDao = new ScoreDao();
        parent::__construct($this->scoreDao);
    }

    public function isUserScored($idUser, $idAd) {
        return $this->scoreDao->isUserScored($idUser, $idAd);
    }

    public function getUserScore($idUser, $idAd) {
        return $this->scoreDao->getUserScore($idUser, $idAd);
    }

}
