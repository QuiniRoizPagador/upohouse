<?php

require_once "core/AbstractModel.php";
require_once "model/dao/RequestDao.php";

use core\AbstractModel;

class RequestModel extends AbstractModel {

    private $requestDao;

    public function __construct() {
        $this->requestDao = new RequestDao();
        parent::__construct($this->requestDao);
    }

    public function listUserRequest($user) {
        $request = $this->requestDao->listUserRequest($user);
        $ads = array();
        foreach($request as $r){
            $ads[$r->title][$r->request] = $r;
        }
        return $ads;
    }

}
