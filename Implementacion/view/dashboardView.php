<?php
require_once 'core/templates/head.php';
?>

<div class="bg-light dk" id="wrap">
    <div id="top">
        <?php require_once 'core/templates/nav.php' ?>  
    </div>
    <div class="container-fluid">
        <?php
        switch ($show) {
            case "comentarios":
                $isComentarios = TRUE;
                require_once 'comentarios.php';
                break;
            case "tipos":
                $isTipos = TRUE;
                require_once 'tipos.php';
                break;
            case "denuncias":
                $isDenuncias = TRUE;
                require_once 'denuncias.php';
                break;
            case "ads":
                $isAds = TRUE;
                require_once 'ads.php';
                break;
            case "users":
            default:
                $isUsers = TRUE;
                require_once 'users.php';
        }
        if (isset($errors['query'])) {
            error($errors['query']);
        }
        ?>
    </div>
</div>
<?php
require_once "core/templates/footer.php";
?>