<?php

// constante que tomará los valores de los actions que necesitan ser verificados 
const ACTIONS = array(
    "USER" => array("index", "create", "update", "remove"),
    "GUEST" => array("login", "register"),
    "ADMIN" => array('create', 'remove'),
);
// controlador por defecto
define("CONTROLADOR_DEFECTO", "Session");
// action por defecto
define("ACCION_DEFECTO", "login");
