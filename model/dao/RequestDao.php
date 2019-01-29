<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

/**
 * Clase especializada en el acceso a la base de datos de las peticiones
 */
class RequestDao extends AbstractDao {

    /**
     * Constructor por defecto
     */
    public function __construct() {
        parent::__construct("Requests");
    }

    /**
     * Método de creación de una petición
     * 
     * @param \model\dao\dto\Request $obj petición a crear
     * @return string número de filas afectadas
     */
    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `content`, `ad_id`,`user_id`)
                VALUES(?, ?, ?, ?)";
        $data = array("ssii", "uuid" => $obj->getUuid(), "content" => $obj->getContent(), "ad_id" => $obj->getAd_id(),
            "user_id" => $obj->getUser_id());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    /**
     * Método que actualiza una petición
     * 
     * @param \model\dao\dto\Request $obj petición a actualizar
     * @return string número de filas afectadas
     */
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

    /**
     * Método que listará las peticiones del usuario paginando
     * 
     * @param string $user id del usuario a buscar
     * @param integer $pag número de página a listar
     * @return array con el listado paginado
     */
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
        return parent::preparedStatement($query, $data);
    }

    /**
     * Método que contará las peticiones de un usuario
     * 
     * @param string $id id del usuario a buscar
     * @return integer con el número de peticiones del usuario
     */
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
        $res = parent::preparedStatement($query, $data);
        $count = $res[0]->count;
        return $count;
    }

    /**
     * Método que aceptará una petición 
     * 
     * @param string $req_uuid id de la petición a aceptar
     * @return string número de filas afectadas
     */
    public function accept($req_uuid) {
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES['ACEPTADO'], "uuid" => $req_uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    /**
     * Método que rechazará las peticiones asociadas a un anuncio menos una en particular
     * 
     * @param string $ad_id id del anuncio
     * @param string $req_id id de la petición a no rechazar
     * @return string número de filas afectadas
     */
    public function refuseAll($ad_id, $req_id) {
        $query = "UPDATE $this->table SET state = ? WHERE ad_id = ? AND id != ?";
        $data = array("iss", "state" => STATES['DESCARTADO'], "ad_id" => $ad_id, "id" => $req_id);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    /**
     * Método que rechazará una petición 
     * 
     * @param type $req_uuid id de la petición a rechazará
     * @return string número de filas afectadas
     */
    public function refuseRequest($req_uuid) {
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ? ";
        $data = array("is", "state" => STATES['DESCARTADO'], "uuid" => $req_uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    /**
     * Método que bloqueará el estado de una petición
     * 
     * @param string $uuid uuid de la petición a bloquear
     * @return string número de filas afectadas
     */
    public function block($uuid) {
        $query = "UPDATE $this->table SET `state` = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES["BLOQUEADO"], "uuid" => $uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    /**
     * Método que verificará la existencia de una petición cuyo usuario y anuncio
     * sean los pasados por parámetros
     * 
     * @param string $userId usuario asociado
     * @param string $adId anuncio asociado
     * @return boolean verificación de la existencia
     */
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
        $res = parent::preparedStatement($query, $data);
        $count = $res[0]->count;
        return $count != 0;
    }

     /**
     * Método que eliminará una petición
     * 
     * @param string $id uuid de la petición
     * @return string número de filas afectadas en la base de datos
     */
    public function removeRequest($id) {
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ? ";
        $data = array("is", "state" => STATES['ELIMINADO'], "uuid" => $id);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

}
