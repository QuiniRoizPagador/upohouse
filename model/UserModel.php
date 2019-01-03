<?php

require_once "core/AbstractModel.php";
require_once "model/dao/UserDao.php";

use core\AbstractModel;

class UserModel extends AbstractModel {

    private $userDao;

    public function __construct() {
        $this->userDao = new UserDao();
        parent::__construct($this->userDao);
    }

    public function verify($usuario, $password) {
        $user = $this->userDao->searchUser($usuario);
        if (isset($user->login) && password_verify($password, $user->password) === TRUE) {
            return $user;
        } else {
            return NULL;
        }
    }

    public function block($uuid) {
        return $this->userDao->block($uuid);
    }

    public function getAllPaginated($pag = 0, $close = TRUE) {
        return $this->userDao->getAllPaginated($pag, $close);
    }

    public function countUsers($close = TRUE) {
        return $this->userDao->countUsers($close);
    }

    public function countRegistrations($close = TRUE) {
        return $this->userDao->countRegistrations($close);
    }

}
