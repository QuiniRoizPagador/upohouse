<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class UserDao extends AbstractDao {

    private $table;

    public function __construct() {
        $this->table = "users";
        parent::__construct($this->table);
    }

    public function searchUser($column, $value) {
        $query = "SELECT u.nombre, u.apellido, u.email, u.password, "
                . "u.image, r.user_role "
                . "FROM users AS u JOIN user_roles AS r "
                . "ON u.user_role = r.id "
                . "WHERE $column = ?";
        $data = array("s", $column => $value);
        $resultSet = $this->preparedStatement($query, $data);
        $datos = mysqli_fetch_assoc($resultSet);
        mysqli_free_result($resultSet);
        $this->closeConnection();
        return $datos;
    }

    //put your code here
    public function create($obj) {
        $query = "SELECT * FROM $this->table WHERE email = ? LIMIT 1";
        $data = array("s", "email" => $obj->getEmail());
        $resultSet = parent::preparedStatement($query, $data);
        $res = mysqli_fetch_assoc($resultSet);
        mysqli_free_result($resultSet);
        if (isset($res['id'])) {
            //$this->closeConnection();
            return 0;
        } else {
            $query = "INSERT INTO $this->table (id,nombre,apellido,email,password, image, user_role)
                VALUES(NULL,?,?,?,?,?, 2) ;";
            $data = array("sssss", "nombre" => $obj->getName(), "apellido" => $obj->getSurname(),
                "email" => $obj->getEmail(), "password" => password_hash($obj->getPassword(), PASSWORD_DEFAULT)
                , "image" => $obj->getImage());
            $res = parent::preparedStatement($query, $data, FALSE);
            $this->closeConnection();
            return $res;
        }
    }

    public function update($obj) {
        $query = "SELECT * FROM $this->table WHERE id = ? LIMIT 1";
        $data = array("i", "id" => $obj->getId());
        $resultSet = parent::preparedStatement($query, $data);
        $prev = mysqli_fetch_assoc($resultSet);
        mysqli_free_result($resultSet);
        if (trim($obj->getName()) == '') {
            $obj->setName($prev['nombre']);
        }
        if (trim($obj->getSurname()) == '') {
            $obj->setSurname($prev['apellido']);
        }
        if (trim($obj->getPassword()) == '') {
            $obj->setPassword($prev['password']);
        } else {
            $obj->setPassword(password_hash($obj->getPassword(), PASSWORD_DEFAULT));
        }
        $query = "UPDATE $this->table SET nombre = ?, apellido = ?, password = ? WHERE id = ? ";
        $data = array("sssi", "nombre" => $obj->getName(), "apellido" => $obj->getSurname(),
            "password" => $obj->getPassword(), "id" => $obj->getId());
        print_r($obj);
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
