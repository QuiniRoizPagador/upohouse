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

    public function redirect($controlador = CONTROLADOR_DEFECTO, $accion = ACCION_DEFECTO) {
        header("Location:index.php?controller=" . $controlador . "&action=" . $accion);
    }

    protected function filtrarStrings($values) {
        foreach ($values as $v) {
            if (!filter_has_var(INPUT_POST, $v) || trim($_POST[$v]) == "") {
                $errors[$v] = "";
            }
        }
        if (isset($errors)) {
            return $errors;
        } else {
            return null;
        }
    }

    protected function sanearStrings($values) {
        foreach ($values as $v) {
            $filtro[$v] = FILTER_SANITIZE_STRING;
        }
        return filter_input_array(INPUT_POST, $filtro);
    }

    protected function verifySession() {
        if (!filter_has_var(INPUT_SESSION, "name")) {
            $this->redirect();
        }
    }

}
