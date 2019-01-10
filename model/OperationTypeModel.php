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


    public function countOperationTypes($close = TRUE) {
        return $this->operationTypeDao->countOperationTypes($close);
    }


    public function getAllPaginated($pag = 0, $close = TRUE) {
        return $this->operationTypeDao->getAllPaginated($pag, $close);
    }

}
