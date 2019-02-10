<?php

require_once 'core/RegularUtils.php';

use core\AbstractController;
use core\RegularUtils;

/**
 * Clase controladora de la sesión y sus acciones básicas relacionadas.
 */
class SessionController extends AbstractController {

    private $userModel;

    /*
     * Método constructor de la clase.
     */
    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    /*
     * Método que muestra la vista de iniciar sesión
     */
    public function login() {
        $this->view("login", array(
            "title" => "login",
        ));
    }

    /*
     * Método que cierra la sesión de un usuario logueado en el sistema.
     */
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

    /*
     * Método que inicia la sesión de un usuario en el sistema, si los
     * datos introducidos son correctos.
     */
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
                    $_SESSION['login'] = $user->login;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['surname'] = $user->surname;
                    $_SESSION['id'] = $user->id;
                    $_SESSION['email'] = $user->email;
                    $_SESSION['uuid'] = $user->uuid;
                    $_SESSION['user_role'] = $user->user_role;
                    $this->redirect("user", "index");
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
