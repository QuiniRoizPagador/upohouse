<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

/**
 * Clase especializada en el acceso a la base de datos para puntuaciones
 */
class ScoreDao extends AbstractDao {

    /**
     * Constructor por defecto
     */
    public function __construct() {
        parent::__construct("Scores");
    }

    /**
     * Creación de una puntuación
     * 
     * @param model\dao\dto\Score $obj puntuación a crear
     * @return string número de filas afectadas en la base de datos
     */
    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `ad_id`, `user_id`,`score`)
                VALUES(?, ?, ?, ?)";
        $data = array("siii", "uuid" => $obj->getUuid(), "ad_id" => $obj->getAd_id(),
            "user_id" => $obj->getUser_id(), "score" => $obj->getScore());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    /**
     * Actualización de una puntuación 
     * 
     * @param model\dao\dto\Score $obj puntuación a actualizar
     * @return string número de filas afectadas en la base de datos
     */
    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid(), FALSE);
        if (trim($obj->getScore()) == '') {
            $obj->setScore($prev->score);
        }
        $query = "UPDATE $this->table SET score = ? WHERE uuid = ?";
        $data = array("is", "score" => $obj->getScore(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    /**
     * Método que verificará si el usuario ha puntuado el anuncio en cuestión
     * 
     * @param string $idUser usuario
     * @param string $idAd anuncio
     * @return boolean resultado de la comprobación
     */
    public function isUserScored($idUser, $idAd) {
        $query = "SELECT COUNT(*) AS count FROM  $this->table WHERE ad_id = ? AND user_id = ?";
        $data = array("ii", "ad_id" => $idAd, "user_id" => $idUser);
        $res = parent::preparedStatement($query, $data);
        $count = $res[0];
        return $count->count != 0;
    }

    /**
     * Método que devolverá la puntuación de un usuario a un anuncio
     * @param string $idUser usuario
     * @param string $idAd anuncio
     * @return string puntuación 
     */
    public function getUserScore($idUser, $idAd) {
        $query = "SELECT * FROM  $this->table WHERE ad_id = ? AND user_id = ?";
        $data = array("ii", "ad_id" => $idAd, "user_id" => $idUser);
        return parent::preparedStatement($query, $data)[0];
    }

}
