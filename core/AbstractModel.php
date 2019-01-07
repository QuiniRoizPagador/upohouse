<?php

namespace core;

abstract class AbstractModel {

    protected $dao;

    public function __construct($dao) {
        $this->dao = $dao;
    }

    public function getAll() {
        return $this->dao->getAll();
    }

    public function delete($id) {
        return $this->dao->delete($id);
    }

    public function read($id) {
        return $this->dao->read($id);
    }

    public function search($key, $value, $limit = FALSE) {
        return $this->dao->search($key, $value, $limit);
    }

    public function create($obj) {
        return $this->dao->create($obj);
    }

    public function update($obj) {
        return $this->dao->update($obj);
    }

}
