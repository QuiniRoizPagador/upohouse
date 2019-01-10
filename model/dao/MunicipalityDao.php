<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class MunicipalityDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Municipalities");
    }

    public function readId($id) {
        $query = "SELECT * FROM $this->table WHERE id = ? LIMIT 1";
        $data = array('s', "id" => $id);

        $resultSet = $this->preparedStatement($query, $data);
        while ($obj = $resultSet->fetch_object()) {
            $res[] = $obj;
        }
        mysqli_free_result($resultSet);
        return $res;
    }

    public function create($obj) {
        
    }

    public function update($obj) {
        
    }

}
