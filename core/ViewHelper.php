<?php

namespace core;

class ViewHelper {

    public function url($controlador = CONTROLADOR_DEFECTO, $accion = ACCION_DEFECTO, $params = array()) {
        $urlString = "index/" . $controlador . "/" . $accion;
        foreach ($params as $key => $value) {
            $urlString .= "&$key=$value";
        }
        return $urlString;
    }

}
