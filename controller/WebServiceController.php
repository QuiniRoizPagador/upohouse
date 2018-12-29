<?php

use core\AbstractController;

class WebServiceController extends AbstractController {

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
        if (filter_has_var(INPUT_GET, "userPag")) {
            $num = filter_var($_GET['userPag'], FILTER_SANITIZE_NUMBER_INT);
        } else {
            $num = 0;
        }
        $allusers = $this->userModel->getAllPaginated($num * 10);
        foreach ($allusers as $user) {
            $users[] = utf8_encode(print_r($user)) . "<br/>";
        }
        echo json_encode($users);
    }

}
