<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class RequestDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Requests");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `content`, `ad_id`,`user_id`, `state`)
                VALUES(?, ?, ?, ?, ?)";
        $data = array("ssiii", "uuid" => $obj->getUuid(), "content" => $obj->getContent(), "ad_id" => $obj->getAd_id(),
            "user_id" => $obj->getUser_id(), "state" => $obj->getState());
        $res = parent::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid(), FALSE);
        if (trim($obj->getState()) == '') {
            $obj->setState($prev->state);
        }
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ?";
        $data = array("ssss", "name" => $obj->getState(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

}
