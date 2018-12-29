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
        if (filter_has_var(INPUT_POST, "name") && filter_has_var(INPUT_POST, "password")) {
            if (trim($_POST['name']) == "") {
                $errors['name'] = "Campo Requerido";
            }
            if (trim($_POST['password']) == "") {
                $errors['password'] = "Campo Requerido";
            }
            if (!isset($errors)) {
                $filtrado = RegularUtils::sanearStrings(array("name", "password"));
                $user = $this->userModel->verify($filtrado['name'], $filtrado['password']);
                if (isset($user->name)) {
                    if ($user->state == 'BLOQUEADO') {
                        $errors['login'] = "Usuario Bloqueado en el sistema";
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
                    $errors['login'] = "Usuario o contraseña erróneos";
                }
            }
        } else {
            $errors['login'] = "Requerido usuario y contraseña";
        }

        $this->view("login", array(
            "title" => "login",
            'errors' => $errors
        ));
    }

}
