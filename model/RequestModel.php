<?php

require_once "core/AbstractModel.php";
require_once "model/dao/RequestDao.php";

use core\AbstractModel;

class RequestModel extends AbstractModel {

    private $requestDao;

    public function __construct() {
        $this->requestDao = new RequestDao();
        parent::__construct($this->requestDao);
    }

    public function block($uuid) {
        return $this->requestDao->block($uuid);
    }

}
