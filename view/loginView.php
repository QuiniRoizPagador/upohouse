<?php
require_once 'core/templates/head.php';
require_once 'core/templates/nav.php';
?>
<ul class="nav nav-tabs"  role="tablist">
    <li class="nav-item"><a class="nav-link <?= !isset($errors['createUser']) ? "active" : "" ?>" href="#login" data-toggle="tab" aria-selected="true"><?= $lang['iniciar sesion'] ?></a></li>
    <li class="nav-item"><a class="nav-link <?= isset($errors['createUser']) ? "active" : "" ?>" href="#signup" data-toggle="tab" aria-selected="false"><?= $lang['registro'] ?></a></li>
</ul>
<div class="tab-content">
    <div id="login" class="tab-pane col-md-2 fade has-success <?= !isset($errors['createUser']) ? "show active" : "" ?> content-center">
        <form action="<?= $helper->url("Session", "verify") ?>" method="post" class="formUser">
            <h3 class="text-muted text-center">
                <?= $lang['iniciar sesion'] ?>
            </h3><br />
            <input type="text" name="name" placeholder="<?= $lang['login'] ?>" class="form-control top <?= isset($errors['login']['name']) ? " is-invalid" : "" ?>">
            <div class="invalid-feedback">
                <?= isset($errors['name']) ? $lang[$errors['login']['name']] : $lang['formato_incorrecto'] ?>
            </div>
            <br />
            <input type="password" name="password" placeholder="<?= $lang['contraseña'] ?>" class="form-control bottom <?= isset($errors['login']['password']) ? " is-invalid" : "" ?>">
            <div class="invalid-feedback">
                <?= isset($errors['password']) ? $lang[$errors['login']['password']] : $lang['formato_incorrecto'] ?>
            </div>
            <br/>
            <button class="btn btn-lg btn-primary btn-block" type="submit"><?= $lang['enviar'] ?></button>
        </form>
    </div>
    <div id="signup" class="tab-pane fade col-md-4 <?= isset($errors['createUser']) ? "show active" : "" ?> content-center">
        <h3 class="text-muted text-center">
            <?= $lang['registro'] ?>
        </h3><br />
        <form action="<?= $helper->url("User", "register") ?>" method="post" class="formUser col-lg-12"><br />
            <div class="form-row has-success"> 
                <div class="col-md-6 mb-2">
                    <label for="name" class="col-sm-2 col-form-label"><?= $lang['nombre'] ?></label>
                    <input type="text" id="name" name="name" <?php echo isset($_POST['name']) ? "value='" . $_POST['name'] . "'" : "" ?> class="form-control <?= isset($errors['createUser']['name']) ? " is-invalid" : "" ?>"/>
                    <div class="invalid-feedback">
                        <?= isset($errors['createUser']['name']) ? $lang[$errors['createUser']['name']] : $lang['formato_incorrecto'] ?>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="surname" class="col-sm-2 col-form-label"><?= $lang['apellido'] ?></label>
                    <input type="text" id="surname" name="surname" <?php echo isset($_POST['surname']) ? "value='" . $_POST['surname'] . "'" : "" ?> class="form-control  <?= isset($errors['createUser']['surname']) ? " is-invalid" : "" ?>"/>
                    <div class="invalid-feedback">
                        <?= isset($errors['createUser']['surname']) ? $lang[$errors['createUser']['surname']] : $lang['formato_incorrecto'] ?>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="email" class="col-sm-2 col-form-label"> <?= $lang['email'] ?></label>
                    <input type="email" id="email" name="email" <?php echo isset($_POST['email']) ? "value='" . $_POST['email'] . "'" : "" ?> class="form-control  <?= isset($errors['createUser']['email']) ? " is-invalid" : "" ?>"/>
                    <div class="invalid-feedback">
                        <?= isset($errors['createUser']['email']) ? $lang[$errors['createUser']['email']] : $lang['formato_incorrecto'] ?>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="phone" class="col-sm-2 col-form-label"><?= $lang['phone'] ?></label>
                    <input type="tel" id="phone" name="phone" <?php echo isset($_POST['phone']) ? "value='" . $_POST['phone'] . "'" : "" ?> class="form-control <?= isset($errors['createUser']['phone']) ? " is-invalid" : "" ?>"/>
                    <div class="invalid-feedback">
                        <?= isset($errors['createUser']['phone']) ? $lang[$errors['createUser']['phone']] : $lang['formato_incorrecto'] ?>
                    </div>
                </div>
            </div>
            <div class="form-row has-success"> 
                <div class="col-md-6 mb-2">
                    <label for="login" class="col-sm-2 col-form-label"><?= $lang['login'] ?></label>
                    <input type="text" id="login" name="login" <?php echo isset($_POST['login']) ? "value='" . $_POST['login'] . "'" : "" ?> class="form-control <?= isset($errors['createUser']['login']) ? " is-invalid" : "" ?>"/>
                    <div class="invalid-feedback">
                        <?= isset($errors['createUser']['login']) ? $lang[$errors['createUser']['login']] : $lang['formato_incorrecto'] ?>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="password" class="col-sm-2 col-form-label "><?= $lang['contraseña'] ?></label>
                    <input type="password" id="password" name="password" class="form-control password <?= isset($errors['createUser']['password']) ? " is-invalid" : "" ?>"/>
                    <div class="invalid-feedback">
                        <?= isset($errors['createUser']['password']) ? $lang[$errors['createUser']['password']] : $lang['formato_incorrecto'] ?>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="password2" class="col-sm-2 col-form-label"><?= $lang['contraseña'] ?></label>
                    <input type="password" id="password2" name="password2" class="form-control password2 <?= isset($errors['createUser']['password2']) ? " is-invalid" : "" ?>"/>
                    <div class="invalid-feedback">
                        <?= isset($errors['createUser']['password2']) ? $lang[$errors['createUser']['password2']] : $lang['formato_incorrecto'] ?>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="submit" class="ol-form-label"><?= $lang['registro'] ?></label>
                    <button class="btn btn-lg btn-success btn-block" type="submit"><?= $lang['registro'] ?></button>
                </div>
        </form>
    </div>
</div>

<?php
if (isset($errors['verify']) || isset($errors['createUser'])) {
    ?>
    <br />
    <?php
    if (isset($errors['verify'])) {
        echo error($lang[$errors['verify']]);
    } else if (isset($errors['createUser'])) {
        echo error($lang[$errors['createUser']['query']]);
    }
    ?>
<?php }
?>
</div>

<?php
require_once "core/templates/footer.php";
?>