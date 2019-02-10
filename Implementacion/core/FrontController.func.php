<?php

/**
 * Función que se encargará de verificar la existencia del controlador y cargarlo 
 * para tratarlo posteriormente. En caso de no existir, se elige el controlador por defecto.
 * 
 * @param string $controller controlador al que se desea acceder.
 * @return \controlador objeto de controlador verificado.
 */
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

/**
 * Función que cargará el controlador y la acción escogidos.
 * 
 * @param \controlador $controllerObj controlador al que se desea acceder
 * @param \metodo $action método que se quiere ejecutar dentro del controlador
 */
function cargarAccion($controllerObj, $action) {
    $accion = $action;
    $controllerObj->$accion();
}

/**
 * Función que lanzará la acción en el controlador que recibe por parámetros.
 * Esta función llamará a la sección de seguridad de acceso del sistema para 
 * proteger del acceso inadecuado.
 * 
 * @param type $controllerObj controlador al que se desea acceder.
 */
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