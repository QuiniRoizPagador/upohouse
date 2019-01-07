<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class ReportDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Reports");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, title, description, `user_id`, state, user_reported,
            comment_reported, request_reported, ad_reported)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $data = array("sssiiiiii", "uuid" => $obj->getUuid(), "title" => $obj->getTitle(),
            "description" => $obj->getDescription(), "user_id" => $obj->getUser_id(), "state" => $obj->getState(),
            "user_reported" => $obj->getUser_reported(), "comment_reported" => $obj->getComment_reported(),
            "request_reported" => $obj->getRequest_reported(), "ad_reported" => $obj->getAd_reported());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid(), FALSE);
        if (trim($obj->getState()) == '') {
            $obj->setState($prev->state);
        }
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ?";
        $data = array("is", "state" => $obj->getState(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

}
