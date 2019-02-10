<?php

require_once "core/AbstractModel.php";
require_once "model/dao/UserDao.php";

use core\AbstractModel;

/**
 * Clase especialización del modelo de usuario
 */
class UserModel extends AbstractModel {

    private $userDao;

    /**
     * Constructor por defecto
     */
    public function __construct() {
        $this->userDao = new UserDao();
        parent::__construct($this->userDao);
    }

    /**
     * Método que verificará usuario
     * 
     * @param type $usuario usuario a verificar
     * @param type $password contraseña a verificar
     * @return mixed se devuelve al usuario si coinciden las credenciales, NULL en caso contrario
     */
    public function verify($usuario, $password) {
        $user = $this->userDao->searchUser($usuario);
        if (isset($user->login) && password_verify($password, $user->password) === TRUE) {
            return $user;
        } else {
            return NULL;
        }
    }

    /**
     * Método que bloquea un usuario
     * 
     * @param String $uuid uuid del usuario a bloquear
     * @return número de líneas actualizadas en la base de datos
     */
    public function block($uuid) {
        return $this->userDao->block($uuid);
    }

    /**
     * Método que devuelve todos los datos de los usuarios paginando según el parámetro recibido
     * 
     * @param $pag número de pagina a devolver
     * @return array listado de usuarios paginado
     */
    public function getAllPaginated($pag = 0) {
        return $this->userDao->getAllPaginated($pag);
    }

    /**
     * Método que contará el número de usuarios totales en la base de datos
     * 
     * @return número de líneas actualizadas en la base de datos
     */
    public function countUsers() {
        return $this->userDao->countUsers();
    }

    /**
     * Método que devuelve los registros de usuarios y la fecha agrupados por mes y año
     * @return array con los registros
     */
    public function countRegistrations() {
        return $this->userDao->countRegistrations();
    }

    /**
     * Método que desbloquea un usuario del sistema
     * 
     * @param String $uuid uuid del usuario a desbloquear
     * @return número de líneas actualizadas en la base de datos
     */
    public function unlock($uuid) {
        return $this->userDao->unlock($uuid);
    }

}
