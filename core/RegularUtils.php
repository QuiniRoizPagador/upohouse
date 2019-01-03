<?php

namespace core;

class RegularUtils {

    static public function uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
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

    static public function filtrarPorTipo($values, $name) {
        foreach ($values as $key => $value) {
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
                    default:
                        $error = !RegularUtils::isValidString(trim($_POST[$key]));
                        break;
                }
                if ($error) {
                    $errors[$name][$key] = "formato_incorrecto";
                }
            } else {
                $errors[$name][$key] = "requerido";
            }
        }
        if (isset($errors[$name])) {
            return $errors;
        } else {
            return null;
        }
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
            $filtro[$v] = FILTER_SANITIZE_NUMBER_FLOAT;
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

}
