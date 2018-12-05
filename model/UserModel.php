<?php

require_once "core/AbstractModel.php";

use core\AbstractModel;

class UserModel extends AbstractModel {

    private $userDao;

    public function __construct() {
        $this->userDao = new UserDao();
        parent::__construct($this->userDao);
    }

    public function deleteUser($id) {
        return $this->userDao->deleteUser($id);
    }

    public function verify($usuario, $password) {
        $user = $this->userDao->search("nombre", $usuario);
        if (isset($user['nombre']) && password_verify($password, $user['password']) === TRUE) {
            return $user;
        } else {
            return NULL;
        }
    }

}
