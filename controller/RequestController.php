<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/Request.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\Request;

class RequestController extends AbstractController {

    private $requestModel;

    public function __construct() {
        parent::__construct();
        $this->requestModel = new RequestModel();
    }

    public function accept() {
        
    }

    public function refuse() {
        
    }

}
