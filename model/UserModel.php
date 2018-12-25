<?php

require_once "core/AbstractModel.php";

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

}
