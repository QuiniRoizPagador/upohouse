<?php

use core\AbstractController;

class UserController extends AbstractController {

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    public function index() {

        $this->verifySession();

        //Conseguimos todos los usuarios
        $allusers = $this->userModel->getAll();

        //Cargamos la vista index y le pasamos valores
        $this->view("index", array(
            'title' => "P&aacute;gina principal",
            "allusers" => $allusers
        ));
    }

    public function create() {

        $this->verifySession();

        $values = array("name", "surname", "email", "password");
        $errors = $this->filtrarStrings($values);
        if ($errors == null) {
            $filtrado = $this->sanearStrings($values);
            //Creamos un usuario
            $usuario = new User();
            $usuario->setName($filtrado["name"]);
            $usuario->setSurname($filtrado["surname"]);
            $usuario->setEmail($filtrado["email"]);
            $usuario->setPassword($filtrado["password"]);
            try {
                require_once 'core/GestionFicheros.php';
                $usuario->setImage(moverImagen('image'));
                $save = $this->userModel->create($usuario);
                if ($save == 0) {
                    die("Error al insertar usuario");
                }
            } catch (UnexpectedValueException $e) {
                die("Error al insertar usuario");
            } catch (Exception $ex) {
                die("Error al insertar usuario");
            }
            $this->redirect("User", "index");
        } else {
            //Conseguimos todos los usuarios
            $allusers = $this->userModel->getAll();

            //Cargamos la vista index y le pasamos valores
            $this->view("index", array(
                'title' => "P&aacute;gina principal",
                "allusers" => $allusers,
                "errors" => $errors
            ));
        }
    }

    public function register() {
        $values = array("name", "surname", "mail", "password");
        $errors = $this->filtrarStrings($values);
        if ($errors == null) {
            $filtrado = $this->sanearStrings($values);
            //Creamos un usuario
            $usuario = new User();
            $usuario->setName($filtrado["name"]);
            $usuario->setSurname($filtrado["surname"]);
            $usuario->setEmail($filtrado["mail"]);
            $usuario->setPassword($filtrado["password"]);
            try {
                $save = $this->userModel->create($usuario);
                if ($save == 0) {
                    die("Error al insertar usuario");
                }
            } catch (UnexpectedValueException $e) {
                die("Error al insertar usuario");
            } catch (Exception $ex) {
                die("Error al insertar usuario");
            }
            $this->redirect("Session", "login");
        } else {
            $this->view("login", array(
                'errors' => $errors
            ));
        }
    }

    public function remove() {

        $this->verifySession();

        if (filter_has_var(INPUT_GET, "id")) {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $rem = $this->userModel->deleteUser($id);
            if ($rem == 0) {
                die("Error al eliminar usuario");
            }
        }
        $this->redirect("User", "index");
    }

}
