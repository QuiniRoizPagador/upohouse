<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class RequestDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Requests");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `content`, `ad_id`,`user_id`)
                VALUES(?, ?, ?, ?)";
        $data = array("ssii", "uuid" => $obj->getUuid(), "content" => $obj->getContent(), "ad_id" => $obj->getAd_id(),
            "user_id" => $obj->getUser_id());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid(), FALSE);
        if (trim($obj->getState()) == '') {
            $obj->setState($prev->state);
        }
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ?";
        $data = array("ssss", "state" => $obj->getState(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function listUserRequest($user, $pag) {
        $query = "SELECT
            CONCAT(h.name,' - ',m.municipality) as title,
            a.uuid AS ad,
            u.name as user,
            CONCAT(u.name,' ',u.surname) AS name,
            u.uuid as user_uuid,
            u.phone as phone,
            u.email as mail,
            r.timestamp,
            r.uuid AS request,
            r.content,
            (rep.request_reported IS NOT NULL) AS denunciado
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
        LEFT OUTER JOIN Reports as rep
        ON 
            rep.request_reported = r.id
        WHERE
            a.user_id = ?
        AND 
            a.accepted_request IS NULL
        AND 
            r.state = " . STATES['NEUTRO'] . " 
        AND 
            a.state = " . STATES['NEUTRO'] . " 
        GROUP BY
            a.uuid,
            r.uuid
        ORDER BY
            r.timestamp
        LIMIT 10
        OFFSET $pag";
        $data = array("i", "a.user_id" => $user->id);
        $resultSet = parent::preparedStatement($query, $data);
        $res = array();
        while ($row = $resultSet->fetch_object()) {
            $res[] = $row;
        }
        mysqli_free_result($resultSet);
        return $res;
    }

    public function countUserRequests($id) {
        $query = "SELECT 
            COUNT(*) as count 
        FROM 
            $this->table AS r
        JOIN Ads as a
        ON 
            r.ad_id = a.id
        WHERE 
            a.user_id = ?
        AND
            r.state = " . STATES['NEUTRO'];

        $data = array("i", "a.user_id" => $id);
        $resultSet = parent::preparedStatement($query, $data);
        $count = mysqli_fetch_object($resultSet)->count;
        mysqli_free_result($resultSet);
        return $count;
    }

    public function accept($req_uuid) {
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES['ACEPTADO'], "uuid" => $req_uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function refuseAll($ad_id, $req_id) {
        $query = "UPDATE $this->table SET state = ? WHERE ad_id = ? AND id != ?";
        $data = array("iss", "state" => STATES['DESCARTADO'], "ad_id" => $ad_id, "id" => $req_id);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function refuseRequest($req_uuid) {
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ? ";
        $data = array("is", "state" => STATES['DESCARTADO'], "uuid" => $req_uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function block($uuid) {
        $query = "UPDATE $this->table SET `state` = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES["BLOQUEADO"], "uuid" => $uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function verifyExist($userId, $adId) {
        $query = "SELECT 
            COUNT(*) as count 
        FROM 
            $this->table 
        WHERE 
            user_id = ?
        AND
            ad_id = ?";

        $data = array("ii", "user_id" => $userId, "ad_id" => $adId);
        $resultSet = parent::preparedStatement($query, $data);
        $count = mysqli_fetch_object($resultSet)->count;
        mysqli_free_result($resultSet);
        return $count != 0;
    }

    public function removeRequest($id) {
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ? ";
        $data = array("is", "state" => STATES['ELIMINADO'], "uuid" => $id);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

}
