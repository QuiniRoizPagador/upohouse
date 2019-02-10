<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class HousingTypeDao extends AbstractDao {

    /**
     * Método constructor
     */
    public function __construct() {
        parent::__construct("Housing_Types");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `name`)
                VALUES(?, ?)";
        $data = array("ss", "uuid" => $obj->getUuid(), "name" => $obj->getName());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid(), FALSE);
        if (trim($obj->getName()) == '') {
            $obj->setName($prev->name);
        }
        $query = "UPDATE $this->table SET name = ? WHERE uuid = ?";
        $data = array("ss", "name" => $obj->getName(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }
    
    /**
     * Método que devuelve el número de tipos de casas 
     */
    public function countHousingTypes() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }
    
    /**
     * Método que devuelve los tipos de casas paginados
     * @param Integer $pag offset de la paginacion de tipos de casas
     */
    public function getAllPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT * FROM $this->table "
                . "ORDER BY id ASC LIMIT 10 OFFSET " . $pag * 10);
        //Devolvemos el resultset en forma de array de objetos

        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);

        return $resultSet;
    }

}
