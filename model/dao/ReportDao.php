<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class ReportDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Reports");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, title, description, `user_id`, user_reported,
            comment_reported, request_reported, ad_reported)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $data = array("sssiiiii", "uuid" => $obj->getUuid(), "title" => $obj->getTitle(),
            "description" => $obj->getDescription(), "user_id" => $obj->getUser_id(),
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
        return $res;
    }

    public function modifyState($uuid, $state) {
        $query = "UPDATE $this->table SET `state` = ? WHERE uuid = ?";
        if ($state == "Aceptar") {
            $data = array("is", "state" => STATES["ACEPTADO"], "uuid" => $uuid);
        } else {
            $data = array("is", "state" => STATES["DESCARTADO"], "uuid" => $uuid);
        }
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function countReportUsers() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table "
                . "WHERE `user_reported` is not null AND state=" . STATES["NEUTRO"]
                . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    public function getAllReportUserPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT r.*, u.login as 'login_reported',"
                . "u2.login as 'login', u.uuid AS 'uuid_reported', u2.uuid AS "
                . "'uuid_user' FROM $this->table AS r "
                . "JOIN users AS u ON r.user_reported=u.id "
                . "JOIN users AS u2 ON r.user_id=u2.id "
                . "WHERE user_reported is not null AND r.state=" . STATES["NEUTRO"] ." "
                . "GROUP BY r.id ORDER BY id ASC LIMIT 10 OFFSET " . $pag * 10);

//Devolvemos el resultset en forma de array de objetos
        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);

        return $resultSet;
    }

    public function countReportAds() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table "
                . "WHERE `ad_reported` is not null AND state=" . STATES["NEUTRO"]
                . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    public function getAllReportAdPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT r.*,"
                . "u.login as 'login', a.uuid AS 'uuid_reported', u.uuid AS "
                . "'uuid_user' FROM $this->table AS r"
                . " JOIN ads AS a ON r.ad_reported=a.id "
                . "JOIN users AS u ON r.user_id=u.id "
                . "WHERE ad_reported is not null AND r.state=" . STATES["NEUTRO"]
                . " GROUP BY r.id ORDER BY id ASC LIMIT 10 OFFSET " . $pag * 10);

//Devolvemos el resultset en forma de array de objetos
        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);

        return $resultSet;
    }

    public function countReportComments() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table "
                . "WHERE `comment_reported` is not null AND state=" . STATES["NEUTRO"]
                . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    public function getAllReportCommentPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT r.*,"
                . "u.login as 'login', c.uuid AS 'uuid_reported', u.uuid AS "
                . "'uuid_user' FROM $this->table AS r"
                . " JOIN comments AS c ON r.comment_reported=c.id "
                . "JOIN users AS u ON r.user_id=u.id "
                . "WHERE comment_reported is not null AND r.state=" . STATES["NEUTRO"]
                . " GROUP BY r.id ORDER BY id ASC LIMIT 10 OFFSET " . $pag * 10);

//Devolvemos el resultset en forma de array de objetos
        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);

        return $resultSet;
    }

    public function countReportRequests() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table "
                . "WHERE `request_reported` is not null AND state=" . STATES["NEUTRO"]
                . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    public function getAllReportRequestPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT r.*,"
                . "u.login as 'login', re.uuid AS 'uuid_reported', u.uuid AS "
                . "'uuid_user' FROM $this->table AS r"
                . " JOIN requests AS re ON r.request_reported=re.id "
                . "JOIN users AS u ON r.user_id=u.id "
                . "WHERE request_reported is not null AND r.state=" . STATES["NEUTRO"]
                . " GROUP BY r.id ORDER BY id ASC LIMIT 10 OFFSET " . $pag * 10);
//Devolvemos el resultset en forma de array de objetos
        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);

        return $resultSet;
    }

    public function isReportedUser($me, $otherUser) {
        $query = "SELECT count(*) as count FROM $this->table
                WHERE user_id = ? AND user_reported = ? ";
        $data = array("ii", "user_id" => $me, "user_reported" => $otherUser);
        $res = parent::preparedStatement($query, $data);
        $count = $res->fetch_object()->count;
        mysqli_free_result($res);

        return $count != 0;
    }

}
