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

    public function search($key, $value) {
        return $this->dao->search($key, $value);
    }

    public function create($obj) {
        return $this->dao->create($obj);
    }

    public function update($obj) {
        return $this->dao->update($obj);
    }

    public function filtrarStrings(&$values) {
        foreach ($values as $v) {
            if (!filter_has_var(INPUT_POST, $v) || trim($_POST[$v]) == "") {
                $errors[$v] = "";
            }
        }
        if (isset($errors)) {
            return $errors;
        } else {
            return null;
        }
    }

    public function filtrarInt(&$values) {
        foreach ($values as $v) {
            if (!filter_has_var(INPUT_POST, $v)) {
                $errors[$v] = "";
            }
        }
        if (isset($errors)) {
            return $errors;
        } else {
            return null;
        }
    }

    public function sanearStrings($values) {
        foreach ($values as $v) {
            $filtro[$v] = FILTER_SANITIZE_STRING;
        }
        return filter_input_array(INPUT_POST, $filtro);
    }

    public function sanearIntegers($values) {
        foreach ($values as $v) {
            $filtro[$v] = FILTER_SANITIZE_NUMBER_INT;
        }
        return filter_input_array(INPUT_POST, $filtro);
    }

    public function sanearFloats($values) {
        foreach ($values as $v) {
            $filtro[$v] = FILTER_SANITIZE_NUMBER_FLOAT;
        }
        return filter_input_array(INPUT_POST, $filtro);
    }

    public function isPhone($phone) {
        return preg_match("/^\d{9}$/", $phone);
    }
    
    public function isMobile($mobile) {
        return preg_match("/^\6\d{8}$/", $mobile);
    }
    public function containsString($what, $in){
        return preg_match("/$what/", $in);
    }

}
