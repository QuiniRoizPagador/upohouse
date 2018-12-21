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

    public function create($obj) {
        $res = $this->search("email", $obj->getEmail());
        if (isset($res['id'])) {
            $this->closeConnection();
            return 0;
        } else {
            $query = "INSERT INTO $this->table (id,nombre,apellido,email,password, image, user_role)
                VALUES(NULL,?,?,?,?,?,?) ;";
            $data = array("sssssi", "nombre" => $obj->getName(), "apellido" => $obj->getSurname(),
                "email" => $obj->getEmail(), "password" => password_hash($obj->getPassword(), PASSWORD_DEFAULT)
                , "image" => $obj->getImage(), 'user_role' => $obj->getRole());
            $res = parent::preparedStatement($query, $data, FALSE);
            $this->closeConnection();
            return $res;
        }
    }

    public function update($obj) {
        $prev = $this->read($obj->getId(), FALSE);
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
        $user = mysqli_fetch_assoc($resultSet);
        mysqli_free_result($resultSet);

        $lineas = $this->delete($id);
        if ($lineas == 1 && trim($user["image"]) != "") {
            require_once 'core/GestionFicheros.php';
            eliminarImagen($image['image']);
        }
        return $lineas;
    }

}
