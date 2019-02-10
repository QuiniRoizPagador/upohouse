<?php

require_once "core/AbstractModel.php";
require_once "model/dao/RequestDao.php";

use core\AbstractModel;

/**
 * Clase especialización del modelo de una petición
 */
class RequestModel extends AbstractModel {

    private $requestDao;

    /**
     * Constructor por defecto
     */
    public function __construct() {
        $this->requestDao = new RequestDao();
        parent::__construct($this->requestDao);
    }

    /**
     * Método que bloqueará una petición
     * 
     * @param string $uuid petición a bloquear
     * @return string número de filas actualizadas en la base de datos
     */
    public function block($uuid) {
        return $this->requestDao->block($uuid);
    }

    /**
     * Método que listará las peticiones de un usuario paginando
     * 
     * @param string $user usuario del que listar peticiones
     * @param integer $pag número de página a mostrar
     * @return array con listado de peticiones
     */
    public function listUserRequest($user, $pag = 0) {
        return $this->requestDao->listUserRequest($user, $pag);
    }

    /**
     * Método que contará las peticiones de un usuario
     * 
     * @param string $id id del usuario del que contar peticiones
     * @return integer  número de peticiones del usuario
     */
    public function countUserRequests($id) {
        return $this->requestDao->countUserRequests($id);
    }

    /**
     * Método que aceptará una petición
     * 
     * @param string $req_uuid petición a aceptar
     * @return string número de filas actualizadas en la base de datos
     */
    public function accept($req_uuid) {
        return $this->requestDao->accept($req_uuid);
    }

    /**
     * Método que cancelará todas las peticiones recibidas por un usuario de un determinado anuncio
     * excepto la aceptada
     * 
     * @param string $ad_id id del anuncio
     * @param string $req_id id de la petición
     * @return string número de filas afectadas en la base de datos
     */
    public function refuseAll($ad_id, $req_id = "") {
        return $this->requestDao->refuseAll($ad_id, $req_id);
    }

    /**
     * Método que cancelará una petición en particular de un usuario
     * 
     * @param string $req_uuid petición a cancelar
     * @return string número de filas afectadas en la base de datos
     */
    public function refuse($req_uuid) {
        return $this->requestDao->refuseRequest($req_uuid);
    }

    /**
     * Método que verificará la existencia de peticiones de un usuario
     * 
     * @param string $userId id del usuario
     * @param string $adId id del anuncio
     * @return boolean verificación de la existencia
     */
    public function verifyExist($userId, $adId) {
        return $this->requestDao->verifyExist($userId, $adId);
    }

    /**
     * Método que eliminará una petición
     * 
     * @param string $id uuid de la petición
     * @return string número de filas afectadas en la base de datos
     */
    public function removeRequest($id) {
        return $this->requestDao->removeRequest($id);
    }

}
