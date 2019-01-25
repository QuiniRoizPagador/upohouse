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
  
    public function modifyState($uuid,$state)
    {
        return $this->reportDao->modifyState($uuid,$state);
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

    public function isReportedUser($me, $otherUser) {
        return $this->reportDao->isReportedUser($me,$otherUser);
    }

}
