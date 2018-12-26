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

}
