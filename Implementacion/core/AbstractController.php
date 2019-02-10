<?php

namespace core;

/**
 * Método que sigue el patrón abstracto y cuyas implementaciones o especializaciones
 * del mismo heredarán los métodos encargados de llamar a las vistas, cargarles datos
 * y redirigir correctamente.
 */
class AbstractController {

    /**
     * Constructor del controlador
     */
    public function __construct() {
        foreach (glob("model/*.php") as $file) {
            require_once $file;
        }
    }

    /**
     * Método que cargará la vista.
     * 
     * @param string $vista Vista a cargar
     * @param array $datos datos a asociarle
     */
    public function view($vista, $datos) {
        foreach ($datos as $id_assoc => $valor) {
            ${$id_assoc} = $valor;
        }

        require_once 'core/ViewHelper.php';
        $helper = new ViewHelper();

        require_once 'view/' . $vista . 'View.php';
    }

    /**
     * Método que se encargará de las redirecciones desde los métodos de los
     * controladores.
     * 
     * @param string $controlador al que acceder
     * @param string $accion método del controlador
     * @param array $params parámetros get a añadir
     */
    public function redirect($controlador = CONTROLADOR_DEFECTO, $accion = ACCION_DEFECTO, $params = array()) {
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $urlString = "index/" . $controlador . "/" . $accion;
        foreach ($params as $key => $value) {
            $urlString .= "&$key=$value";
        }
        header("Location://$host$uri/$urlString");
    }

}
