<?php

require_once "core/AbstractModel.php";
require_once "model/dao/ImageDao.php";

use core\AbstractModel;

/**
 * Clase especialización del modelo de imágenes.
 */
class ImageModel extends AbstractModel {

    private $imageDao;

    /**
     * Constructor por defecto
     */
    public function __construct() {
        $this->imageDao = new ImageDao();
        parent::__construct($this->imageDao);
    }

    /**
     * Método que elimina todas las imágenes asociadas a un anuncio.
     * @param Int $id Id del anuncio.
     */
    public function deleteAllByAd($id) {
        return $this->imageDao->deleteAllByAd($id);
    }

    /**
     * Método que devuelve un conjunto de imágenes vínculadas a un anuncio.
     * @param Int $id Id del anuncio.
     * @return Array Imágenes.
     */
    public function readByAd($id) {
        return $this->imageDao->readByAd($id);
    }

}
