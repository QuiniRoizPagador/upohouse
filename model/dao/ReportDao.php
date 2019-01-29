<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

/**
 * Clase especializada de acceso a la base de datos para denuncias
 */
class ReportDao extends AbstractDao {

    /**
     * Método constructor
     */
    public function __construct() {
        parent::__construct("Reports");
    }

    /**
     * Método que creará una denuncia
     * 
     * @param model\dao\dto\Report $obj denuncia a crear
     * @return string número de filas afectadas en la base de datos
     */
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

    /**
     * Actualización de una petición
     * 
     * @param model\dao\dto\Report $obj petición a actualizar
     * @return string número de filas afectadas en la base de datos
     */
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

    /**
     * Método que modifica el estado de una denuncia
     * 
     * @param String $uuid uuid de la denuncia
     * @param String estado al que debe pasar la denuncia
     */
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

    /**
     * Método que devuelve el numero de usuarios denunciados
     */
    public function countReportUsers() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table "
                . "WHERE `user_reported` is not null AND state=" . STATES["NEUTRO"]
                . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    /**
     * Método que devuelve los usuarios denunciados paginados
     * 
     * @param Integer $pag número del offset de paginación
     */
    public function getAllReportUserPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT 
                    r.*, 
                    u.login AS login_reported,
                    u2.login AS login, 
                    u.uuid AS uuid_reported, 
                    u2.uuid AS uuid_user 
                FROM 
                  $this->table AS r 
                JOIN Users AS u 
                ON 
                    r.user_reported=u.id 
                JOIN Users AS u2 
                ON 
                   r.user_id=u2.id 
                WHERE 
                   user_reported IS NOT NULL 
                AND 
                   r.state=" . STATES["NEUTRO"] . "
                GROUP BY 
                  r.id ORDER BY id ASC 
                LIMIT 
                     10 OFFSET " . $pag * 10);

        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);

        return $resultSet;
    }

    /**
     * Método que devuelve el numero de anuncios denunciados
     */
    public function countReportAds() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table "
                . "WHERE `ad_reported` is not null AND state=" . STATES["NEUTRO"]
                . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    /**
     * Método que devuelve los anuncios denunciados paginados
     * 
     * @param Integer $pag número del offset de paginación
     */
    public function getAllReportAdPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT r.*,"
                . "u.login as login, a.uuid AS uuid_reported, u.uuid AS "
                . "uuid_user FROM $this->table AS r"
                . " JOIN Ads AS a ON r.ad_reported=a.id "
                . "JOIN Users AS u ON r.user_id=u.id "
                . "WHERE ad_reported IS NOT NULL AND r.state=" . STATES["NEUTRO"]
                . " GROUP BY r.id ORDER BY id ASC LIMIT 10 OFFSET " . $pag * 10);

//Devolvemos el resultset en forma de array de objetos
        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);

        return $resultSet;
    }

    /**
     * Método que devuelve el numero de comentarios denunciados
     */
    public function countReportComments() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table "
                . "WHERE `comment_reported` is not null AND state=" . STATES["NEUTRO"]
                . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    /**
     * Método que devuelve los comentarios denunciados paginados
     * 
     * @param Integer $pag número del offset de paginación
     */
    public function getAllReportCommentPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT r.*,"
                . "u.login as login, c.uuid AS uuid_reported, u.uuid AS "
                . "uuid_user, c.content FROM $this->table AS r"
                . " JOIN Comments AS c ON r.comment_reported=c.id "
                . "JOIN Users AS u ON r.user_id=u.id "
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

    /**
     * Método que devuelve el numero de peticiones denunciadas
     */
    public function countReportRequests() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table "
                . "WHERE `request_reported` is not null AND state=" . STATES["NEUTRO"]
                . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    /**
     * Método que devuelve las peticiones denunciadas paginadas
     * @param Integer $pag número del offset de paginación
     */
    public function getAllReportRequestPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT r.*,"
                . "u.login as login, re.uuid AS uuid_reported, u.uuid AS "
                . "uuid_user, re.content FROM $this->table AS r"
                . " JOIN Requests AS re ON r.request_reported=re.id "
                . "JOIN Users AS u ON r.user_id=u.id "
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

    /**
     * Método que devuelve si un usuario ha sido denunciado por 
     * el otro usuario pasado como parámetro
     * 
     * @param Integer $me id del usuario logueado
     * @param Integer $otherUser id del usuario sobre que se consulta 
     * la denuncia
     */
    public function isReportedUser($me, $otherUser) {
        $query = "SELECT count(*) as count FROM $this->table
                WHERE user_id = ? AND user_reported = ? ";
        $data = array("ii", "user_id" => $me, "user_reported" => $otherUser);
        $res = parent::preparedStatement($query, $data);
        $count = $res[0]->count;

        return $count != 0;
    }

    /**
     * Método que devuelve si un anuncio ha sido denunciado por 
     * el usuario pasado como parámetro
     * 
     * @param Integer $user id del usuario logueado
     * @param Integer $ad id del anuncio sobre que se consulta 
     * la denuncia
     */
    public function isReportedAd($user, $ad) {
        $query = "SELECT count(*) as count FROM $this->table
                WHERE user_id = ? AND ad_reported = ? ";
        $data = array("ii", "user_id" => $user, "ad_reported" => $ad);
        $res = parent::preparedStatement($query, $data);
        $count = $res[0]->count;

        return $count != 0;
    }

}
