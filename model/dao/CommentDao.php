<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class CommentDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Comments");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `ad_id`, `user_id`,`content`, `state`)
                VALUES(?, ?, ?, ?, ?)";
        $data = array("siisi", "uuid" => $obj->getUuid(), "ad_id" => $obj->getAd_id(), "user_id" => $obj->getUser_id(),
            "content" => $obj->getContent(), "state" => $obj->getState());
        $res = parent::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

    public function update($obj) {
        // TODO
    }

}
