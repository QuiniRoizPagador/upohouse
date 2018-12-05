<?php

use core\AbstractController;

class SessionController extends AbstractController {

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    public function login() {
        $this->view("login", array());
    }

    public function logout() {
        session_start();
        session_destroy();
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
                $filtrado = $this->sanearStrings(array("name", "password"));
                $user = $this->userModel->verify($filtrado['name'], $filtrado['password']);
                if (isset($user['nombre'])) {
                    session_start();
                    $_SESSION['name'] = $user['nombre'];
                    $this->redirect("User", "index");
                } else {
                    $errors['login'] = "Usuario o contraseña erróneos";
                }
            }
        } else {
            $errors['login'] = "Requerido usuario y contraseña";
        }

        $this->view("login", array(
            'errors' => $errors
        ));
    }

}
