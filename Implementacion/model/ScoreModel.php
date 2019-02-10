<?php

require_once "core/AbstractModel.php";
require_once "model/dao/ScoreDao.php";

use core\AbstractModel;

/**
 * Clase especialización del modelo de puntuación.
 */
class ScoreModel extends AbstractModel {

    private $scoreDao;

    /**
     * Constructor por defecto
     */
    public function __construct() {
        $this->scoreDao = new ScoreDao();
        parent::__construct($this->scoreDao);
    }

    /**
     * Método verifica si un usuario ha valorado un anuncio.
     * @param Int $idUser Id del usuario.
     * @param Int $idAd Id del anuncio.
     * @return Boolean En función de si el usuario a puntuado el anuncio.
     */
    public function isUserScored($idUser, $idAd) {
        return $this->scoreDao->isUserScored($idUser, $idAd);
    }

    /**
     * Método que devuelve la puntuación asociada a un anuncio por parte de un usuario.
     * @param Int $idUser Id del usuario.
     * @param Int $idAd Id del anuncio.
     * @return Object Puntuación.
     */
    public function getUserScore($idUser, $idAd) {
        return $this->scoreDao->getUserScore($idUser, $idAd);
    }

}
