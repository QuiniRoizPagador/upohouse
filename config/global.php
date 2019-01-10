<?php

// constante que tomará los valores de los actions que necesitan ser verificados 
const ACTIONS = array(
    "USER" => array("remove", "readUser", "reportUser", "updateProfile"),
    "GUEST" => array("index", "login", "register"),
    "ADMIN" => array('createUser', 'remove', "dashboard", "updateUser", "blockUser", "removeUser", "paginateUsers",
        "paginateComments","createHousingTypes","updateHousingTypes","paginateHousingTypes","removeHousingTypes",
        "updateOperationTypes","removeOperationType","createOperationTypes","paginateOperationTypes"),
);
// controlador por defecto
define("CONTROLADOR_DEFECTO", "user");
// action por defecto
define("ACCION_DEFECTO", "index");

// ficheros
define("MAX_UPLOAD", 150000);
const IMAGE_FORMAT = array('image/gif', 'image/jpeg', 'image/png', 'image/jpg');
define("IMAGE_AD_URI", "view/images/ads");
// estados
const STATES = array(
    "NEUTRO" => 1,
    "BLOQUEADO" => 2,
    "ELIMINADO" => 3,
    "ACEPTADO" => 4,
    "DESCARTADO" => 5,
);

const ROLES = array(
    "ADMIN" => 1,
    "USER" => 0,
    1 => "ADMIN",
    0 => "USER",
);
