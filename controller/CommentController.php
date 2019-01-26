<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/Comment.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\Comment;

class CommentController extends AbstractController{

    private $commentModel;
    private $adModel;
    
    public function __construct() {
        parent::__construct();
        $this->commentModel = new CommentModel();
        $this->adModel=new AdModel();
    }

    public function createComment() {
        if (isset($_POST["uuidAd"]) && isset($_POST["comentario"]) && strlen(trim($_POST["comentario"])) > 0) {
            $values = array("comentario" => "text");
            $errors = RegularUtils::filtrarPorTipo($values, "createComment");
            if (!isset($errors["createComment"])) {
                $values = array("comentario", "uuidAd");
                $filtrado = RegularUtils::sanearStrings($values);
                
                $ad=$this->adModel->read($filtrado["uuidAd"]);
                
                
                $comentario = new Comment();
                $comentario->setAd_id($ad->id);
                $comentario->setUser_id($_SESSION['id']);
                $comentario->setUuid(RegularUtils::uuid());
                $comentario->setContent($filtrado["comentario"]);
                
                $save = $this->commentModel->create($comentario);
                if ($save != 1) {
                    $errors['createComment']['query'] = $save;
                } else {
                    // si todo ha ido correcto, nos vamos a la web principal
                    $this->redirect("ad", "read", array("uuid" => $_POST['uuidAd']));
                }
            }
        }
    }

}
