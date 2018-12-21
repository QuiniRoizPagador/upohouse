<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class UserDao extends AbstractDao {

    public function __construct() {
        parent::__construct("users");
    }

    public function getAll($close = True) {
        $query = $this->mysqli->query("SELECT u.id, u.uuid, u.nombre, u.apellido, u.email, u.password, "
                . "u.image, r.user_role FROM users AS u JOIN user_roles AS r "
                . " ON u.user_role = r.id ORDER BY u.id DESC;");

        //Devolvemos el resultset en forma de array de objetos
        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }

        mysqli_free_result($query);
        mysqli_close($this->mysqli);
        return $resultSet;
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
        $res = $this->search("email", $obj->getEmail(), FALSE);
        if (isset($res['id'])) {
            $this->closeConnection();
            return 0;
        } else {
            $query = "INSERT INTO $this->table (id, uuid, nombre, apellido, email, password, image, user_role)
                VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)";
            $data = array("ssssssi", "uuid" => $obj->getUuid(), "nombre" => $obj->getName(), "apellido" => $obj->getSurname(),
                "email" => $obj->getEmail(), "password" => password_hash($obj->getPassword(), PASSWORD_DEFAULT)
                , "image" => $obj->getImage(), 'user_role' => $obj->getRole());
            $res = parent::preparedStatement($query, $data, FALSE);
            $this->closeConnection();
            return $res;
        }
    }

    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid(), FALSE);
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
        $query = "UPDATE $this->table SET nombre = ?, apellido = ?, password = ? WHERE uuid = ?";
        $data = array("ssss", "nombre" => $obj->getName(), "apellido" => $obj->getSurname(),
            "password" => $obj->getPassword(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

    public function deleteUser($id) {
        $user = $this->search("uuid", $id, FALSE);
        if (isset($res['id'])) {
            $this->closeConnection();
            return 0;
        } else {
            $lineas = $this->delete($user['id']);
            if ($lineas == 1 && trim($user["image"]) != "") {
                require_once 'core/GestionFicheros.php';
                eliminarImagen($user['image']);
            }
            return $lineas;
        }
    }

}
