<?php

// constante que tomará los valores de los actions que necesitan ser verificados 
const ACTIONS = array(
    "USER" => array("create", "update", "remove", "readUser"),
    "GUEST" => array("index", "login", "register"),
    "ADMIN" => array('create', 'remove', "dashboard"),
);
// controlador por defecto
define("CONTROLADOR_DEFECTO", "User");
// action por defecto
define("ACCION_DEFECTO", "index");

// ficheros
define("MAX_UPLOAD", 150000);
const IMAGE_FORMAT = array('image/gif', 'image/jpeg', 'image/png', 'image/jpg');
// estados
const STATES = array(
    "NEUTRO" => 1,
    "BLOQUEADO" => 2,
    "ELIMINADO" => 3,
    "ACEPTADO" => 4,
    "DESCARTADO" => 5,
);

const ROLES = array(
    "ADMIN" => 0,
    "USER" => 1,
    0 => "ADMIN",
    1 => "USER",
);
