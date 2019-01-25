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

    public function listUserRequest($user, $pag = 0) {
        return $this->requestDao->listUserRequest($user, $pag);
    }

    public function countUserRequests($id) {
        return $this->requestDao->countUserRequests($id);
    }

    public function accept($req_uuid) {
        return $this->requestDao->accept($req_uuid);
    }

    public function refuseAll($ad_id, $req_id) {
        return $this->requestDao->refuseAll($ad_id, $req_id);
    }

    public function refuse($req_uuid) {
        return $this->requestDao->refuseRequest($req_uuid);
    }

    public function verifyExist($userId, $adId) {
        return $this->requestDao->verifyExist($userId, $adId);
    }

}
