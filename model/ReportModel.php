<?php

require_once "core/AbstractModel.php";
require_once "model/dao/ReportDao.php";

use core\AbstractModel;

class ReportModel extends AbstractModel {

    private $reportDao;

    /**
     * Método constructor
     */
    public function __construct() {
        $this->reportDao = new ReportDao();
        parent::__construct($this->reportDao);
    }

    /**
     * Método que modifica el estado de una denuncia
     * @param String $uuid uuid de la denuncia
     * @param String estado al que debe pasar la denuncia
     */
    public function modifyState($uuid, $state) {
        return $this->reportDao->modifyState($uuid, $state);
    }

    /**
     * Método que devuelve el numero de usuarios denunciados
     */
    public function countReportUsers() {
        return $this->reportDao->countReportUsers();
    }

    /**
     * Método que devuelve los usuarios denunciados paginados
     * @param Integer $pag número del offset de paginación
     */
    public function getAllReportUserPaginated($pag = 0) {
        return $this->reportDao->getAllReportUserPaginated($pag);
    }

    /**
     * Método que devuelve el numero de anuncios denunciados
     */
    public function countReportAds() {
        return $this->reportDao->countReportAds();
    }

    /**
     * Método que devuelve los anuncios denunciados paginados
     * @param Integer $pag número del offset de paginación
     */
    public function getAllReportAdPaginated($pag = 0) {
        return $this->reportDao->getAllReportAdPaginated($pag);
    }

    /**
     * Método que devuelve el numero de comentarios denunciados
     */
    public function countReportComments() {
        return $this->reportDao->countReportComments();
    }

    /**
     * Método que devuelve los comentarios denunciados paginados
     * @param Integer $pag número del offset de paginación
     */
    public function getAllReportCommentPaginated($pag = 0) {
        return $this->reportDao->getAllReportCommentPaginated($pag);
    }

    /**
     * Método que devuelve el numero de peticiones denunciadas
     */
    public function countReportRequests() {
        return $this->reportDao->countReportRequests();
    }

    /**
     * Método que devuelve las peticiones denunciadas paginadas
     * @param Integer $pag número del offset de paginación
     */
    public function getAllReportRequestPaginated($pag = 0) {
        return $this->reportDao->getAllReportRequestPaginated($pag);
    }

    /**
     * Método que devuelve si un usuario ha sido denunciado por 
     * el otro usuario pasado como parámetro
     * @param Integer $me id del usuario logueado
     * @param Integer $otherUser id del usuario sobre que se consulta 
     * la denuncia
     */
    public function isReportedUser($me, $otherUser) {
        return $this->reportDao->isReportedUser($me, $otherUser);
    }

    /**
     * Método que devuelve si un anuncio ha sido denunciado por 
     * el usuario pasado como parámetro
     * @param Integer $user id del usuario logueado
     * @param Integer $ad id del anuncio sobre que se consulta 
     * la denuncia
     */
    public function isReportedAd($user, $ad) {
        return $this->reportDao->isReportedAd($user, $ad);
    }

}
