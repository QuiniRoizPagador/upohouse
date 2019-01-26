<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/Score.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\Score;

class ScoreController extends AbstractController {

    private $scoreModel;
    private $adModel;

    public function __construct() {
        parent::__construct();
        $this->scoreModel = new ScoreModel();
        $this->adModel = new AdModel();
    }

    public function score() {
        $values = array("ad_uuid" => "text", "score" => "number");
        $erros = RegularUtils::filtrarPorTipo($values, "score");
        if (!isset($errors['score'])) {
            $filtrado = RegularUtils::sanearStrings(array("ad_uuid"));
            $ad = $this->adModel->read($filtrado['ad_uuid']);
            if ($ad) {
                $filtrado = RegularUtils::sanearIntegers(array("score"));
                $score = new Score();
                $score->setAd_id($ad->id);
                $score->setUser_id($_SESSION['id']);
                $score->setScore($filtrado['score']);
                $isScored = $this->scoreModel->isUserScored($_SESSION['id'], $ad->id);
                if ($isScored) {
                    $prev = $this->scoreModel->getUserScore($_SESSION['id'], $ad->id);
                    $score->setUuid($prev->uuid);
                    $this->scoreModel->update($score);
                } else {
                    $score->setUuid(RegularUtils::uuid());
                    $this->scoreModel->create($score);
                }
            }
        }
        $this->redirect("ad", "read", array("uuid" => $_POST['ad_uuid']));
    }

}
