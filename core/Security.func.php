<?php

function verifyOffSession() {
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (!isset($_SESSION['name'])) {
        return False;
    } else if (isset($_GET['action']) && in_array($_GET['action'], ADMIN_ACTIONS)) {
        // luego comprobar si el método requiere de administración
        return verifyIsAdmin();
    }
    return True;
}

function verifyOnSession() {
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
    return !isset($_SESSION['name']);
}

function verifyIsAdmin() {
    return $_SESSION['type_user'] === 'ADMIN';
}

function secureSession() {
    // primero verificar la seguridad interna
    if (in_array($_GET["action"], IN_ACTIONS)) {
        return verifyOffSession();
        // en este caso estamos dentro y no debemos salir sin sentido            
    } else if (in_array($_GET["action"], OUT_ACTIONS)) {
        return verifyOnSession();
    }
    return True;
}
