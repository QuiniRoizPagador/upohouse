<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class UserDao extends AbstractDao {

    public function __construct() {
        parent::__construct("users");
    }

    public function searchUser($login) {
        $query = "SELECT * FROM users "
                . "WHERE LOWER(name) = LOWER(?) OR LOWER(email) = LOWER(?) ";
        $data = array("ss", "name" => $login, "email" => $login);
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

}
