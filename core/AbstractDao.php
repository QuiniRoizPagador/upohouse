<?php

namespace core;

require_once 'Conect.php';

abstract class AbstractDao {

    protected $table;
    protected $mysqli;
    protected $db;
    protected $stmt;

    public function __construct($table) {
        $this->table = (string) $table;
        $this->db = Conect::getInstance();
        $this->mysqli = $this->db->getConnection();
    }

    public function getAll($close = True) {
        $query = $this->mysqli->query("SELECT * FROM $this->table ORDER BY id DESC;");

        //Devolvemos el resultset en forma de array de objetos
        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }

        mysqli_free_result($query);
        if ($close) {
            mysqli_close($this->mysqli);
        }
        return $resultSet;
    }

    public function read($id, $close = True) {
        $query = "SELECT * FROM $this->table WHERE id = ? LIMIT 1";
        $data = array('i', "id" => $id);

        $resultSet = $this->preparedStatement($query, $data);
        $res = mysqli_fetch_assoc($resultSet);
        mysqli_free_result($resultSet);
        if ($close) {
            $this->closeConnection();
        }
        return $res;
    }

    public function search($column, $value, $close = True) {
        $query = "SELECT * FROM $this->table WHERE $column = ?";
        $data = array("s", $column => $value);
        $resultSet = $this->preparedStatement($query, $data);
        $datos = mysqli_fetch_assoc($resultSet);
        mysqli_free_result($resultSet);
        if ($close) {
            $this->closeConnection();
        }
        return $datos;
    }

    public function delete($id, $close = True) {
        $query = "DELETE FROM $this->table WHERE id = ? LIMIT 1";
        $data = array('i', "id" => $id);
        $res = $this::preparedStatement($query, $data, FALSE);
        if ($close) {
            $this->closeConnection();
        }
        return $res;
    }

    public abstract function update($obj);

    public abstract function create($obj);

    public function preparedStatement($sql, $data, $get = TRUE) {
        if (isset($data)) {
            $bind = $this->bindData($data);
            $this->stmt = mysqli_stmt_init($this->mysqli) or die();
            mysqli_stmt_prepare($this->stmt, $sql);
            call_user_func_array(array($this->stmt, 'bind_param'), $bind);
            $filas = mysqli_stmt_execute($this->stmt);
            if ($get) {
                $resultado = mysqli_stmt_get_result($this->stmt);
            }
        } else {
            $resultado = mysqli_query($this->mysqli, $sql);
        }
        if (mysqli_error($this->mysqli)) {
            die('Error en la conexión sql.' . mysqli_error($this->mysqli));
        }
        if ($get) {
            return $resultado;
        } else {
            return $filas;
        }
    }

    public function bindData(&$values) {
        $bind = array();
        foreach ($values as $key => $value) {
            $bind[$key] = &$values[$key];
        }
        return $bind;
    }

    public function closeConnection() {
        if (isset($this->stmt)) {
            mysqli_stmt_close($this->stmt);
        }
        mysqli_close($this->mysqli);
    }

}
