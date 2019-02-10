<?php

require_once "core/AbstractModel.php";
require_once "model/dao/AdDao.php";

use core\AbstractModel;

/**
 * Clase especialización del modelo de anuncios.
 */
class AdModel extends AbstractModel {

    private $adDao;

    /**
     * Constructor por defecto
     */
    public function __construct() {
        $this->adDao = new AdDao();
        parent::__construct($this->adDao);
    }

    /**
     * Método que devuelve un conjunto de anuncios, en función de un offset.
     * @param $pag Offset (Entero).
     * @return Anuncios (Array).
     */
    public function getAllPaginated($pag = 0) {
        return $this->adDao->getAllPaginated($pag);
    }

    /**
     * Método que devuelve el número de anuncios del sistema.
     * @return Número de anuncios (Entero).
     */
    public function countAds() {
        return $this->adDao->countAds();
    }

    /**
     * Método que devuelve el número de anuncios del sistema asociados a un usuario.
     * @param $id Id de usuario (Entero).
     * @return Número de anuncios (Entero).
     */
    public function countUserAds($id) {
        return $this->adDao->countUserAds($id);
    }

    /**
     * Método que bloquea un anuncio en el sistema.
     * @param $uuid Uuid del anuncio (Cadena).
     */
    public function block($uuid) {
        return $this->adDao->block($uuid);
    }

    /**
     * Método que desbloquea un anuncio en el sistema.
     * @param $uuid Uuid del anuncio (Cadena).
     */
    public function unblock($uuid) {
        return $this->adDao->unblock($uuid);
    }

    /**
     * Método que devuelve un conjunto de anuncios en función de un filtro y un offset.
     * @param $str Palabras clave (Cadena).
     * @param $pag Offset (Entero).
     * @return Anuncios (Array).
     */
    public function globalSearch($str, $pag = 0) {
        return $this->adDao->globalSearch($str, $pag);
    }

    /**
     * Método que devuelve el número de anuncios que cumplen con los filtros impuestos.
     * @param $str Palabras clave (Cadena).
     * @return Número de anuncios.
     */
    public function globalCount($str) {
        return $this->adDao->countGlobalSearch($str);
    }

    /**
     * Método que acepta un anuncio.
     * @param $ad_id Id de anuncio (Entero).
     * @param $req_id Id de petición (Entero).
     */
    public function accept($ad_id, $req_id) {
        return $this->adDao->accept($ad_id, $req_id);
    }

    /**
     * Método que devuelve los primeros anuncios del sistema.
     * @return Anuncios (Array).
     */
    public function getTop() {
        return $this->adDao->getTop();
    }

    /**
     * Método que devuelve un listado de anuncios en función del tipo de casa, tipo de operación y un offset.
     * @param $house Id del tipo de casa (Entero).
     * @param $operation Id del tipo de operación (Entero).
     * @param $pag Offset (Entero).
     * @param $user Id del usuario (Entero).
     * @return Anuncios (Array).
     */
    public function listAds($house, $operation, $pag, $user) {
        return $this->adDao->listAds($house, $operation, $pag, $user);
    }

    /**
     * Método que devuelve el número de anuncios en función del tipo de casa, tipo de operación y un offset.
     * @param $house Id del tipo de casa (Entero).
     * @param $operation Id del tipo de operación (Entero).
     * @param $user Id del usuario (Entero).
     * @return Número de anuncios (Entero).
     */
    public function countListAds($house, $operation, $user) {
        return $this->adDao->countListAds($house, $operation, $user);
    }

}
