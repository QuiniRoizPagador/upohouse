<?php

namespace core;

/**
 * Clase que sigue el patrón Singleton usada para conexión con la base de datos.
 */
class Conect {

    static private $instance = NULL;
    private $driver;
    private $host, $user, $pass, $database;
    private $con;

    /**
     * Método estático que devuelve la instancia de la conexión a la base de datos.
     * @return Conect instancia de sí mismo con la base de datos.
     */
    static public function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor privado para asegurar la única llamada desde la aplicación del patrón
     */
    private function __construct() {
        $db_cfg = require_once 'config/database.php';
        $this->driver = $db_cfg["driver"];
        $this->host = $db_cfg["host"];
        $this->user = $db_cfg["user"];
        $this->pass = $db_cfg["pass"];
        $this->database = $db_cfg["database"];
        $this->con = mysqli_connect($this->host, $this->user, $this->pass, $this->database);
        $this->con->set_charset($db_cfg["charset"]);
        if (!$this->con) {
            die('Error en la conexión sql.');
        }
    }

    private function __clone() {
        
    }

    /**
     * Método que devolverá la conexión a la base de datos existente en la instancia.
     * 
     * @return mysql conexión a la base de datos.
     */
    public function getConnection() {
        return $this->con;
    }

}
