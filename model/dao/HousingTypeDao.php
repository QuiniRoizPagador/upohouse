<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class HousingTypeDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Housing_Types");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `name`)
                VALUES(?, ?)";
        $data = array("ss", "uuid" => $obj->getUuid(), "name" => $obj->getName());
        $res = parent::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid(), FALSE);
        if (trim($obj->getName()) == '') {
            $obj->setName($prev->name);
        }
        $query = "UPDATE $this->table SET name = ? WHERE uuid = ?";
        $data = array("ss", "name" => $obj->getName(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

}
