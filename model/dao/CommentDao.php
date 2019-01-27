<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class CommentDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Comments");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `ad_id`, `user_id`,`content`)
                VALUES(?, ?, ?, ?)";
        $data = array("siis", "uuid" => $obj->getUuid(), "ad_id" => $obj->getAd_id(), "user_id" => $obj->getUser_id(),
            "content" => $obj->getContent());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function update($obj) {
        // TODO
    }

    public function countComments() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table "
                . "WHERE state = " . STATES['NEUTRO'] . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    public function getAllPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT c.*,a.uuid AS 'uuid_ad', u.login AS 'login', u.uuid AS 'uuid_user' "
                . "FROM $this->table AS c JOIN ads AS a ON a.id=c.ad_id "
                . "JOIN users AS u ON u.id=c.user_id WHERE c.state != " . STATES['ELIMINADO'] . " "
                . "GROUP BY c.id ORDER BY c.id ASC LIMIT 5 OFFSET " . $pag * 5);

        //Devolvemos el resultset en forma de array de objetos
        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);

        return $resultSet;
    }

    public function countRegistrationComments() {
        $query = $this->mysqli->query("select COUNT(*) as count, MONTH(`timestamp`) as month,"
                . "YEAR(`timestamp`) as year from $this->table "
                . "GROUP BY MONTH(`timestamp`),YEAR(`timestamp`) "
                . "ORDER BY year(`timestamp`) DESC");

        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);
        return $resultSet;
    }

    public function delete($id) {
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES['ELIMINADO'], "uuid" => $id);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function countUserComments($id) {
        $query = "SELECT COUNT(*) as comments from $this->table WHERE user_id = ? AND state = ?";
        $data = array("ii", "user_id" => $id, "state" => STATES["NEUTRO"]);
        $resultSet = $this->preparedStatement($query, $data);
        $res = mysqli_fetch_object($resultSet);
        mysqli_free_result($resultSet);
        return $res->comments;
    }

    public function block($uuid) {
        $query = "UPDATE $this->table SET `state` = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES["BLOQUEADO"], "uuid" => $uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function getComments($id, $pag = 0) {
        if (isset($_SESSION['id']) && $_SESSION['id'] != "") {
            $query = $this->mysqli->query("SELECT c.*,u.login, u.uuid as 'uuid_user',(rep.comment_reported IS NOT NULL  AND rep.user_id!=" . $_SESSION['id'] . ") AS denunciado FROM $this->table AS c "
                    . "LEFT OUTER JOIN Reports as rep ON rep.comment_reported = c.id "
                    . "JOIN users AS u ON c.user_id=u.id "
                    . "WHERE c.state = " . STATES['NEUTRO'] . " AND c.ad_id=" . $id . " "
                    . "GROUP BY c.id ORDER BY c.timestamp DESC LIMIT 5 OFFSET " . $pag * 5);
        } else {
            $query = $this->mysqli->query("SELECT c.*,u.login, u.uuid as 'uuid_user',(rep.comment_reported IS NOT NULL) AS denunciado FROM $this->table AS c "
                    . "LEFT OUTER JOIN Reports as rep ON rep.comment_reported = c.id "
                    . "JOIN users AS u ON c.user_id=u.id "
                    . "WHERE c.state = " . STATES['NEUTRO'] . " AND c.ad_id=" . $id . " "
                    . "GROUP BY c.id ORDER BY c.timestamp DESC LIMIT 5 OFFSET " . $pag * 5);
        }
        //Devolvemos el resultset en forma de array de objetos

        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);

        return $resultSet;
    }

    public function countCommentsAd($id) {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table WHERE state = " . STATES['NEUTRO'] . " AND ad_id=$id ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    public function removeComment($id) {
        $query = "UPDATE $this->table SET `state` = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES["ELIMINADO"], "uuid" => $id);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

}
