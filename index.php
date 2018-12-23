<?php

//Configuración global
require_once 'config/global.php';

//Base para los controladores
require_once 'core/AbstractController.php';

// Funciones de seguridad
require_once 'core/Security.func.php';

//Funciones para el controlador frontal
require_once 'core/FrontController.func.php';

//Cargamos controladores y acciones
if (isset($_GET["controller"])) {
    $controllerObj = cargarControlador($_GET["controller"]);
    lanzarAccion($controllerObj);
} else {
    // si no se carga controlador verificar si se redirige dentro o fuera
    $controllerObj = cargarControlador(CONTROLADOR_DEFECTO);
    lanzarAccion($controllerObj);
}
?>