<?php

// constante que tomará los valores de los actions que necesitan ser verificados dentro de la sesión
const IN_ACTIONS = ["index", "create", "update", "remove"];
// constante que tomará los valores de los actions que necesitan ser verificados fuera de la sesión
const OUT_ACTIONS = ["login", "register"];
// constante que tomará aquellos actions que requieren que el usuario sea administrador
const ADMIN_ACTIONS = ['create', 'remove'];
// controlador por defecto
define("CONTROLADOR_DEFECTO", "Session");
// action por defecto
define("ACCION_DEFECTO", "login");
