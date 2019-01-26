<?php

namespace core;

/**
 * Clase abstracta que aplica el patrón abstracto y encargada del modelo del sistema.
 * Se presenta un crud básico y una referencia a una clase DAO para acceso a bases de datos.
 */
abstract class AbstractModel {

    protected $dao;

    public function __construct($dao) {
        $this->dao = $dao;
    }

    /**
     * Método que llamará al dao y devolverá el listado de todos los objetos del tipo
     * con el que se esté trabajando existentes en la base de datos.
     * 
     * @return type array con los objetos
     */
    public function getAll() {
        return $this->dao->getAll();
    }

    /**
     *  Método que llamará al dao y enviará la orden de elimminación en la base de datos del sistema
     * del objeto con el que se esté trabajando.
     * 
     * @param String $id uuid o id del objeto a eliminar.
     * @return Se devuelve el número de filas afectadas en la base de datos.
     */
    public function delete($id) {
        return $this->dao->delete($id);
    }

    /**
     * Método que llamará al dao y buscará en la base de datos un objeto del tipo con el que se esté
     * trabajando y cuyo id o uuid coincida con el recibido por parámetros.
     * @param String $id uuid o id para localizar el objeto en cuestión.
     * @return \stdClass con el objeto encontrado
     */
    public function read($id) {
        return $this->dao->read($id);
    }

    /**
     * Método que llamará al dao y buscará en la base de datos un objeto del tipo con el que se esté
     * trabajando en función de una clave y un valor, limitando en caso de que sea necesario
     * el número de filas devueltas.
     * 
     * @param string $key clave a buscar (columna)
     * @param string $value valor a buscar en la columna
     * @param integer $limit número máximo de filas a devolver, en caso necesario.
     * @return \stdClass con el objeto encontrado
     */
    public function search($key, $value, $limit = FALSE) {
        return $this->dao->search($key, $value, $limit);
    }

    /**
     * Método que llamará al dao y creará en la base de datos una nueva instancia 
     * del objeto con el que se esté trabajando.
     * 
     * @param \stdClass $obj objeto a crear
     * @return número de filas afectadas en la base de datos.
     */
    public function create($obj) {
        return $this->dao->create($obj);
    }

    /**
     * Método que llamará al dao y actualizará los datos del objeto con el que se esté 
     * trabajando en la base de datos.
     * @param \stdClass $obj objeto a actualizar.
     * @return número de filas afectadas en la base de datos.
     */
    public function update($obj) {
        return $this->dao->update($obj);
    }

}
