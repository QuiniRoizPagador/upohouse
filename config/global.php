<?php
// constante que tomará los valores de los actions que necesitan ser verificados dentro de la sesión
define("IN_ACTIONS", array("index", "create", "update", "remove"));
// constante que tomará los valores de los actions que necesitan ser verificados fuera de la sesión
define("OUT_ACTIONS", array("login", "register"));
// constante que tomará aquellos actions que requieren que el usuario sea administrador
define("ADMIN_ACTIONS", array('create', 'remove'));
// controlador por defecto
define("CONTROLADOR_DEFECTO", "Session");
// action por defecto
define("ACCION_DEFECTO", "login");
