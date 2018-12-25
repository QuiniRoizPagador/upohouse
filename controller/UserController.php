<?php

require_once 'core/RegularUtils.php';

use core\AbstractController;
use core\RegularUtils;

class UserController extends AbstractController {

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    /**
     * Página principal del usuario
     */
    public function index() {
        //TODO: según el usuario se mostrará la dashboard del admin 
        // por defecto o su página de administración básica
        //Conseguimos todos los usuarios
        $allusers = $this->userModel->getAll();

        //Cargamos la vista index y le pasamos valores
        $this->view("index", array(
            'title' => "P&aacute;gina principal",
            "allusers" => $allusers
        ));
    }

    /**
     * Creación de un usuario por parte del admin
     */
    public function create() {
        $values = array("name", "login", "surname", "email", "password");
        $errors = RegularUtils::filtrarVariable($values);
        if ($errors == null) {
            $filtrado = RegularUtils::sanearStrings($values);
            //Creamos un usuario
            $usuario = new User();
            $usuario->setName($filtrado["name"]);
            $usuario->setSurname($filtrado["surname"]);
            $usuario->setEmail($filtrado["email"]);
            $usuario->setLogiN($filtrado['login']);
            $usuario->setPassword($filtrado["password"]);
            $usuario->setUuid(RegularUtils::uuid());
            $usuario->setUserRole(1);

            try {
                $save = $this->userModel->create($usuario);
                if ($save == 0) {
                    $errors['query'] = "Error al insertar Usuario";
                } else {
                    // si todo ha ido correcto, nos vamos a la web principal
                    $this->redirect("User", "index");
                }
            } catch (UnexpectedValueException $e) {
                die("Error al insertar usuario");
            } catch (Exception $ex) {
                die("Error al insertar usuario");
            }
        }
        if (isset($errors)) {
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

    /**
     * Registro desde la propia aplicación
     */
    public function register() {
        //TODO: mostrar errores
        $values = array("name", "surname", "mail", "password");
        $errors = RegularUtils::filtrarVariable($values);
        if ($errors == null) {
            $filtrado = RegularUtils::sanearStrings($values);
            //Creamos un usuario
            $usuario = new User();
            $usuario->setName($filtrado["name"]);
            $usuario->setSurname($filtrado["surname"]);
            $usuario->setEmail($filtrado["mail"]);
            $usuario->setPassword($filtrado["password"]);
            $usuario->setUuid(RegularUtils::uuid());
            $usuario->setRole(2);
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
        }
        $this->redirect();
    }

    /**
     * Actualización de usuario 
     */
    public function update() {
        // TODO: same user or admin
        $values = array("uuid");
        $errors = RegularUtils::filtrarVariable($values);
        if ($errors == null) {
            $values = array("name", "surname", "password", "uuid");
            $filtrado = RegularUtils::sanearStrings($values);
            //Creamos un usuario
            $usuario = new User();
            $usuario->setUuid($filtrado['uuid']);
            if (isset($filtrado["name"])) {
                $usuario->setName($filtrado['name']);
            }
            if (isset($filtrado["surname"])) {
                $usuario->setSurname($filtrado["surname"]);
            }
            if (isset($filtrado["password"])) {
                $usuario->setPassword($filtrado["password"]);
            }
            try {
                $save = $this->userModel->update($usuario);
                if ($save == 0) {
                    die("Error al insertar usuario");
                } else {
                    $this->redirect("User", "index");
                }
            } catch (UnexpectedValueException $e) {
                die("Error al insertar usuario");
            } catch (Exception $ex) {
                die("Error al insertar usuario");
            }
        } else {
            $allusers = $this->userModel->getAll();

            //Cargamos la vista index y le pasamos valores
            $this->view("index", array(
                'title' => "P&aacute;gina principal",
                "allusers" => $allusers,
                "errors" => $errors
            ));
        }
    }

    public function remove() {
        if (filter_has_var(INPUT_POST, "uuid") && (verifyIsAdmin()/* || verifyIsSame() */)) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $rem = $this->userModel->delete($id);
            if ($rem == 0) {
                die("Error al eliminar usuario");
            }
        }
        $this->redirect("User", "index");
    }

}
