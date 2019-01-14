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
        return $res;
    }

    public function update($obj) {
        // TODO
    }

    public function countComments() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table WHERE state != " . STATES['ELIMINADO'] . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

//$sql = "SELECT c.id,c.uuid,c.ad_id,a.uuid AS \'ad_uuid\',u.login,u.uuid AS \'user_uuid\',c.content,c.timestamp,c.state FROM comments c, ads a , users u WHERE c.ad_id=a.id AND c.user_id=u.id";
    public function getAllPaginated($pag = 0) {
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
        $query = "SELECT COUNT(*) as comments from $this->table WHERE user_id = ?";
        $data = array("i", "user_id" => $id);
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

}
