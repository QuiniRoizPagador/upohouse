<?php

function verifySession() {
    if (!isset($_SESSION['name'])) {
        return False;
    } else if (isset($_GET['action']) && in_array($_GET['action'], ACTIONS['ADMIN'])) {
        // luego comprobar si el método requiere de administración
        return verifyIsAdmin();
    }
    return True;
}

function verifyIsSame() {
    return $_SESSION['uuid'] === $_POST['uuid'];
}

function verifyIsAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'ADMIN';
}

function verifyIsLogin() {
    return isset($_GET["action"]) && $_GET["action"] == 'login';
}

function secureSession() {
    // primero verificar la seguridad interna
    if (in_array($_GET["action"], ACTIONS['USER'])) {
        return verifySession();
        // en este caso estamos dentro y no debemos salir sin sentido            
    } else if (in_array($_GET["action"], ACTIONS['GUEST'])) {
        return !verifySession();
    }
    return True;
}
