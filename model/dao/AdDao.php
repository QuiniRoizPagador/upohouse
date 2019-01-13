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
        return $res;
    }

    public function update($obj) {
        $query = "UPDATE $this->table SET housing_type = ?, operation_type = ?, price = ?, "
                . "rooms = ?, m_2 = ?, bath = ?, description = ?, community_id = ?, province_id = ?, municipality_id = ? WHERE uuid = ?";
        $data = array("iidiiisiiis", "housing_type" => $obj->getHousing_type(), "operation_type" => $obj->getOperation_type(),
            "price" => $obj->getPrice(), "rooms" => $obj->getRooms(), "m_2" => $obj->getM_2(), "bath" => $obj->getBath(),
            "description" => $obj->getDescription(), "community_id" => $obj->getCommunity_id(), "province_id" => $obj->getProvince_id(),
            "municipality_id" => $obj->getMunicipality_id(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
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

    public function block($uuid) {
        $query = "UPDATE $this->table SET `state` = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES["BLOQUEADO"], "uuid" => $uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function countUserAds($id) {
        $query = "SELECT COUNT(*) as ads from $this->table WHERE user_id = ?";
        $data = array("i", "user_id" => $id);
        $resultSet = $this->preparedStatement($query, $data);
        $res = mysqli_fetch_object($resultSet);
        mysqli_free_result($resultSet);
        return $res->ads;
    }

    public function globalSearch($str) {
        $param = "+" . $str;
        $param = str_replace(" ", "* +", $param);
        $param .= "*";
        $query = "SELECT
            a.uuid,
            a.description,
            o.name AS operation,
            h.name AS housing,
            c.community,
            p.province,
            m.municipality
        FROM
            Ads AS a
        JOIN Communities AS c
        ON
            a.community_id = c.id
        JOIN Provinces AS p
        ON
            a.province_id = p.id
        JOIN Municipalities AS m
        ON
            a.municipality_id = m.id
        JOIN Housing_Types AS h
        ON
            a.housing_type = h.id
        JOIN Operation_Types AS o
        ON
            a.operation_type = o.id
        WHERE
            MATCH(a.description) AGAINST(
                ? IN BOOLEAN MODE
            ) OR MATCH(c.community) AGAINST(
                ? IN BOOLEAN MODE
            ) OR MATCH(p.province) AGAINST(
                ? IN BOOLEAN MODE
            ) OR MATCH(m.municipality) AGAINST(
                ? IN BOOLEAN MODE
            ) OR MATCH(o.name) AGAINST(
                ? IN BOOLEAN MODE
            ) OR MATCH(h.name) AGAINST(
                ? IN BOOLEAN MODE
            )
        GROUP BY
            a.uuid
        ORDER BY a.timestamp, a.description, c.community, p.province,m.municipality,o.name, h.name    
        LIMIT 10";
        $data = array("ssssss", $param, $param, $param, $param, $param,
            $param);
        $resultSet = $this->preparedStatement($query, $data);

        $res = array();
        while ($row = $resultSet->fetch_object()) {
            $res[] = $row;
        }

        mysqli_free_result($resultSet);
        return $res;
    }

}
