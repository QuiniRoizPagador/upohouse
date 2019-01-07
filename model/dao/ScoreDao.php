<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class ScoreDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Scores");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `ad_id`, `user_id`,`score`)
                VALUES(?, ?, ?, ?)";
        $data = array("siii", "uuid" => $obj->getUuid(), "ad_id" => $obj->getAd_id(),
            "user_id" => $obj->getUser_id(), "score" => $obj->getScore());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid(), FALSE);
        if (trim($obj->getScore()) == '') {
            $obj->setScore($prev->score);
        }
        $query = "UPDATE $this->table SET score = ? WHERE uuid = ?";
        $data = array("is", "score" => $obj->getScore(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

}
