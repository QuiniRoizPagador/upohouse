<?php ?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo $helper->url("user", "index"); ?>">
            <img src="view/images/home.png" width="30" height="30" class="d-inline-block align-top" alt="" />
        </a>
        <button class="navbar-toggler" type="button" data-target="#nav" data-toggle="collapse" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse w-100 dual-collapse2 order-1 order-md-0" id="nav">
            
            <ul class="navbar-nav mr-auto navbar-center">
                <li class="nav-item">
                    <a class="nav-link" href="#"><?= $lang['comprar'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><?= $lang['alquilar'] ?></a>
                </li>
            </ul>
            <ul class="navbar-nav mr-auto navbar-right">
                <?php if (verifySession()) { ?>
                    <li class = "nav-item">
                        <a class="nav-link " href="#"><i class='fa fa-inbox'></i><?= $lang['mensajes'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $helper->url("session", "logout"); ?>"><?= $lang['cerrar sesion'] ?></a>
                    </li>
                <?php } else {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $helper->url("session", "login"); ?>"><?= $lang['iniciar sesion'] ?></a>
                    </li>
                    <?php
                }
                if (verifyIsAdmin()) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $helper->url("admin", "dashboard"); ?>&show=users">
                            <i class='fa fa-dashboard'></i></a>
                    </li>
                <?php }
                ?>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-language"></i></a>
                    <div class="dropdown-menu" role="menu">
                        <?php
                        $url = array_merge($_GET, array("lang" => "es"));
                        unset($url['controller']);
                        unset($url['action']);
                        ?>
                        <a class="dropdown-item" href="<?= $helper->url($_GET['controller'], $_GET['action'], $url) ?>"><?= $lang['español'] ?></a>
                        <?php
                        $url['lang'] = 'en';
                        ?>
                        <a class="dropdown-item" href="<?= $helper->url($_GET['controller'], $_GET['action'], $url) ?>"><?= $lang['ingles'] ?></a>
                    </div>
                </li>

            </ul>
            <?php if (verifySession()) { ?>
                <span class="navbar-text">
                    <?= $lang['bienvenido'] ?>, <?= $_SESSION['name'] ?>
                </span>
                <?php
            }
            ?>
        </div>
    </nav>
</header>
