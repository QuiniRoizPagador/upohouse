<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/Report.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\Report;

class ReportController extends AbstractController {

    private $reportModel;

    public function __construct() {
        parent::__construct();
        $this->reportModel = new ReportModel();
    }

    public function reportUser() {
        $data = array("uuid", "content", "title");
        $errors = RegularUtils::filtrarVariable($data);
        if (!isset($errors)) {
            $saneado = RegularUtils::sanearStrings(array('uuid'));
            $uuid = $saneado["uuid"];
            $content = $saneado['content'];
            $title = $saneado["title"];
            
            $report = new Report();
            $report->setComment_reported($content);
            $report->setTitle($title);
            $report->setUser_id($_SESSION['id']);
            $report->setUser_reported($uuid);
            $report->setUuid(RegularUtils::uuid());
            
            
            $lineas = $this->reportModel->reportUser($report);
            if ($lineas == 0) {
                die("Error.");
            }
            $this->redirect("User", "index");
        } else {
            $this->redirect("User", "readUser");
        }
    }

}
