<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class UserDao extends AbstractDao {
    /*
     * CREATE TABLE IF NOT EXISTS `pruebas`.`users`(
      `id` INT primary key AUTO_INCREMENT,
      `nombre` VARCHAR(50) NOT NULL,
      `apellido` VARCHAR(50) NOT NULL,
      `email` VARCHAR(100) NOT NULL,
      `password` BLOB NOT NULL
      ) ENGINE = InnoDB;

      insert into `pruebas`.`users` (id, nombre, apellido, email, password)
      values (null, "quini", "roiz", "quiniroiz@gmail.com", AES_ENCRYPT("micontraseña", "keyPrivada"));
     */

    private $table;

    public function __construct() {
        $this->table = "users";
        parent::__construct($this->table);
    }

    //put your code here
    public function create($obj) {
        // controlar existencia de usuario
        $query = "SELECT * FROM $this->table WHERE email = ?";
        $data = array("s", "email" => $obj->getEmail());
        $resultSet = parent::preparedStatement($query, $data);
        $res = mysqli_fetch_assoc($resultSet);
        mysqli_free_result($resultSet);
        if (isset($res['id'])) {
            //$this->closeConnection();
            return 0;
        } else {
            $query = "INSERT INTO $this->table (id,nombre,apellido,email,password, image)
                VALUES(NULL,?,?,?,?,?) ;";
            $data = array("sssss", "nombre" => $obj->getName(), "apellido" => $obj->getSurname(),
                "email" => $obj->getEmail(), "password" => password_hash($obj->getPassword(), PASSWORD_DEFAULT)
                , "image" => $obj->getImage());
            $res = parent::preparedStatement($query, $data, FALSE);
            $this->closeConnection();
            return $res;
        }
    }

    public function update($obj) {
        // TODO: revisar y arreglar, da error
        $query = "SELECT * FROM $this->table WHERE email = ?";
        $data = array("s", "email" => $obj->getEmail());
        $resultSet = parent::preparedStatement($query, $data);
        $prev = mysqli_fetch_assoc($resultSet);
        mysqli_free_result($resultSet);


        $query = "UPDATE $this->table SET (nombre,apellido,password)
                VALUES(?,?,?) WHERE id = ? ;";
        $data = array("sssi", "nombre" => $obj->getName(), "apellido" => $obj->getSurname(),
            "password" => password_hash($obj->getPassword(), PASSWORD_DEFAULT)
            , "id" => $obj->getId());
        $res = parent::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

    public function deleteUser($id) {
        $query = "SELECT image FROM $this->table WHERE id = ? ;";
        $data = array("i", "id" => $id);
        $resultSet = parent::preparedStatement($query, $data);
        $image = mysqli_fetch_assoc($resultSet);
        mysqli_free_result($resultSet);

        $lineas = $this->delete($id);
        if ($lineas == 1 && trim($image["image"]) != "") {
            require_once 'core/GestionFicheros.php';
            eliminarImagen($image['image']);
        }
        return $lineas;
    }

}
