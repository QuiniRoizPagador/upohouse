<?php

require_once 'core/RegularUtils.php';

use core\AbstractController;
use core\RegularUtils;

class SessionController extends AbstractController {

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    public function login() {
        $this->view("login", array(
            "title" => "login",
        ));
    }

    public function logout() {
        unset($_SESSION['login']);
        unset($_SESSION['name']);
        unset($_SESSION['surname']);
        unset($_SESSION['id']);
        unset($_SESSION['email']);
        unset($_SESSION['uuid']);
        unset($_SESSION['user_role']);
        $this->redirect();
    }

    public function verify() {
        $values = array("name" => "text", "password" => "text");
        $errors = RegularUtils::filtrarPorTipo($values, "login");
        if (!isset($errors["login"])) {
            $filtrado = RegularUtils::sanearStrings(array("name", "password"));
            $user = $this->userModel->verify($filtrado['name'], $filtrado['password']);
            if (isset($user->name)) {
                if ($user->state == 'BLOQUEADO') {
                    $errors['verify'] = "usuario_bloqueado";
                } else {
                    session_start();
                    $_SESSION['login'] = $user->login;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['surname'] = $user->surname;
                    $_SESSION['id'] = $user->id;
                    $_SESSION['email'] = $user->email;
                    $_SESSION['uuid'] = $user->uuid;
                    $_SESSION['user_role'] = $user->user_role;
                    $this->redirect("User", "index");
                }
            } else {
                $errors['verify'] = "user_pass_error";
            }
        }

        $this->view("login", array(
            "title" => "login",
            'errors' => $errors
        ));
    }

}
