<?php

namespace core;

abstract class AbstractModel {

    protected $dao;

    public function __construct($dao) {
        $this->dao = $dao;
    }

    public function getAll($close = TRUE) {
        return $this->dao->getAll($close);
    }

    public function delete($id, $close = TRUE) {
        return $this->dao->delete($id, $close);
    }

    public function read($id, $close = TRUE) {
        return $this->dao->read($id, $close);
    }

    public function search($key, $value, $close = TRUE, $limit = FALSE) {
        return $this->dao->search($key, $value, $close, $limit);
    }

    public function create($obj, $close = TRUE) {
        return $this->dao->create($obj, $close);
    }

    public function update($obj, $close = TRUE) {
        return $this->dao->update($obj, $close);
    }

}
