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

    public function countComments() {
        return $this->commentDao->countComments();
    }

    public function countRegistrationComments() {
        return $this->commentDao->countRegistrationComments();
    }

    public function getAllPaginated($pag = 0) {
        return $this->commentDao->getAllPaginated($pag);
    }

    public function countUserComments($id) {
        return $this->commentDao->countUserComments($id);
    }

    public function block($uuid) {
        return $this->commentDao->block($uuid);
    }

    public function getComments($id) {
        return $this->commentDao->getComments($id);
    }

}
