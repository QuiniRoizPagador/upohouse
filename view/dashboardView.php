<?php
require_once 'core/templates/head.php';
?>

<div class="bg-dark dk" id="wrap">
    <div id="top">
        <?php require_once 'core/templates/nav.php' ?>  
    </div>
    <div class="container-fluid">
        <?php
        if (isset($_GET['show'])) {
            switch ($_GET['show']) {
                case "users":
                default:
                    $isUsers = TRUE;
                    require_once 'users.php';
                    break;
            }
        } else {
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