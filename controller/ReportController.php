<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/Report.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\Report;

class ReportController extends AbstractController {

    private $reportModel;
    private $requestModel;
    private $userModel;
    private $commentModel;
    private $adModel;

    public function __construct() {
        parent::__construct();
        $this->reportModel = new ReportModel();
        $this->requestModel = new RequestModel();
        $this->userModel = new UserModel();
        $this->commentModel = new CommentModel();
        $this->adModel = new AdModel();
    }

    public function createReport() {
        $data = array("report" => "number", "uuid" => "text");
        $errors = RegularUtils::filtrarPorTipo($data, "report");
        if (!isset($errors)) {
            $saneado = RegularUtils::sanearStrings(array("uuid"));
            $uuid = $saneado["uuid"];
            $saneado = RegularUtils::sanearIntegers(array("report"));
            $report = $saneado["report"];

            $this->view("createReport", array(
                'title' => "create_report",
                'uuid' => $uuid,
                'report' => $report
            ));
        } else {
            $this->redirect("User", "readUser");
        }
    }

    public function reportRequest() {
        $data = array("title" => "text", "description" => "longText", "uuid" => "text");
        $errors = RegularUtils::filtrarPorTipo($data, "createReport");
        if (!isset($errors)) {
            $saneado = RegularUtils::sanearStrings(array('title', 'uuid', 'description'));
            $uuid = $saneado["uuid"];
            $description = str_replace("\n", "<br />", $saneado['description']);
            $title = $saneado["title"];
            $request = $this->requestModel->read($uuid);
            $report = new Report();
            $report->setRequest_reported($request->id);
            $report->setTitle($title);
            $report->setDescription($description);
            $report->setUser_id($_SESSION['id']);
            $report->setUuid(RegularUtils::uuid());
            $lineas = $this->reportModel->create($report);
            if ($lineas == 0) {
                $this->redirect();
            } else {
                $this->redirect("User", "readUser", array('uuid' => $_SESSION['uuid'], 'report' => "report_ok"));
            }
        } else {
            $this->redirect("User", "readUser", array('uuid' => $_SESSION['uuid'], 'report' => "report_fail"));
        }
    }

    public function reportUser() {
        $data = array("title" => "text", "description" => "longText", "uuid" => "text");
        $errors = RegularUtils::filtrarPorTipo($data, "createReport");
        if (!isset($errors)) {
            $saneado = RegularUtils::sanearStrings(array('title', 'uuid', 'description'));
            $uuid = $saneado["uuid"];
            $description = str_replace("\n", "<br />", $saneado['description']);
            $title = $saneado["title"];
            $user = $this->userModel->read($uuid);
            $report = new Report();
            $report->setUser_reported($user->id);
            $report->setTitle($title);
            $report->setDescription($description);
            $report->setUser_id($_SESSION['id']);
            $report->setUuid(RegularUtils::uuid());
            $lineas = $this->reportModel->create($report);
            if ($lineas == 0) {
                $this->redirect();
            } else {
                $this->redirect("User", "readUser", array('uuid' => $_SESSION['uuid'], 'report' => "report_ok"));
            }
        } else {
            $this->redirect("User", "readUser", array('uuid' => $_SESSION['uuid']));
        }
    }

    public function reportAd() {
        $data = array("title" => "text", "description" => "longText", "uuid" => "text");
        $errors = RegularUtils::filtrarPorTipo($data, "createReport");
        if (!isset($errors)) {
            $saneado = RegularUtils::sanearStrings(array('title', 'uuid', 'description'));
            $uuid = $saneado["uuid"];
            $description = str_replace("\n", "<br />", $saneado['description']);
            $title = $saneado["title"];
            $ad = $this->adModel->read($uuid);
            $report = new Report();
            $report->setAd_reported($ad->id);
            $report->setTitle($title);
            $report->setDescription($description);
            $report->setUser_id($_SESSION['id']);
            $report->setUuid(RegularUtils::uuid());
            $lineas = $this->reportModel->create($report);
            if ($lineas == 0) {
                $this->redirect();
            } else {
                $this->redirect("User", "readUser", array('uuid' => $_SESSION['uuid'], 'report' => "report_ok"));
            }
        } else {
            $this->redirect("User", "readUser", array('uuid' => $_SESSION['uuid']));
        }
    }

    public function reportComment() {
        $data = array("title" => "text", "description" => "longText", "uuid" => "text");
        $errors = RegularUtils::filtrarPorTipo($data, "createReport");
        if (!isset($errors)) {
            $saneado = RegularUtils::sanearStrings(array('title', 'uuid', 'description'));
            $uuid = $saneado["uuid"];
            $description = str_replace("\n", "<br />", $saneado['description']);
            $title = $saneado["title"];
            $comment = $this->commentModel->read($uuid);
            $report = new Report();
            $report->setComment_reported($comment->id);
            $report->setTitle($title);
            $report->setDescription($description);
            $report->setUser_id($_SESSION['id']);
            $report->setUuid(RegularUtils::uuid());
            $lineas = $this->reportModel->create($report);
            if ($lineas == 0) {
                $this->redirect();
            } else {
                $this->redirect("User", "readUser", array('uuid' => $_SESSION['uuid'], 'report' => "report_ok"));
            }
        } else {
            $this->redirect("User", "readUser", array('uuid' => $_SESSION['uuid'], 'report' => "report_ok"));
        }
    }

}
