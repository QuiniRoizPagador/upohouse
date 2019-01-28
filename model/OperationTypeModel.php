<?php

require_once "core/AbstractModel.php";
require_once "model/dao/OperationTypeDao.php";

use core\AbstractModel;

class OperationTypeModel extends AbstractModel {

    private $operationTypeDao;

    /**
     * Método constructor
     */
    public function __construct() {
        $this->operationTypeDao = new OperationTypeDao();
        parent::__construct($this->operationTypeDao);
    }

    /**
     * Método que devuelve el número de tipos de operaciones 
     */
    public function countOperationTypes() {
        return $this->operationTypeDao->countOperationTypes();
    }

    /**
     * Método que devuelve los tipos de operaciones paginados
     * @param Integer $pag offset de la paginacion de tipos de operaciones
     */
    public function getAllPaginated($pag = 0) {
        return $this->operationTypeDao->getAllPaginated($pag);
    }

}
