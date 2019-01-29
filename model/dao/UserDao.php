<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

/**
 * Clase que especializa el acceso a la base de datos de un usuario
 */
class UserDao extends AbstractDao {

    /**
     * Constructor por defecto
     */
    public function __construct() {
        parent::__construct("Users");
    }

    /**
     * Método que devolverá la búsqueda de un usuario en la base de datos en base al login recibido por parámetros.
     * 
     * @param String $login login del usuario
     * @return model\dao\dto\User encontrado en la base de datos
     */
    public function searchUser($login) {
        $query = "SELECT 
            u.id, 
            u.uuid, 
            u.name, 
            u.surname, 
            u.email, 
            u.password, 
            u.uuid, 
            u.login, 
            u.user_role, 
            s.state 
        FROM 
            Users as u 
        JOIN State_Types as s 
        ON 
            u.state = s.id 
        WHERE 
            (LOWER(u.login) = LOWER(?) 
        OR 
            LOWER(u.email) = LOWER(?)) 
        AND 
            u.state != ?";
        $data = array("ssi", "u.login" => $login, "u.email" => $login,
            "u.state" => STATES['ELIMINADO']);
        return $this->preparedStatement($query, $data)[0];
    }

    /**
     * Método para la creación de un usuario en la base de datos
     * 
     * @param model\dao\dto\User $obj usuario a crear
     * @return string número de filas actualizadas en la base de datos o error
     */
    public function create($obj) {
        $query = "SELECT count(*) as count FROM $this->table WHERE login = ? OR email = ?";
        $data = array("ss", "login" => $obj->getLogin(), "email" => $obj->getEmail());
        $count = parent::preparedStatement($query, $data)[0]->count;
        if ($count > 0) {
            return "duplicate_user";
        } else {
            $query = "INSERT INTO $this->table (`uuid`, `name`, `surname`,`email`, `password`, `login`, `user_role`, `phone`)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            $data = array("ssssssis", "uuid" => $obj->getUuid(), "name" => $obj->getName(), "surname" => $obj->getSurname(),
                "email" => $obj->getEmail(), "password" => password_hash($obj->getPassword(), PASSWORD_DEFAULT)
                , "login" => $obj->getLogin(), 'user_role' => $obj->getUserRole(), 'phone' => $obj->getPhone());
            $res = parent::preparedStatement($query, $data, FALSE);
            return $res;
        }
    }

    /**
     * Método que eliminará lógicamente un usuario en el sistema marcando su estado a eliminado
     * en la base de datos.
     * 
     * @param string $id id del usuario a eliminar.
     * @return string número de filas actualizadas
     */
    public function delete($id) {
        $query = "UPDATE $this->table SET state = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES['ELIMINADO'], "uuid" => $id);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    /**
     * Método que actualizará un usuario en la base de datos
     * 
     * @param model\dao\dto\User $obj usuario a actualizar
     * @return string número de filas actualizadas
     */
    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid(), 1);
        if (trim($obj->getName()) == '') {
            $obj->setName($prev->name);
        }
        if (trim($obj->getSurname()) == '') {
            $obj->setSurname($prev->surname);
        }
        if (trim($obj->getPhone()) == '') {
            $obj->setPhone($prev->phone);
        }
        if (trim($obj->getPassword()) == '') {
            $obj->setPassword($prev->password);
        } else {
            $obj->setPassword(password_hash($obj->getPassword(), PASSWORD_DEFAULT));
        }
        if (trim($obj->getUserRole()) == '') {
            $obj->setUserRole($prev->user_role);
        }
        $query = "UPDATE $this->table SET name = ?, surname = ?, password = ?, "
                . "user_role = ?, phone = ? WHERE uuid = ?";
        $data = array("sssiss", "name" => $obj->getName(), "surname" => $obj->getSurname(),
            "password" => $obj->getPassword(), "user_role" => $obj->getUserRole(),
            "phone" => $obj->getPhone(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function block($uuid) {
        $query = "UPDATE $this->table SET `state` = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES["BLOQUEADO"], "uuid" => $uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function getAllPaginated($pag = 0) {
        $query = $this->mysqli->query("SELECT * FROM $this->table "
                . "WHERE state != " . STATES['ELIMINADO'] . " "
                . "ORDER BY id ASC LIMIT 10 OFFSET " . $pag * 10);
        //Devolvemos el resultset en forma de array de objetos

        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);
        return $resultSet;
    }

    public function countRegistrations() {
        $query = $this->mysqli->query("select COUNT(*) as count, MONTH(`timestamp`) as month,"
                . "YEAR(`timestamp`) as year from $this->table "
                . "GROUP BY MONTH(`timestamp`),YEAR(`timestamp`) "
                . "ORDER BY year(`timestamp`) DESC");

        $resultSet = array();
        while ($row = $query->fetch_object()) {
            $resultSet[] = $row;
        }
        mysqli_free_result($query);
        return $resultSet;
    }

    public function countUsers() {
        $query = $this->mysqli->query("SELECT count(*) as count FROM $this->table WHERE state != " . STATES['ELIMINADO'] . " ORDER BY id DESC LIMIT 1");
        $row = $query->fetch_object();
        mysqli_free_result($query);
        return $row->count;
    }

    public function unlock($uuid) {
        $query = "UPDATE $this->table SET `state` = ? WHERE uuid = ?";
        $data = array("is", "state" => STATES["NEUTRO"], "uuid" => $uuid);
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

}
