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

    public function countReportUsers() {
        return $this->reportDao->countReportUsers();
    }

    public function getAllReportUserPaginated($pag = 0) {
        return $this->reportDao->getAllReportUserPaginated($pag);
    }

    public function countReportAds() {
        return $this->reportDao->countReportAds();
    }

    public function getAllReportAdPaginated($pag = 0) {
        return $this->reportDao->getAllReportAdPaginated($pag);
    }

    public function countReportComments() {
        return $this->reportDao->countReportComments();
    }

    public function getAllReportCommentPaginated($pag = 0) {
        return $this->reportDao->getAllReportCommentPaginated($pag);
    }

    public function countReportRequests() {
        return $this->reportDao->countReportRequests();
    }

    public function getAllReportRequestPaginated($pag = 0) {
        return $this->reportDao->getAllReportRequestPaginated($pag);
    }

}
