<?php
require_once 'core/templates/head.php';
?>

<div class="bg-dark dk" id="wrap">
    <div id="top">
        <!-- .navbar -->

        <?php require_once 'core/templates/nav.php' ?>    
        <?php //require_once 'core/templates/nav.php' ?>
    </div>
    <main role="main" class="bg-light">
        <?php
        require_once 'readAd.php';
        ?>
    </main>
</div>
<?php
require_once "core/templates/footer.php";
?>