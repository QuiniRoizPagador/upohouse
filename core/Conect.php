<?php

namespace core;

class Conect {

    static private $instance = NULL;
    private $driver;
    private $host, $user, $pass, $database;
    private $con;

    static public function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $db_cfg = require_once 'config/database.php';
        $this->driver = $db_cfg["driver"];
        $this->host = $db_cfg["host"];
        $this->user = $db_cfg["user"];
        $this->pass = $db_cfg["pass"];
        $this->database = $db_cfg["database"];
        $this->con = mysqli_connect($this->host, $this->user, $this->pass, $this->database);
        if (!$this->con) {
            die('Error en la conexión sql.');
        }
    }

    private function __clone() {
        
    }

    public function getConnection() {
        return $this->con;
    }

}
