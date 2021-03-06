<?php

namespace core;

require_once 'Conect.php';

/**
 * Clase encargada del acceso a la base de datos, 
 * siguiendo el patrón abstracto será la que extenderán las especializaciones
 * e implementaciones propias de cada objeto con el que se trabaje.
 */
abstract class AbstractDao {

    protected $table;
    protected $mysqli;
    protected $db;

    /**
     * Constructor de la clase
     * 
     * @param String $table tabla del objeto con el que se esté trabajando.
     */
    public function __construct($table) {
        $this->table = (string) $table;
        $this->db = Conect::getInstance();
        $this->mysqli = $this->db->getConnection();
    }

    /**
     * Método encargado de acceder a la base de datos y listar todos los objetos 
     * del tipo con el que se está trabajando.
     * 
     * @return array con el resultado del listado obtenido.
     */
    public function getAll() {
        $query = $this->mysqli->query("SELECT * FROM $this->table ORDER BY id DESC;");

        //Devolvemos el resultset en forma de array de objetos
        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);
        return $resultSet;
    }

    /**
     * Método encargado de acceder a la base de datos y buscar un objeto cuyo id
     * o uuid coincida con el recibido por parámetros.
     * 
     * @param string $id uuid o id a buscar.
     * @return \stdClass objeto encontrado.
     */
    public function read($id) {
        if (is_numeric($id)) {
            $query = "SELECT * FROM $this->table WHERE id = ? LIMIT 1";
            $data = array('i', "id" => $id);
        } else {
            $query = "SELECT * FROM $this->table WHERE uuid = ?  LIMIT 1";
            $data = array('s', "uuid" => $id);
        }
        return $this->preparedStatement($query, $data)[0];
    }

    /**
     * Método que buscará en la base de datos por columna y valor de la misma,
     * permitiendo limitar el número de resultados máximo.
     * 
     * @param String $column columna a buscar
     * @param String $value valor de la columna a buscar
     * @param integer $limit número máximo de valores a devolver
     * @return resultado de la búsqueda
     */
    public function search($column, $value, $limit = FALSE) {
        $query = "SELECT * FROM $this->table WHERE $column = ? ";
        if ($limit !== FALSE) {
            $query .= "LIMIT $limit";
        }
        $data = array("s", $column => $value);
        $resultSet = $this->preparedStatement($query, $data);
        if ($limit !== FALSE || $limit === 1) {
            $resultSet = $resultSet[0];
        } 
        return $resultSet;
    }

    /**
     * Método encargado de eliminar un objeto del tipo con el que se esté trabajando
     * en la base de datos cuyo id o uuid coincida con el recibido por parámetros.
     * 
     * @param string $id uuid o id del objeto a buscar y eliminar.
     * @return número de filas afectadas en la base de datos.
     */
    public function delete($id) {
        if (is_numeric($id)) {
            $query = "DELETE FROM $this->table WHERE id = ?";
            $data = array('i', "id" => $id);
        } else {
            $query = "DELETE FROM $this->table WHERE uuid = ?";
            $data = array('s', "uuid" => $id);
        }
        $res = $this::preparedStatement($query, $data, FALSE);
        return $res;
    }

    /**
     * Método abstracto que implementarán las hijas de esta clase. Se encargará
     * de actualizar el objeto en cuestión en la base de datos.
     */
    public abstract function update($obj);

    /**
     * Método abstracto que implementarán las hijas de esta clase. Se encargará 
     * de crear un objeto del tipo en cuestión en la base de datos.
     */
    public abstract function create($obj);

    /**
     * Preparación de sentencia para evitar SQL inyection y verificar 
     * que las querys son correctas.
     * 
     * @param string $sql query a ejecutar
     * @param string $data datos a enlazar a la query
     * @param bool $get si queremos datos de vuelta
     * @return mixed filas o listado de rows a devolver e iterar.
     */
    public function preparedStatement($sql, $data, $get = TRUE) {
        if (isset($data)) {
            $bind = $this->bindData($data);
            $stmt = mysqli_stmt_init($this->mysqli) or die();
            mysqli_stmt_prepare($stmt, $sql);
            call_user_func_array(array($stmt, 'bind_param'), $bind);
            echo $this->mysqli->error;
            $filas = mysqli_stmt_execute($stmt);
            if ($get) {
                $result = mysqli_stmt_result_metadata($stmt);
                $arr_fields = $result->fetch_fields();
                $obj_result = new \stdClass();
                $arr_bind_fields = array();
                foreach ($arr_fields as $obj_field) {
                    $arr_bind_fields[] = &$obj_result->{$obj_field->name};
                }
                call_user_func_array(array($stmt, 'bind_result'), $arr_bind_fields);
                $mix_data = array();
                while ($stmt->fetch()) {
                    // Manual clone method - nasty, but required because of all the binding references
                    // to avoid each row being === the last row in the result set
                    $obj_row = new \stdClass();
                    foreach ($arr_fields as $obj_field) {
                        $obj_row->{$obj_field->name} = $obj_result->{$obj_field->name};
                    }
                    $mix_data[] = $obj_row;
                }
                mysqli_stmt_free_result($stmt);
                return $mix_data;
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

    /**
     * Este método se encarga de modificar los valores a asociaciones de valores
     * para los prepared statements.
     * 
     * @param array $values valores a tocar.
     * @return array con el nuevo bindData.
     */
    public function bindData(&$values) {
        $bind = array();
        foreach ($values as $key => $value) {
            $bind[$key] = &$values[$key];
        }
        return $bind;
    }

}
