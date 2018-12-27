<?php

require_once "core/AbstractModel.php";
require_once "model/dao/ReportDao.php";

use core\AbstractModel;

class ReportModel extends AbstractModel {

    private $reportDao;

    public function __construct() {
        $this->reportDao = new ReportDao();
        parent::__construct($this->reportDao);
    }

    public function reportUser($report) {
        $id = $this->reportDao->read($report->getUser_reported(), FALSE);
        
        $report->setUser_reported($id);
        
        return $this->create($report);
    }

}
