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

    public function countComments($close = TRUE) {
        return $this->commentDao->countComments($close);
    }
    public function countRegistrationComments($close = TRUE) {
        return $this->commentDao->countRegistrationComments($close);
    }
    public function getAllPaginated($pag = 0, $close = TRUE) {
        return $this->commentDao->getAllPaginated($pag, $close);
    }


}
