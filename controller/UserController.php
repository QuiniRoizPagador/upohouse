<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/User.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\User;

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
        //Cargamos la vista index y le pasamos valores
        $this->view("index", array(
            'title' => "P&aacute;gina principal"
        ));
    }

    public function readUser() {
        if (filter_has_var(INPUT_POST, "uuid")) {
            $id = RegularUtils::sanearStrings(array('uuid'))['uuid'];
            $user = $this->userModel->read($id);
            if (!isset($user->id)) {
                $this->redirect("User", "index");
            } else {
                $this->view("perfil", array(
                    'title' => "Perfil $user->name",
                    "user" => $user
                ));
            }
        } else {
            $this->redirect("User", "index");
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
            $usuario->setRole(0);
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
        $this->redirect("Session", "login");
    }

}
