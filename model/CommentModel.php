<?php

require_once "core/AbstractModel.php";
require_once "model/dao/CommentDao.php";

use core\AbstractModel;

class CommentModel extends AbstractModel {

    private $commentDao;

    public function __construct() {
        $this->commentDao = new CommentDao();
        parent::__construct($this->commentDao);
    }

}
