<?php

require_once "core/AbstractModel.php";
require_once "model/dao/CommentDao.php";

use core\AbstractModel;

class CommentModel extends AbstractModel {

    private $commentDao;

    /**
     * Método constructor
     */
    public function __construct() {
        $this->commentDao = new CommentDao();
        parent::__construct($this->commentDao);
    }

    /**
     * Método que devuelve el número de comentarios neutros
     */
    public function countComments() {
        return $this->commentDao->countComments();
    }

    /**
     * Método que devuelve el número de registros de comentarios
     */
    public function countRegistrationComments() {
        return $this->commentDao->countRegistrationComments();
    }

    /**
     * Método que devuelve los comentarios paginados
     * @param Integer $pag contiene el número de la página a mostrar
     */
    public function getAllPaginated($pag = 0) {
        return $this->commentDao->getAllPaginated($pag);
    }

    /**
     * Método que devuelve el número de comentarios realizados
     * por el usuario del id pasado por parámetro
     * @param Integer $id id del usuario 
     */
    public function countUserComments($id) {
        return $this->commentDao->countUserComments($id);
    }

    /**
     * Método que bloquea comentarios 
     * @param String $uuid uuid del comentario a denunciar
     */
    public function block($uuid) {
        return $this->commentDao->block($uuid);
    }

    /**
     * Método que devuelve los comentarios asociados al anuncio
     * del id pasado por parámetro
     * @param Integer $id id del anuncio
     * @param Integer $pag contiene el número del offset 
     * de comentarios  mostrar 
     */
    public function getComments($id, $pag = 0) {
        return $this->commentDao->getComments($id, $pag);
    }

    /**
     * Método que devuelve el número de comentarios asociados
     * al anuncio del id pasado por parámetro
     * @param Integer $id id del anuncio 
     */
    public function countCommentsAd($id) {
        return $this->commentDao->countCommentsAd($id);
    }

    /**
     * Método que borra comentarios 
     * @param Integer $id uuid del comentario 
     */
    public function removeComment($id) {
        return $this->commentDao->delete($id);
    }

    /**
     * Método que bloqueará los comentaros no eliminados
     * @param nt $ad anuncio asociado
     */
    public function blockNoRemovedComment($ad) {
        return $this->commentDao->blockNoRemovedComment($ad);
    }

}
