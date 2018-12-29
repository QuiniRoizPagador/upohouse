<?php

function cargarControlador($controller) {
    $controlador = ucwords($controller) . 'Controller';
    $strFileController = 'controller/' . $controlador . '.php';

    if (!is_file($strFileController) || !file_exists($strFileController)) {
        $controlador = ucwords(CONTROLADOR_DEFECTO) . 'Controller';
        $strFileController = 'controller/' . ucwords(CONTROLADOR_DEFECTO) . 'Controller.php';
    }

    require_once $strFileController;
    $controllerObj = new $controlador();
    return $controllerObj;
}

function cargarAccion($controllerObj, $action) {
    $accion = $action;
    $controllerObj->$accion();
}

function lanzarAccion($controllerObj) {
    if (isset($_GET["action"]) && method_exists($controllerObj, $_GET["action"]) && secureSession()) {
        cargarAccion($controllerObj, $_GET["action"]);
    } else {
        $_GET["action"] = ACCION_DEFECTO;
        $_GET["controller"] = CONTROLADOR_DEFECTO;
        cargarAccion(cargarControlador($_GET["controller"]), $_GET["action"]);
    }
}

?>