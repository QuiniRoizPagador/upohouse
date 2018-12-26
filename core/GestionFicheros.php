<?php

function moverImagen($nombre) {
    $fich = $_FILES[$nombre];
    if ($fich['error'] > 0) {
        return null;
    }
    if ($fich['size'] <= MAX_UPLOAD && array_search($fich['type'], IMAGE_FORMAT) !== FALSE) {
        $ruta = "images/" . time() . $fich['name'];
        if (!file_exists("images")) {
            mkdir("images");
        }
        move_uploaded_file($fich['tmp_name'], $ruta);
        return $ruta;
    } else {
        throw new UnexpectedValueException("Error en el formato de entrada.");
    }
}

function eliminarImagen($nombre) {
    if (file_exists($nombre)) {
        unlink($nombre);
    }
}
