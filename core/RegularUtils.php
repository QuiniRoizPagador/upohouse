<?php

namespace core;

/**
 * Clase estática de utilidad encargada de verificaciones de expresiones regulares, 
 * saneamientos, creaciones de uuid y guardado de imágenes
 */
class RegularUtils {

    /**
     * Método estático que creará un UUID siguiendo el estándar último de UUID.
     * @return String con el uuid generado.
     */
    static public function uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

    /**
     * Método estático que guardará las imágenes recibidas por parámetros, 
     * una versión en tamaño real y otra para imágenes de tipo thumbnail.
     * 
     * @param string $field String con el nombre del campo a buscar en $_FILES
     * @param string $adId id del anuncio al que irá asociado
     * @return array Se devuelve un array con clave-valor de imágenes y su respectiva versión reducida.
     */
    static public function saveAdImages($field, $adId) {
        $images = array();
        $url = IMAGE_AD_URI . "/" . $adId;
        $field = $_FILES[$field];
        mkdir($url);
        if ($field["size"][0] == 0) {
            $imagesAmount = 0;
        } else {
            $imagesAmount = count($field["name"]);
        }
        for ($i = 0; $i < $imagesAmount; $i++) {
            $fileUrl = $url . "/" . $field["name"][$i];
            $fileThumbnailUrl = $url . "/thumbnails_" . $field["name"][$i];
            move_uploaded_file($field["tmp_name"][$i], $fileUrl);
            RegularUtils::resize_image($fileUrl, $fileThumbnailUrl, 200, 200);
            $images[] = array("image" => $fileUrl, "thumbnail" => $fileThumbnailUrl);
        }
        return $images;
    }

    /**
     * Método estático que redimensionará una imagen a partir de una url recibida.
     * 
     * @param type $file URL con la imagen original
     * @param type $destiny URL del destino donde deseamos almacenar la nueva imagen.
     * @param type $w Ancho nuevo.
     * @param type $h Alto nuevo.
     */
    static function resize_image($file, $destiny, $w, $h) {
        copy($file, $destiny);
        list($width, $height) = getimagesize($destiny);
        $r = $width / $height;

        if ($w / $h > $r) {
            $newwidth = $h * $r;
            $newheight = $h;
        } else {
            $newheight = $w / $r;
            $newwidth = $w;
        }
        switch (mime_content_type($destiny)) {
            case "image/png":
                $src = imagecreatefrompng($destiny);
                break;
            case "image/jpg":
            case "image/jpeg":
                $src = imagecreatefromjpeg($destiny);
                break;
        }
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        switch (mime_content_type($destiny)) {
            case "image/png":
                imagepng($dst, $destiny);
                break;
            case "image/jpg":
            case "image/jpeg":
                imagejpeg($dst, $destiny);
                break;
        }
    }

    /**
     * Método estático que iterará en el contenido de una carpeta y eliminará 
     * todas sus imágenes. Posteriormente eliminará la propia carpeta.
     * 
     * @param string $adId id del anuncio que buscar para eliminar.
     */
    static public function removeAdImages($adId) {
        $url = IMAGE_AD_URI . "/" . $adId;
        $files = scandir($url);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                unlink($url . '/' . $file);
            }
        }
        rmdir($url);
    }

    /**
     * Método estático que iterará por cada unas de las variables recibidas y 
     * filtrará su existencia en la variable global $_POST.
     * 
     * @param type $values array con los valores a filtrar.
     * @return Se devuelve un array con los errores en caso de existir o null en caso contrario.
     */
    static public function filtrarVariable(&$values) {
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

    /**
     * Método estático que filtrará un diccionario de valores recibidos por parámetro
     * con su tipo asociado, de forma que se filtre individualmente por tipo cada valor.
     * 
     * @param array $values array asociativo con los valores y sus tipos a filtrar.
     * @param string $name Nombre del error asociado.
     * @return array Se devuelve un array asociativo con los errores en cada campo.
     */
    static public function filtrarPorTipo($values, $name) {
        foreach ($values as $key => $value) {
            if ($value == "image") {
                if (is_uploaded_file($_FILES[$key]["tmp_name"][0])) {
                    $i = 0;
                    $filesAmount = count($_FILES[$key]["tmp_name"]);
                    while ($i < $filesAmount && !isset($errors[$name][$key])) { // Recorre todos los archivos del campo file.
                        $j = 0;
                        $correct = FALSE;
                        $imgTypesAmount = count(IMAGE_FORMAT);
                        while ($j < $imgTypesAmount && !$correct) { //Recorre todos los tipos de imagen.
                            if (IMAGE_FORMAT[$j] == $_FILES[$key]["type"][$i]) {
                                $correct = TRUE;
                            } else {
                                $j++;
                            }
                        }
                        if (!$correct) {
                            $errors[$name][$key] = "formato_incorrecto";
                        } else {
                            $i++;
                        }
                    }
                } else {
                    $errors[$name][$key] = "requerido";
                }
            } else {
                if (filter_has_var(INPUT_POST, $key) && trim($_POST[$key]) !== "") {
                    switch ($value) {
                        case "phone":
                            $error = !RegularUtils::isPhone(trim($_POST[$key]));
                            break;
                        case "email":
                            $error = !RegularUtils::isEmail(trim($_POST[$key]));
                            break;
                        case "number":
                            $error = !RegularUtils::isNumber($_POST[$key]);
                            break;
                        case "text":
                            $error = !RegularUtils::isValidString(trim($_POST[$key]));
                            break;
                        case "longText":
                            $error = !RegularUtils::isValidLongString(trim($_POST[$key]));
                            break;
                        case "float":
                            $error = !RegularUtils::isFloat($_POST[$key]);
                            break;
                        default:
                            $error = !RegularUtils::isValidString(trim($_POST[$key]));
                    }
                    if ($error) {
                        $errors[$name][$key] = "formato_incorrecto";
                    }
                } else {
                    $errors[$name][$key] = "requerido";
                }
            }
        }
        if (isset($errors[$name])) {
            return $errors;
        } else {
            return null;
        }
    }

    /**
     * Método estático que eliminará de los errores aquellos campos no requeridos.
     * 
     * @param array $errors array asociativo con los errores existentes de una verificación previa.
     * @param string $name nombre del campo error.
     * @param string $fields campo a buscar en el array asociativo.
     * @return array con los errores actualizados.
     */
    public static function camposNoRequeridos($errors, $name, $fields) {
        if ($errors != null) {
            foreach ($fields as $field) {
                if (isset($errors[$name][$field])) {
                    if ($errors[$name][$field] === 'requerido') {
                        unset($errors[$name][$field]);
                    }
                }
            }
            if (count($errors[$name]) == 0) {
                $errors = null;
            }
        }
        return $errors;
    }

    /**
     * Método estático que senará los valores pasados por parámetro en un array 
     * pasándoles el filtro de string.
     * 
     * @param array $values array con los valores a sanear.
     * @param string $method método al que invocar (GET/POST)
     * @return array asociativo con los valores saneados
     */
    static public function sanearStrings($values, $method = 'POST') {
        switch ($method) {
            case 'GET':
                $method = INPUT_GET;
                break;
            case 'POST':
            default:
                $method = INPUT_POST;
        }
        foreach ($values as $v) {
            $filtro[$v] = FILTER_SANITIZE_STRING;
        }
        return filter_input_array($method, $filtro);
    }

    /**
     * Método estático que senará los valores pasados por parámetro en un array 
     * pasándoles el filtro de integer.
     * 
     * @param array $values array con los valores a sanear.
     * @param string $method método al que invocar (GET/POST)
     * @return array asociativo con los valores saneados
     */
    static public function sanearIntegers($values) {
        foreach ($values as $v) {
            $filtro[$v] = FILTER_SANITIZE_NUMBER_INT;
        }
        return filter_input_array(INPUT_POST, $filtro);
    }

    /**
     * Método estático que senará los valores pasados por parámetro en un array 
     * pasándoles el filtro de float.
     * 
     * @param array $values array con los valores a sanear.
     * @param string $method método al que invocar (GET/POST)
     * @return array asociativo con los valores saneados
     */
    static public function sanearFloats($values) {
        foreach ($values as $v) {
            $filtro[$v] = array(FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }
        return filter_input_array(INPUT_POST, $filtro);
    }

    /**
     * Método estático que senará los valores pasados por parámetro en un array 
     * pasándoles el filtro de email.
     * 
     * @param array $values array con los valores a sanear.
     * @param string $method método al que invocar (GET/POST)
     * @return array asociativo con los valores saneados
     */
    static public function sanearEmail($values) {
        foreach ($values as $v) {
            $filtro[$v] = FILTER_SANITIZE_EMAIL;
        }
        return filter_input_array(INPUT_POST, $filtro);
    }

    /**
     * Método estático que verificará si un número es un teléfono.
     * 
     * @param string $phone a verificar
     * @return boolean resultado de la verificación.
     */
    static public function isPhone($phone) {
        return preg_match("/^\d{9}$/", $phone);
    }

    /**
     * Método estático que verificará si un número es un móvil.
     * 
     * @param string $mobile a verificar
     * @return boolean resultado de la verificación.
     */
    static public function isMobile($mobile) {
        return preg_match("/^\6\d{8}$/", $mobile);
    }

    /**
     * Método estático que verificará si un string contiene otro string en su interior.
     * 
     * @param string $what a buscar.
     * @param string $in dónde buscar.
     * @return boolean resultado de la verificación.
     */
    static public function containsString($what, $in) {
        return preg_match("/$what/", $in);
    }

    /**
     * Método estático que verificará si string sigue el formato adecuado.
     * 
     * @param string $string a verificar
     * @return boolean resultado de la verificación.
     */
    static public function isValidString($string) {
        return preg_match("/[a-zA-Z0-9_]{1,255}$/", $string);
    }

    /**
     * Método estático que verificará si un email es correcto.
     * 
     * @param string $email a verificar
     * @return boolean resultado de la verificación.
     */
    static public function isEmail($email) {
        return preg_match("/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/", $email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== FALSE;
    }

    /**
     * Método estático que verificará si un número es correcto.
     * 
     * @param string $number a verificar
     * @return boolean resultado de la verificación.
     */
    public static function isNumber($number) {
        return filter_var($number, FILTER_VALIDATE_INT) !== FALSE;
    }

    /**
     * Método estático que verificará si un número es un float correcto.
     * 
     * @param string $number a verificar
     * @return boolean resultado de la verificación.
     */
    public static function isFloat($number) {
        return filter_var($number, FILTER_VALIDATE_FLOAT) !== FALSE;
    }

    /**
     * Método estático que verificará si un string largo sigue el formato adecuado.
     * 
     * @param string $string a verificar
     * @return boolean resultado de la verificación.
     */
    static public function isValidLongString($string) {
        return preg_match("/^[A-Za-z0-9-()\"'@_\s\r\t\n.,áéíóúÁÉÍÓÚñÑ…]{1,3000}$/", $string);
    }

}
