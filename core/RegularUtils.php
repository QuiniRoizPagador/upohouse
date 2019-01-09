<?php

namespace core;

class RegularUtils {

    static public function uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

    //El método necesita que se existan dichas imagenes.
    static public function saveAdImages($field, $adId) {
        $images = null;
        $url = IMAGE_AD_URI . "/" . $adId;
        $field = $_FILES[$field];
        mkdir($url);
        $imagesAmount = count($field["name"]);
        for ($i = 0; $i < $imagesAmount; $i++) {
            $fileUrl = $url . "/" . $field["name"][$i];
            move_uploaded_file($field["tmp_name"][$i], $fileUrl);
            $images[] = $fileUrl;
        }
        return $images;
    }

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

    //Todos los campossiempre son requeridos.
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

    static public function sanearStrings($values) {
        foreach ($values as $v) {
            $filtro[$v] = FILTER_SANITIZE_STRING;
        }
        return filter_input_array(INPUT_POST, $filtro);
    }

    static public function sanearIntegers($values) {
        foreach ($values as $v) {
            $filtro[$v] = FILTER_SANITIZE_NUMBER_INT;
        }
        return filter_input_array(INPUT_POST, $filtro);
    }

    static public function sanearFloats($values) {
        foreach ($values as $v) {
            $filtro[$v] = array(FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }
        return filter_input_array(INPUT_POST, $filtro);
    }

    static public function sanearEmail($values) {
        foreach ($values as $v) {
            $filtro[$v] = FILTER_SANITIZE_EMAIL;
        }
        return filter_input_array(INPUT_POST, $filtro);
    }

    static public function isPhone($phone) {
        return preg_match("/^\d{9}$/", $phone);
    }

    static public function isMobile($mobile) {
        return preg_match("/^\6\d{8}$/", $mobile);
    }

    static public function containsString($what, $in) {
        return preg_match("/$what/", $in);
    }

    static public function isValidString($string) {
        return preg_match("/[a-zA-Z0-9_]{1,255}$/", $string);
    }

    static public function isEmail($email) {
        return preg_match("/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/", $email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== FALSE;
    }

    public static function isNumber($number) {
        return filter_var($number, FILTER_VALIDATE_INT) !== FALSE;
    }

    public static function isFloat($number) {
        return filter_var($number, FILTER_VALIDATE_FLOAT) !== FALSE;
    }

}
