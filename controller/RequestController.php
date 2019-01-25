<?php

require_once 'core/RegularUtils.php';
require_once 'core/MailUtils.php';
require_once 'model/dao/dto/Request.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\Request;
use core\MailUtils;

class RequestController extends AbstractController {

    private $requestModel;
    private $adModel;
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->adModel = new AdModel();
        $this->requestModel = new RequestModel();
        $this->userModel = new UserModel();
    }

    public function accept() {
        $variables = array('req_uuid' => "text", 'ad_uuid' => "text", "user_uuid" => "text");
        $errors = RegularUtils::filtrarPorTipo($variables, "accept");
        print_r($errors);
        if (!isset($errors['accept'])) {
            $variables = array('req_uuid', 'ad_uuid', "user_uuid");
            $filtrado = RegularUtils::sanearStrings($variables);
            $req_uuid = $filtrado['req_uuid'];
            $ad_uuid = $filtrado['ad_uuid'];
            $user_uuid = $filtrado['user_uuid'];

            $ad = $this->adModel->read($ad_uuid);
            if ($ad->user_id == $_SESSION['id']) {

                $user = $this->userModel->read($user_uuid);

                $request = $this->requestModel->read($req_uuid);

                $this->adModel->accept($ad->id, $request->id);
                $this->requestModel->accept($req_uuid);
                $this->requestModel->refuseAll($ad->id, $request->id);

                MailUtils::sendMail("quiniroiz@gmail.com", "Peticion aceptada", "prueba", "From: Quini <quiniroiz@gmail.com>");
                $this->redirect("user", "readUser", array("uuid" => $_SESSION['uuid']));
            } else {
                $this->redirect();
            }
        } else {
            $this->redirect();
        }
    }

    public function refuse() {
        $variables = array('req_uuid' => "text");
        $errors = RegularUtils::filtrarPorTipo($variables, "accept");
        print_r($errors);
        if (!isset($errors['accept'])) {
            $variables = array('req_uuid');
            $filtrado = RegularUtils::sanearStrings($variables);
            $req_uuid = $filtrado['req_uuid'];

            $this->requestModel->refuse($req_uuid);


            $this->redirect("user", "readUser", array("uuid" => $_SESSION['uuid']));
        } else {
            $this->redirect();
        }
    }

}
