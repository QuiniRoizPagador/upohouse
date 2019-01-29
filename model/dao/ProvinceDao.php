<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class ProvinceDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Provinces");
    }

    public function readId($id) {
        $query = "SELECT * FROM $this->table WHERE id = ? LIMIT 1";
        $data = array('s', "id" => $id);

        return $this->preparedStatement($query, $data)[0];
    }

    public function create($obj) {
        
    }

    public function update($obj) {
        
    }

}
