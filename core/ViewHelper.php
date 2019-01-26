<?php

namespace core;

/**
 * Clase encargada de las url del sistema, devolverá un string con la url y los parámetros que se le pasen
 */
class ViewHelper {

    public function url($controlador = CONTROLADOR_DEFECTO, $accion = ACCION_DEFECTO, $params = array()) {
        $urlString = "index/" . $controlador . "/" . $accion;
        foreach ($params as $key => $value) {
            $urlString .= "&$key=$value";
        }
        return $urlString;
    }

}
