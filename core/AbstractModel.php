<?php

namespace core;

abstract class AbstractModel {

    private $dao;

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
        return $this->dao . read($id);
    }

    public function search($key, $value) {
        return $this->dao . search($key, $value);
    }

    public function create($obj) {
        return $this->dao->create($obj);
    }

    public function update($obj) {
        return $this->dao->update($obj);
    }

}
