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
        return $res;
    }

    public function listUserRequest($user) {
        $query = "SELECT
            CONCAT(h.name,' - ',m.municipality) as title,
            a.uuid AS ad,
            u.name AS user,
            u.uuid as user_uuid,
            u.phone as phone,
            u.email as mail,
            r.timestamp,
            r.uuid AS request,
            r.content,
            r.uuid as req_uuid
        FROM
            Requests AS r
        JOIN Ads AS a
        ON
            r.ad_id = a.id
        JOIN Users AS u
        ON
            r.user_id = u.id
        JOIN Municipalities AS m
        ON
            a.municipality_id = m.id
        JOIN Housing_Types AS h
        ON
            a.housing_type = h.id
        WHERE
            a.user_id = ?
        AND 
            a.accepted_request IS NULL
        AND 
            r.state = " . STATES['NEUTRO'] . " 
        GROUP BY
            a.uuid,
            r.uuid
        ORDER BY
            r.timestamp";
        $data = array("i", "a.user_id" => $user->id);
        $resultSet = parent::preparedStatement($query, $data);
        $res = array();
        while ($row = $resultSet->fetch_object()) {
            $res[] = $row;
        }
        mysqli_free_result($resultSet);
        return $res;
    }

}
