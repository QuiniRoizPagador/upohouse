<?php
$class = "";
if (in_array($title, FOOTER_ABSOLUTE)) {
    $class = "footer-absolute";
}
?>
<footer class="footer <?= $class ?>">
    <div class="row">
        <div class="col-12 col-md">
            <small class="d-block mb-3 text-muted">&copy; 2018-2019</small>
        </div>
        <div class="col-6 col-md">
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="<?php echo $helper->url("user", "index"); ?>"><i class="fa fa-home"></i></a></li>
                <li><a class="text-muted" href="<?= $helper->url("ad", "listAds") ?>"><?= $lang['anuncios'] ?></a></li>
                <?php if (verifySession()) { ?>
                    <li><a class="text-muted" href="<?= $helper->url("user", "readUser", array("uuid" => $_SESSION['uuid'])) ?>"><?= $lang['profile'] ?></a></li>
                    <li><a class="text-muted" href="<?php echo $helper->url("session", "logout"); ?>"><?= $lang['cerrar sesion'] ?></a></li>
                <?php } else {
                    ?>
                    <li class="nav-item"><a class="text-muted" href="<?php echo $helper->url("session", "login"); ?>"><?= $lang['iniciar sesion'] ?></a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5><i class="fa fa-code-branch"></i> <a class="text-muted" href="https://github.com/QuiniRoizPagador/CorePHPMVC">Master Branch</a></h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="https://github.com/AQR7">Alberto Quevedo Rodr&iacute;guez</a></li>
                <li><a class="text-muted" href="https://github.com/QuiniRoizPagador">Joaqu&iacute;n Roiz Pagador</a></li>
                <li><a class="text-muted" href="https://github.com/Takerlagia">Andr&eacute;s Rueda Mar&iacute;n</a></li>
            </ul>
        </div>
    </div>
</footer>
</body>
</html>