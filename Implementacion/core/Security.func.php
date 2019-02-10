<?php

/**
 * Función que verificará la existencia de la sesión y, en caso de ser administrador, 
 * si está autorizado a acceder.
 * 
 * @return boolean Se devuelve la verificación de existencia de sesión.
 */
function verifySession() {
    if (!isset($_SESSION['name'])) {
        return False;
    } else if (isset($_GET['action']) && in_array($_GET['action'], ACTIONS['ADMIN'])) {
        // luego comprobar si el método requiere de administración
        return verifyIsAdmin();
    }
    return True;
}

/**
 * Función que verifica si el parámetro recibido por GET o POST de uuid coincide 
 * con el uuid del usuario que ha realizado alguna petición.
 * 
 * @return boolean Se devuelve verdadero o falso con la verificación de la coincidencia.
 */
function verifyIsSame() {
    return (filter_has_var(INPUT_POST, "uuid") && $_SESSION['uuid'] === $_POST['uuid']) ||
            (filter_has_var(INPUT_GET, "uuid") && $_SESSION['uuid'] === $_GET['uuid']);
}

/**
 * Función que verifica si el usuario en sesión es administrador
 * 
 * @return boolean Se devuelve verdadero o falso con la verificación de la comprobación.
 */
function verifyIsAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == ROLES['ADMIN'];
}

/**
 * Función que verifica si se está trabajando en las secciones de sesión y 
 * su controlador, por utilidad.
 * 
 * @return boolean Se devuelve verdadero o falso con la verificación realizada.
 */
function verifyIsLogin() {
    return isset($_GET["controller"]) && $_GET["controller"] == 'Session';
}

/**
 * Funcion <b>IMPORTANTE</b> que será la encargada de controlar el acceso a las 
 * diferentes secciones. Esta función es el sustento de la seguridad de acceso al sistema.
 * 
 * @return boolean Se devuelve verdadero si se contiene las credenciales adecuadas para el 
 * sitio al que se quiere acceder, falso en caso contrario.
 */
function secureSession() {
    // primero verificar la seguridad interna
    if (in_array($_GET["action"], ACTIONS['USER']) || in_array($_GET["action"], ACTIONS['ADMIN'])) {
        return verifySession();
        // en este caso estamos dentro y no debemos salir sin sentido            
    } else if (in_array($_GET["action"], ACTIONS['GUEST'])) {
        return !verifySession();
    }
    return True;
}
