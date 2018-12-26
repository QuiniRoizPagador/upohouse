<?php

require_once "core/AbstractModel.php";
require_once "model/dao/RequestDao.php";

use core\AbstractModel;

class RequestModel extends AbstractModel {

    private $requestDaoDao;

    public function __construct() {
        $this->requestDaoDao = new RequestDao();
        parent::__construct($this->requestDaoDao);
    }

}
