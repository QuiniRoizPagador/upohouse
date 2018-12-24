<?php
require_once 'core/templates/head.php';
?>

<div class="bg-dark dk" id="wrap">
    <div id="top">
        <!-- .navbar -->

        <?php require_once 'core/templates/header.php' ?>    
        <?php //require_once 'core/templates/nav.php' ?>
    </div>
    <main role="main">
        <?php
        if (!verifyIsAdmin()) {
            require_once 'main.php';
        } else {
            require_once 'dashboard.php';
        }
        if (isset($errors['query'])) {
            error($errors['query']);
        }
        ?>
    </main>
</div>
<?php
require_once "core/templates/footer.php";
?>