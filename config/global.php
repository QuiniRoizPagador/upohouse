<?php

// constante que tomará los valores de los actions que necesitan ser verificados 
const ACTIONS = array(
    "USER" => array("create", "update", "remove"),
    "GUEST" => array("index", "login", "register"),
    "ADMIN" => array('create', 'remove'),
);
// controlador por defecto
define("CONTROLADOR_DEFECTO", "User");
// action por defecto
define("ACCION_DEFECTO", "index");
