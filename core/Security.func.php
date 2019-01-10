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
    return (filter_has_var(INPUT_POST, "uuid") && $_SESSION['uuid'] === $_POST['uuid']) ||
            (filter_has_var(INPUT_GET, "uuid") && $_SESSION['uuid'] === $_GET['uuid']);
}

function verifyIsAdmin() {
    //die("<script>alert('" . $_SESSION['user_role'] . "')</script>");
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == ROLES['ADMIN'];
}

function verifyIsLogin() {
    return isset($_GET["controller"]) && $_GET["controller"] == 'Session';
}

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
