<?php

use core\AbstractController;

class WSController extends AbstractController {

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    public function prueba() {
        // TODO: controlar encapsulando solo los atributos necesarios por seguridad
        if (filter_has_var(INPUT_POST, "nombre")) {
            $nombre = $this->userModel->sanearStrings(array('nombre'))['nombre'];
            echo json_encode(array($this->userModel->search("nombre", $nombre)));
        } else {
            $this->redirect();
        }
    }

    public function paginateUsers() {
        if (filter_has_var(INPUT_POST, "userPag")) {
            $num = filter_var($_POST['userPag'], FILTER_SANITIZE_NUMBER_INT);
            $allusers = $this->userModel->getAllPaginated($num);
            echo json_encode($allusers);
        } else {
            $this->redirect();
        }
    }

}
