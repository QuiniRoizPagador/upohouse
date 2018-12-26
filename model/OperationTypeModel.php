<?php

require_once "core/AbstractModel.php";
require_once "model/dao/OperationTypeDao.php";

use core\AbstractModel;

class OperationTypeModel extends AbstractModel {

    private $operationTypeDao;

    public function __construct() {
        $this->operationTypeDao = new OperationTypeDao();
        parent::__construct($this->operationTypeDao);
    }

}
