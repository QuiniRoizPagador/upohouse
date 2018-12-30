<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class UserDao extends AbstractDao {

    public function __construct() {
        parent::__construct("users");
    }

    public function searchUser($login) {
        $query = "SELECT u.id, u.uuid, u.name, u.surname, "
                . "u.email,u.password, u.uuid, u.login, u.user_role, "
                . "s.state FROM Users as u JOIN State_Types as s "
                . "ON u.state = s.id "
                . "WHERE (LOWER(u.login) = LOWER(?) OR LOWER(u.email) = LOWER(?)) AND u.state != ?";
        $data = array("ssi", "u.login" => $login, "u.email" => $login, "u.state" => STATES['ELIMINADO']);
        $resultSet = $this->preparedStatement($query, $data);
        $user = mysqli_fetch_object($resultSet);
        mysqli_free_result($resultSet);
        $this->closeConnection();
        return $user;
    }

    public function create($obj) {
        $res = $this->search("email", $obj->getEmail(), FALSE);
        if (isset($res->id)) {
            $this->closeConnection();
            return 0;
        } else {
            $query = "INSERT INTO $this->table (`uuid`, `name`, `surname`,`email`, `password`, `login`, `user_role`)
                VALUES(?, ?, ?, ?, ?, ?, ?)";
            $data = array("ssssssi", "uuid" => $obj->getUuid(), "name" => $obj->getName(), "surname" => $obj->getSurname(),
                "email" => $obj->getEmail(), "password" => password_hash($obj->getPassword(), PASSWORD_DEFAULT)
                , "login" => $obj->getLogin(), 'user_role' => $obj->getUserRole());
            $res = parent::preparedStatement($query, $data, FALSE);
            $this->closeConnection();
            return $res;
        }
    }

    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid(), FALSE);
        if (trim($obj->getName()) == '') {
            $obj->setName($prev->name);
        }
        if (trim($obj->getSurname()) == '') {
            $obj->setSurname($prev->surname);
        }
        if (trim($obj->getPassword()) == '') {
            $obj->setPassword($prev->password);
        } else {
            $obj->setPassword(password_hash($obj->getPassword(), PASSWORD_DEFAULT));
        }
        $query = "UPDATE $this->table SET name = ?, surname = ?, password = ? WHERE uuid = ?";
        $data = array("ssss", "name" => $obj->getName(), "surname" => $obj->getSurname(),
            "password" => $obj->getPassword(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

    public function block($uuid) {
        $query = "UPDATE $this->table SET `state` = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES["BLOQUEADO"], "uuid" => $uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

    public function getAllPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT * FROM $this->table ORDER BY id DESC LIMIT 10 OFFSET " . $pag * 10);
        //Devolvemos el resultset en forma de array de objetos

        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);
        mysqli_close($this->mysqli);

        return $resultSet;
    }

    public function countUsers($close = TRUE) {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        if ($close) {
            mysqli_close($this->mysqli);
        }
        return $row->count;
    }

}
