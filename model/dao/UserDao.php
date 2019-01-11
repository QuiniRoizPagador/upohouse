<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class UserDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Users");
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
        return $user;
    }

    public function create($obj) {
        $query = "SELECT count(*) as count FROM $this->table WHERE login = ? OR email = ?";
        $data = array("ss", "login" => $obj->getLogin(), "email" => $obj->getEmail());
        $resultSet = parent::preparedStatement($query, $data, TRUE);
        $count = mysqli_fetch_object($resultSet);
        mysqli_free_result($resultSet);
        if ($count->count > 0) {
            return "duplicate_user";
        } else {
            $query = "INSERT INTO $this->table (`uuid`, `name`, `surname`,`email`, `password`, `login`, `user_role`, `phone`)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            $data = array("ssssssis", "uuid" => $obj->getUuid(), "name" => $obj->getName(), "surname" => $obj->getSurname(),
                "email" => $obj->getEmail(), "password" => password_hash($obj->getPassword(), PASSWORD_DEFAULT)
                , "login" => $obj->getLogin(), 'user_role' => $obj->getUserRole(), 'phone' => $obj->getPhone());
            $res = parent::preparedStatement($query, $data, FALSE);
            return $res;
        }
    }

    public function delete($id) {
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES['ELIMINADO'], "uuid" => $id);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid());
        if (trim($obj->getName()) == '') {
            $obj->setName($prev->name);
        }
        if (trim($obj->getSurname()) == '') {
            $obj->setSurname($prev->surname);
        }
        if (trim($obj->getPhone()) == '') {
            $obj->setPhone($prev->phone);
        }
        if (trim($obj->getPassword()) == '') {
            $obj->setPassword($prev->password);
        } else {
            $obj->setPassword(password_hash($obj->getPassword(), PASSWORD_DEFAULT));
        }
        if(trim($obj->getUserRole()) == ''){
            $obj->setUserRole($prev->user_role);
        }
        $query = "UPDATE $this->table SET name = ?, surname = ?, password = ?, "
                . "user_role = ?, phone = ? WHERE uuid = ?";
        $data = array("sssiss", "name" => $obj->getName(), "surname" => $obj->getSurname(),
            "password" => $obj->getPassword(), "user_role" => $obj->getUserRole(),
            "phone" => $obj->getPhone(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function block($uuid) {
        $query = "UPDATE $this->table SET `state` = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES["BLOQUEADO"], "uuid" => $uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function getAllPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT * FROM $this->table "
                . "WHERE state != " . STATES['ELIMINADO'] . " "
                . "ORDER BY id ASC LIMIT 10 OFFSET " . $pag * 10);
        //Devolvemos el resultset en forma de array de objetos

        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);
        return $resultSet;
    }

    public function countRegistrations() {
        $query = $this->mysqli->query("select COUNT(*) as count, MONTH(`timestamp`) as month,"
                . "YEAR(`timestamp`) as year from $this->table "
                . "GROUP BY MONTH(`timestamp`),YEAR(`timestamp`) "
                . "ORDER BY year(`timestamp`) DESC");

        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);
        return $resultSet;
    }

    public function countUsers() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table WHERE state != " . STATES['ELIMINADO'] . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    public function unlock($uuid) {
        $query = "UPDATE $this->table SET `state` = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES["NEUTRO"], "uuid" => $uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

}
