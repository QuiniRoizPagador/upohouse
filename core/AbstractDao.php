<?php

namespace core;

require_once 'Conect.php';

abstract class AbstractDao {

    private $table;
    private $mysqli;
    private $db;
    private $stmt;

    public function __construct($table) {
        $this->table = (string) $table;
        $this->db = Conect::getInstance();
        $this->mysqli = $this->db->getConnection();
    }

    public function getAll() {
        $query = $this->mysqli->query("SELECT * FROM $this->table ORDER BY id DESC;");

        //Devolvemos el resultset en forma de array de objetos
        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_close($this->mysqli);
        return $resultSet;
    }

    public function read($id) {
        $query = "SELECT * FROM $this->table WHERE id = ?";
        $data = array('i', "id" => $id);

        $resultSet = $this->preparedStatement($query, $data);
        $res = mysqli_fetch_assoc($resultSet);
        mysqli_free_result($resultSet);
        $this->closeConnection();
        return $res;
    }

    public function search($column, $value) {
        $query = "SELECT * FROM $this->table WHERE $column = ?";
        $data = array("s", $column => $value);
        $resultSet = $this->preparedStatement($query, $data);
        $datos = mysqli_fetch_assoc($resultSet);
        mysqli_free_result($resultSet);
        $this->closeConnection();
        return $datos;
    }

    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id = ?;";
        $data = array('i', "id" => $id);
        $res = $this::preparedStatement($query, $data, FALSE);
        $this->closeConnection();
        return $res;
    }

    public abstract function update($obj);

    public abstract function create($obj);

    public function preparedStatement($sql, $data, $get = TRUE) {

        if (isset($data)) {
            $bind = $this->bindData($data);
            $stmt = mysqli_stmt_init($this->mysqli);
            $this->stmt = $stmt;
            mysqli_stmt_prepare($stmt, $sql);
            call_user_func_array(array($stmt, 'bind_param'), $bind);
            $filas = mysqli_stmt_execute($stmt);

            if ($get) {
                $resultado = mysqli_stmt_get_result($stmt);
            }
        } else {
            $resultado = mysqli_query($this-->mysqli, $sql);
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
            $this->stmt->close();
        }
        $this->mysqli->close();
    }

}
