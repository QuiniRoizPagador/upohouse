<?php

require_once "core/AbstractModel.php";
require_once "model/dao/CommunityDao.php";

use core\AbstractModel;

/**
 * Clase especialización del modelo de comunidad.
 */
class CommunityModel extends AbstractModel {

    private $communityDao;

    /**
     * Constructor por defecto
     */
    public function __construct() {
        $this->communityDao = new CommunityDao();
        parent::__construct($this->communityDao);
    }

    /**
     * Método que devuelve una comunidad en función de un identificador.
     * @param $id Id de comunidad (Entero).
     */
    public function readId($id) {
        return $this->communityDao->readId($id);
    }

}
