<?php

require_once 'core/RegularUtils.php';
require_once 'core/MailUtils.php';
require_once 'model/dao/dto/Request.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\Request;
use core\MailUtils;

/**
 * Clase controladora encargada de las acciones relacionadas con las peticiones
 */
class RequestController extends AbstractController {

    private $requestModel;
    private $adModel;
    private $userModel;

    /**
     * Constructor por defecto
     */
    public function __construct() {
        parent::__construct();
        $this->adModel = new AdModel();
        $this->requestModel = new RequestModel();
        $this->userModel = new UserModel();
    }

    /**
     * Método para aceptar una petición sobre un anuncio
     */
    public function accept() {
        $variables = array('req_uuid' => "text", 'ad_uuid' => "text", "user_uuid" => "text");
        $errors = RegularUtils::filtrarPorTipo($variables, "accept");
        if (!isset($errors['accept'])) {
            $variables = array('req_uuid', 'ad_uuid', "user_uuid");
            $filtrado = RegularUtils::sanearStrings($variables);
            $req_uuid = $filtrado['req_uuid'];
            $ad_uuid = $filtrado['ad_uuid'];
            $user_uuid = $filtrado['user_uuid'];
            $ownerUserName = $_SESSION['name'];
            $ownerUserEmail = $_SESSION['email'];

            $ad = $this->adModel->read($ad_uuid);
            if ($ad->user_id == $_SESSION['id']) {

                $user = $this->userModel->read($user_uuid);

                $request = $this->requestModel->read($req_uuid);

                $this->adModel->accept($ad->id, $request->id);
                $this->requestModel->accept($req_uuid);
                $this->requestModel->refuseAll($ad->id, $request->id);

                //Versión gratuita
                /* MailUtils::sendFreeMail($user->email, "Your request was accepted", "Estimated $user->name, We are pleased to inform you that your"
                  . " request to the advertisement posted by $ownerUserName ($ownerUserEmail) has been accepted."
                  . " Therefore, the website terminates the agreement, and with this, your participation."
                  . " We hope that the service provided was to your liking.\n\nKind regards,\n\nThe technical"
                  . " team of Upohouse.", "From: upohouse@gmail.com"); */

                //Versión de pago
                MailUtils::sendMail($user->email, "Your request was accepted", "<p>Estimated $user->name, 
                  We are pleased to inform you that your request to the advertisement posted by $ownerUserName "
                        . "($ownerUserEmail) has been accepted. Therefore, the website terminates the agreement, "
                        . "and with this, your participation. We hope that the service provided was to your "
                        . "liking.</p><p>Kind regards,</p><p>The technical team of Upohouse.</p>");
                $this->redirect("user", "readUser", array("uuid" => $_SESSION['uuid']));
            } else {
                $this->redirect();
            }
        } else {
            $this->redirect();
        }
    }

    /**
     * Método para rechazar una petición sobre un anuncio
     */
    public function refuse() {
        $variables = array('req_uuid' => "text");
        $errors = RegularUtils::filtrarPorTipo($variables, "refuse");
        if (!isset($errors['refuse'])) {
            $variables = array('req_uuid');
            $filtrado = RegularUtils::sanearStrings($variables);
            $req_uuid = $filtrado['req_uuid'];

            $this->requestModel->refuse($req_uuid);

            $this->redirect("user", "readUser", array("uuid" => $_SESSION['uuid']));
        } else {
            $this->redirect();
        }
    }

    /**
     * Método para crear una petición del usuario sobre un anuncio consultado
     */
    public function createRequest() {
        $variables = array('content' => "longText", "ad_uuid" => "text");
        $errors = RegularUtils::filtrarPorTipo($variables, "createRequest");
        if (!isset($errors['createRequest'])) {
            $variables = array('content', 'ad_uuid');
            $filtrado = RegularUtils::sanearStrings($variables);
            $ad = $this->adModel->read($filtrado['ad_uuid']);
            if ($ad) {
                $exists = $this->requestModel->verifyExist($_SESSION['id'], $ad->id);
                if (!$exists) {
                    // crear la petición y almacenarla
                    $request = new Request();
                    $request->setUuid(RegularUtils::uuid());
                    $content = str_replace("\n", "<br />", $filtrado['content']);

                    $request->setContent($content);
                    $request->setAd_id($ad->id);
                    $request->setUser_id($_SESSION['id']);
                    $this->requestModel->create($request);
                }
            }
            $this->redirect("ad", "read", array("uuid" => $filtrado['ad_uuid']));
        } else {
            // error en las variables esperadas
            $array = array("uuid" => $_POST['ad_uuid']);
            if (isset($errors['createRequest']['content'])) {
                $array['content'] = $errors['createRequest']['content'];
            }
            $this->redirect("ad", "read", $array);
        }
    }

}
