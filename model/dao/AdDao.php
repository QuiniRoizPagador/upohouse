<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class AdDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Ads");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `user_id`, `price`,`rooms`, `m_2`, `bath`, `description`,
            housing_type, operation_type, community_id, province_id, municipality_id, state)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $data = array("sidiiisiiiiii", "uuid" => $obj->getUuid(), "user_id" => $obj->getUser_id(),
            "price" => $obj->getPrice(), "rooms" => $obj->getRooms(), "m_2" => $obj->getM_2(),
            "bath" => $obj->getBath(), "description" => $obj->getDescription(), "housing_type" => $obj->getHousing_type(),
            "operation_type" => $obj->getOperation_type(), "community_id" => $obj->getCommunity_id(),
            "province_id" => $obj->getProvince_id(), "municipality_id" => $obj->getMunicipality_id(), "state" => $obj->getState());
        $res = parent::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

    public function update($obj) {
        // TODO
    }

    public function getAllPaginated($pag) {
        $query = $this->mysqli->query("SELECT * FROM $this->table "
                . "WHERE state != " . STATES['ELIMINADO'] . " "
                . "ORDER BY id ASC LIMIT 10 OFFSET " . $pag * 10);
        //Devolvemos el resultset en forma de array de objetos

        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);
        return $resultSet;
    }

    public function countAds() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table WHERE state != " . STATES['ELIMINADO'] . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

}
