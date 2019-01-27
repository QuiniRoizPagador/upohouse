<?php

/**
 * Este archivo php contiene los valores globales con los que trabajará la aplicación.
 */
// constante que tomará los valores de los actions que necesitan ser verificados 
const ACTIONS = array(
    "USER" => array("remove", "readUser", "reportUser", "updateProfile", "paginateRequests",
        "createRequest", "refuse", "accept", "createReport", "createComment", "createView", "create" ,"modifyView", "modify"),
    "GUEST" => array("index", "login", "register"),
    "ADMIN" => array('createUser', "dashboard", "updateUser", "blockUser", "removeUser", "paginateUsers",
        "paginateComments", "createHousingTypes", "updateHousingTypes", "paginateHousingTypes", "removeHousingTypes",
        "updateOperationTypes", "removeOperationType", "createOperationTypes", "paginateOperationTypes", "acceptReportComment",
        "denyReportComment", "acceptReportRequest", "denyReportRequest", "acceptReportAd", "denyReportAd", "paginateReportsUser",
        "paginateReportsAd", "paginateReportsComment", "paginateReportsRequest")
);
// controlador por defecto
define("CONTROLADOR_DEFECTO", "user");
// action por defecto
define("ACCION_DEFECTO", "index");

// máximo tamaño de ficheros permitido
define("MAX_UPLOAD", 150000);
// formatos de imagen permitidos
const IMAGE_FORMAT = array('image/gif', 'image/jpeg', 'image/png', 'image/jpg');
// ruta para almacenar imágenes
define("IMAGE_AD_URI", "view/images/anuncios");
//Parámetros de correo.
define("MAIL_USER", "upohouse@gmail.com");
define("MAIL_PASSWORD", "3vBCk=hgtTVpEQ4Wuvc#gWruLwXYxsEz_!88cMRRvU3vUDj#EK4jK$5Q+py8Vt?*WG79rnPQpfZ8e**hDMh?GpAt6fRyUkn*agTH");
define("MAIL_FROM", "no-reply@upohouse.com");
// estados
const STATES = array(
    "NEUTRO" => 1,
    "BLOQUEADO" => 2,
    "ELIMINADO" => 3,
    "ACEPTADO" => 4,
    "DESCARTADO" => 5,
);
// roles
const ROLES = array(
    "ADMIN" => 1,
    "USER" => 0,
    1 => "ADMIN",
    0 => "USER",
);
// tipos de denuncia
const REPORTS = array(
    'USER' => 0,
    'COMMENT' => 1,
    'REQUEST' => 2,
    'AD' => 3
);
// lenguajes
global $lang;

// páginas que necesitan footer absoluto
const FOOTER_ABSOLUTE = array(
);
// tipos de likes
const LIKES = array(
    'LIKE' => 1,
    'DISLIKE' => 0
);
