<?php

namespace core;

class AbstractController {

    public function __construct() {
        foreach (glob("model/*.php") as $file) {
            require_once $file;
        }
    }

    public function view($vista, $datos) {
        foreach ($datos as $id_assoc => $valor) {
            ${$id_assoc} = $valor;
        }

        require_once 'core/ViewHelper.php';
        $helper = new ViewHelper();

        require_once 'view/' . $vista . 'View.php';
    }

    public function redirect($controlador = CONTROLADOR_DEFECTO, $accion = ACCION_DEFECTO, $params = array()) {
        $urlString = "index/" . $controlador . "/" . $accion;
        foreach ($params as $key => $value) {
            $urlString .= "&$key=$value";
        }
        header("Location:$urlString");
    }

}
