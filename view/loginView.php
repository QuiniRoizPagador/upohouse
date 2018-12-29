<?php
require_once 'core/templates/head.php';
require_once 'core/templates/nav.php' 
?>
<div class="form-signin">
    <div class="tab-content">
        <div id="login" class="tab-pane active">
            <form action="<?= $helper->url("Session", "verify") ?>" method="post">
                <p class="text-muted text-center">
                    <?= $lang['iniciar sesion'] ?>
                </p><br />
                <input type="text" name="name" placeholder="<?= $lang['login'] ?>" class="form-control top"><?php isset($errors['name']) ? error($errors['name']) : "" ?><br />
                <input type="password" name="password" placeholder="<?= $lang['contraseña'] ?>" class="form-control bottom"><?php isset($errors['password']) ? error($errors['password']) : "" ?><br />
                <button class="btn btn-lg btn-primary btn-block" type="submit"><?= $lang['enviar'] ?></button>
            </form>
        </div>
        <br />
        <div id="signup" class="tab-pane">
            <form action="<?= $helper->url("User", "register") ?>" method="post"><br />
                <p class="">
                    <?= $lang['registro'] ?>
                </p><br />
                <input type="text" placeholder="<?= $lang['nombre'] ?>" name="name" class="form-control top"><br />
                <input type="text" placeholder="<?= $lang['apellido'] ?>" name="surname" class="form-control middle"><br />
                <input type="email" placeholder="mail@domain.com" name="mail" class="form-control middle"><br />
                <input type="password" placeholder="<?= $lang['contraseña'] ?>" name="password" class="form-control bottom"><br />
                <input type="password" placeholder="<?= $lang['contraseña'] ?>" class="form-control bottom"><br />
                <button class="btn btn-lg btn-success btn-block" type="submit"><?= $lang['registro'] ?></button>
            </form>
        </div>
    </div>
    <?php
    if (isset($errors['login'])) {
        ?>
        <br />
        <?php
        echo error($errors['login']);
        ?>
    <?php }
    ?>
    <hr>
    <div class="text-center">
        <ul class="list-inline">
            <li><a class="text-muted" href="#login" data-toggle="tab"><?= $lang['iniciar sesion'] ?></a></li>
            <li><a class="text-muted" href="#signup" data-toggle="tab"><?= $lang['registro'] ?></a></li>
        </ul>
    </div>
</div>
<?php
require_once "core/templates/footer.php";
?>