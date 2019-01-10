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

    public function getAllPaginated($pag = 0) {
        return $this->adDao->getAllPaginated($pag);
    }

    public function countAds() {
        return $this->adDao->countAds();
    }

    public function block($uuid) {
        return $this->adDao->block($uuid);
    }

}
