<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class CommentDao extends AbstractDao {

    /**
     * Método constructor
     */
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

    /**
     * Método que devuelve el número de comentarios neutros
     */
    public function countComments() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table "
                . "WHERE state = " . STATES['NEUTRO'] . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    /**
     * Método que devuelve los comentarios paginados
     * @param Integer $pag contiene el número de la página a mostrar
     */
    public function getAllPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT c.*,a.uuid AS uuid_ad, u.login AS login, u.uuid AS uuid_user "
                . "FROM $this->table AS c JOIN Ads AS a ON a.id=c.ad_id "
                . "JOIN Users AS u ON u.id=c.user_id WHERE c.state != " . STATES['ELIMINADO'] . " "
                . "GROUP BY c.id ORDER BY c.id ASC LIMIT 5 OFFSET " . $pag * 5);

        //Devolvemos el resultset en forma de array de objetos
        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);

        return $resultSet;
    }

    /**
     * Método que devuelve el número de registros de comentarios
     */
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

    /**
     * Método que borra comentarios
     * @param Integer $id uuid del comentario a borrar
     */
    public function delete($id) {
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES['ELIMINADO'], "uuid" => $id);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    /**
     * Método que devuelve el número de comentarios realizados
     * por el usuario del id pasado por parámetro
     * @param Integer $id id del usuario 
     */
    public function countUserComments($id) {
        $query = "SELECT COUNT(*) as comments from $this->table WHERE user_id = ? AND state = ?";
        $data = array("ii", "user_id" => $id, "state" => STATES["NEUTRO"]);
        $resultSet = $this->preparedStatement($query, $data);
        $res = mysqli_fetch_object($resultSet);
        mysqli_free_result($resultSet);
        return $res->comments;
    }

    /**
     * Método que bloquea comentarios 
     * @param String $uuid uuid del comentario a denunciar
     */
    public function block($uuid) {
        $query = "UPDATE $this->table SET `state` = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES["BLOQUEADO"], "uuid" => $uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    /**
     * Método que devuelve los comentarios asociados al anuncio
     * del id pasado por parámetro
     * @param Integer $id id del anuncio
     * @param Integer $pag contiene el número del offset 
     * de comentarios  mostrar 
     */
    public function getComments($id, $pag = 0) {
        $query = "SELECT 
            c.*,u.login, 
            u.uuid as uuid_user";
        if (isset($_SESSION['id'])) {
            $query .= ", (rep.comment_reported IS NOT NULL  AND rep.user_id = " . $_SESSION['id'] . ") AS denunciado";
        }
        $query .= " FROM $this->table AS c 
        LEFT OUTER JOIN Reports as rep
        ON 
            rep.comment_reported = c.id 
        JOIN Users AS u 
        ON 
            c.user_id=u.id 
        WHERE c.state = ?
        AND c.ad_id= ?
        GROUP BY 
            c.id 
        ORDER BY 
            c.timestamp DESC LIMIT 5 OFFSET " . $pag * 5;
        $data = array("ii", "state" => STATES["NEUTRO"], "c.ad_id" => $id);
        $res = parent::preparedStatement($query, $data);

        $resultSet = array();
        while ($row = $res->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($res);

        return $resultSet;
    }

    /**
     * Método que devuelve el número de comentarios asociados
     * al anuncio del id pasado por parámetro
     * @param Integer $id id del anuncio 
     */
    public function countCommentsAd($id) {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table "
                . "WHERE state = " . STATES['NEUTRO'] . " AND ad_id=$id ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    public function blockNoRemovedComment($ad) {
        $query = "UPDATE $this->table SET `state` = ? WHERE ad_id = ? AND state != ?";
        $data = array("is", "state" => STATES["BLOQUEADO"], "ad_id" => $ad, 'state' => STATES["ELIMINADO"]);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

}
