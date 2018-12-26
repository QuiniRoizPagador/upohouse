<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class AdsDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Ads");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `user_id`, `price`,`rooms`, `m_2`, `bath`, `description`,
            housing_type, operation_type, community_id, province_id, municipality_id)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $data = array("sifiiisiiiii", "uuid" => $obj->getUuid(), "user_id" => $obj->getUser_id(),
            "price" => $obj->getPrice, "rooms" => $obj->getRooms(), "m_2" => $obj->getM_2(),
            "bath" => $obj->getBath(), "description" => $obj->getDescription(), "housing_type" => $obj->getHousing_type(),
            "operation_type" => $obj->getOperation_type(), "community_id" => $obj->getCommunity_id(),
            "province_id" => $obj->getProvince_id(), "municipality_id" => $obj->getMunicipality_id());
        $res = parent::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

    public function update($obj) {
        // TODO
    }

}
