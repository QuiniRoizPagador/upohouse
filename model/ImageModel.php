<?php

require_once "core/AbstractModel.php";
require_once "model/dao/ImageDao.php";

use core\AbstractModel;

class ImageModel extends AbstractModel {

    private $imageDao;

    public function __construct() {
        $this->imageDao = new ImageDao();
        parent::__construct($this->imageDao);
    }

}