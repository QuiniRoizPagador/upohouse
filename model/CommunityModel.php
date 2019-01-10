<?php

require_once "core/AbstractModel.php";
require_once "model/dao/CommunityDao.php";

use core\AbstractModel;

class CommunityModel extends AbstractModel {

    private $communityDao;

    public function __construct() {
        $this->communityDao = new CommunityDao();
        parent::__construct($this->communityDao);
    }
    
    public function readId($id) {
        return $this->communityDao->readId($id);
    }

}
