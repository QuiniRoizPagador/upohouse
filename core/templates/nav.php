<?php ?>
<header>
    <nav class="site-header sticky-top py-1 bg-dark">
        <div class="container d-flex flex-column flex-md-row justify-content-between">
            <a class="py-2" href="<?php echo $helper->url("user", "index"); ?>">
                <i class='fa fa-home'></i>
                Ventor House
                <!--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mx-auto"><circle cx="12" cy="12" r="10"></circle><line x1="14.31" y1="8" x2="20.05" y2="17.94"></line><line x1="9.69" y1="8" x2="21.17" y2="8"></line><line x1="7.38" y1="12" x2="13.12" y2="2.06"></line><line x1="9.69" y1="16" x2="3.95" y2="6.06"></line><line x1="14.31" y1="16" x2="2.83" y2="16"></line><line x1="16.62" y1="12" x2="10.88" y2="21.94"></line></svg>-->
            </a>
            <a class="py-2 d-none d-md-inline-block left" href="#"><?= $lang['comprar'] ?></a>
            <a class="py-2 d-none d-md-inline-block left" href="#"><?= $lang['alquilar'] ?></a>
            <?php if (verifySession()) { ?>
                <a class="py-2 d-none d-md-inline-block left" href="#">
                    <i class='fa fa-inbox'></i>
                    <?= $lang['mensajes'] ?></a>
                <?php
            }
            if (!verifySession()) {
                ?>
                <a class="py-2 d-none d-md-inline-block right" href="<?php echo $helper->url("session", "login"); ?>"><?= $lang['iniciar sesion'] ?></a>
            <?php } else { ?>
                <a class="py-2 d-none d-md-inline-block right" href="<?php echo $helper->url("session", "logout"); ?>"><?= $lang['cerrar sesion'] ?></a>
                <div class="py-2 d-none d-md-inline-block text-white"> 
                    <?= $lang['bienvenido'] ?>, <?= $_SESSION['name'] ?>
                </div>
                <?php
            }
            if (verifyIsAdmin()) {
                ?>
                <a class="py-2 d-none d-md-inline-block left" href="<?php echo $helper->url("admin", "dashboard"); ?>&show=users">
                    <i class='fa fa-dashboard'></i></a>
            <?php }
            ?>
            <ul class="nav navbar-nav navbar-right py-2 d-none d-md-inline-block right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-language"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <?php
                        $url = array_merge($_GET, array("lang" => "es"));
                        unset($url['controller']);
                        unset($url['action']);
                        ?>
                        <li><a href="<?= $helper->url($_GET['controller'], $_GET['action'], $url) ?>"><?= $lang['español'] ?></a></li>
                        <?php
                        $url['lang'] = 'en';
                        ?>
                        <li><a href="<?= $helper->url($_GET['controller'], $_GET['action'], $url) ?>"><?= $lang['ingles'] ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
