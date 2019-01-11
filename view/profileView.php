<?php
require_once 'core/templates/head.php';
?>

<div class="bg-dark dk" id="wrap">
    <div id="top">
        <?php require_once 'core/templates/nav.php' ?>  
    </div>
    <div class="container-fluid bg-light">
        <div class="container bootstrap snippet">
            <div class="row">
                <div class="col-sm-10"><h1><?= $user->name ?></h1></div>
            </div>
            <hr />
            <div class="row">
                <div class="col-sm-3"><!--left col-->

                    <ul class="list-group">
                        <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong><?= $lang['anuncio'] ?>s</strong></span><?= $userAds ?></li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong><?= $lang['comments'] ?></strong></span> <?= $userComments ?></li>
                    </ul> 

                </div><!--/col-3-->
                <div class="col-sm-9">
                    <?php
                    if (verifyIsSame()) {
                        ?>
                        <ul class="nav nav-tabs"  role="tablist">
                            <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab" aria-selected="true"><?= $lang['profile'] ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="#solicitudes" data-toggle="tab" aria-selected="false"><?= $lang['solicitudes'] ?></a></li>
                        </ul>
                        <?php
                    }
                    ?>
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">

                            <?php
                            if (verifyIsSame()) {
                                ?>
                                <form class="formUpdateUser row" action="<?php echo $helper->url("user", "updateProfile"); ?>" method="post" >
                                    <input type="hidden" value="<?php echo $user->uuid; ?>" name="uuid" />
                                    <div class="form-control has-success col-md-6 ml-auto"> 
                                        <label for="name" class="col-sm-2 col-form-label"><?= $lang['nombre'] ?></label>
                                        <input type="text" id="name" name="name" value="<?= $user->name ?>" class="form-control <?= isset($errors['createUser']['name']) ? " is-invalid" : "" ?>"/>
                                        <div class="invalid-feedback">
                                            <?= isset($errors['updateUser']['name']) ? $lang[$errors['updateUser']['name']] : $lang['formato_incorrecto'] ?>
                                        </div>


                                        <label for="surname" class="col-sm-2 col-form-label"><?= $lang['apellido'] ?></label>

                                        <input type="text" id="surname" name="surname" value="<?= $user->surname ?>" class="form-control  <?= isset($errors['createUser']['surname']) ? " is-invalid" : "" ?>"/>
                                        <div class="invalid-feedback">
                                            <?= isset($errors['updateUser']['surname']) ? $lang[$errors['updateUser']['surname']] : $lang['formato_incorrecto'] ?>
                                        </div>
                                        <label for="email" class="col-sm-2 col-form-label"> <?= $lang['email'] ?></label>

                                        <input type="email" id="email" name="email" value="<?= $user->email ?>" class="form-control  <?= isset($errors['createUser']['email']) ? " is-invalid" : "" ?>"/>
                                        <div class="invalid-feedback">
                                            <?= isset($errors['updateUser']['email']) ? $lang[$errors['updateUser']['email']] : $lang['formato_incorrecto'] ?>
                                        </div>

                                        <label for="phone" class="col-sm-2 col-form-label"><?= $lang['phone'] ?></label>

                                        <input type="tel" id="phone" name="phone" value="<?= $user->phone ?>" class="form-control <?= isset($errors['createUser']['phone']) ? " is-invalid" : "" ?>"/>
                                        <div class="invalid-feedback">
                                            <?= isset($errors['updateUser']['phone']) ? $lang[$errors['updateUser']['phone']] : $lang['formato_incorrecto'] ?>
                                        </div>

                                    </div>
                                    <div class="form-control has-success col-md-6 ml-auto">
                                        <label for="login" class="col-sm-2 col-form-label"><?= $lang['login'] ?></label>

                                        <input type="text" id="login" name="login" value="<?= $user->login ?>" class="form-control <?= isset($errors['createUser']['login']) ? " is-invalid" : "" ?>"/>
                                        <div class="invalid-feedback">
                                            <?= isset($errors['updateUser']['login']) ? $lang[$errors['updateUser']['login']] : $lang['formato_incorrecto'] ?>
                                        </div>
                                        <label for="password" class="col-sm-2 col-form-label "><?= $lang['contraseña'] ?></label>
                                        <input type="password" id="password" name="password" class="form-control password <?= isset($errors['updateUser']['password']) ? " is-invalid" : "" ?>"/>
                                        <div class="invalid-feedback">
                                            <?= isset($errors['updateUser']['password']) ? $lang[$errors['updateUser']['password']] : $lang['formato_incorrecto'] ?>
                                        </div>
                                        <label for="password2" class="col-sm-2 col-form-label"><?= $lang['contraseña'] ?></label>
                                        <input type="password" id="password2" name="password2" class="form-control password2 <?= isset($errors['updateUser']['password2']) ? " is-invalid" : "" ?>"/>
                                        <div class="invalid-feedback">
                                            <?= isset($errors['updateUser']['password2']) ? $lang[$errors['updateUser']['password2']] : $lang['formato_incorrecto'] ?>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="submit" class="ol-form-label"><?= $lang['update'] ?></label><br />
                                            <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-check"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <?php
                            } else {
                                ?>
                                <div class="row">
                                    <div class="has-success col-md-12 ml-auto"> 
                                        <label for="name" class="col-sm-2 col-form-label"><?= $lang['nombre'] ?></label>
                                        <p class="form-control" id="name"><?= $user->name ?></p>
                                        <label for="surname" class="col-sm-2 col-form-label"><?= $lang['apellido'] ?></label>
                                        <p class="form-control" id="name"><?= $user->surname ?></p>
                                        <label for="email" class="col-sm-2 col-form-label"> <?= $lang['email'] ?></label>
                                        <p class="form-control" id="name"><?= $user->email ?></p>
                                        <label for="phone" class="col-sm-2 col-form-label"><?= $lang['phone'] ?></label>
                                        <p class="form-control" id="name"><?= $user->phone ?></p>
                                        <label for="login" class="col-sm-2 col-form-label"><?= $lang['login'] ?></label>
                                        <p class="form-control" id="name"><?= $user->login ?></p>
                                    </div>
                                </div>
                                <?php
                            }


                            if ($user->user_role != ROLES['ADMIN'] && verifyIsAdmin()) {
                                ?>
                                <div class="col-md-12 text-center">
                                    <?php
                                    if ($user->state == STATES['BLOQUEADO']) {
                                        ?>
                                        <div class="alert alert-warning" role="alert"><?= $lang['BLOQUEADO'] ?></div>
                                        <span class="btn" data-toggle="tooltip" title="<?= $lang['desbloquear'] ?>">
                                            <button type="button" data-toggle="modal" data-target="#unlock<?= $user->uuid ?>" data-dismiss="modal" class="btn btn-success"><i class="fa fa-check"></i></button>
                                        </span>
                                        <div tabindex="-1" id="unlock<?= $user->uuid ?>" class="modal fade" >
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><?= $lang['desbloquear'] . " " . $user->name ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#search<?= $user->uuid ?>" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?= $lang['estas seguro'] ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post" action="<?= $helper->url("admin", "unlockUser", array("show" => "user")); ?>">
                                                            <input type="hidden" value="<?php echo $user->uuid; ?>" name="uuid" />
                                                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i><?= $lang['desbloquear'] ?></button>
                                                            <button type="button" class="btn btn-secondary" data-toggle='modal' data-target="#search<?= $user->uuid ?>" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="btn" data-toggle="tooltip" title="<?= $lang['bloquear'] ?>">
                                            <button type="button" data-toggle="modal" data-target="#block<?= $user->uuid ?>" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-ban"></i></button>
                                        </span>
                                        <div tabindex="-1" id="block<?= $user->uuid ?>" class="modal fade" >
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><?= $lang['bloquear'] . " " . $lang['user'] . " " . $user->name ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#search<?= $user->uuid ?>" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?= $lang['estas seguro'] ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post" action="<?= $helper->url("admin", "blockUser", array("show" => "user")); ?>">
                                                            <input type="hidden" value="<?php echo $user->uuid; ?>" name="uuid" />
                                                            <button type="submit" class="btn btn-warning"><i class="fa fa-ban"></i><?= $lang['bloquear'] ?></button>
                                                            <button type="button" class="btn btn-secondary" data-toggle='modal' data-target="#search<?= $user->uuid ?>" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <span class="btn" data-toggle="tooltip" title="<?= $lang['eliminar'] ?>">
                                        <button type="button" data-toggle="modal" data-target="#remove<?= $user->uuid ?>" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-remove"></i></button>
                                    </span>
                                    <div tabindex="-1" id="remove<?= $user->uuid ?>" class="modal fade">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><?= $lang['eliminar registro de'] ?> <?= $user->name ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#search<?= $user->uuid ?>" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?= $lang['estas seguro'] ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post" action="<?= $helper->url("admin", "removeUser", array("show" => "user")); ?>">
                                                        <input type="hidden" value="<?php echo $user->uuid; ?>" name="uuid" />
                                                        <button type="submit" class="btn btn-danger"> <i class="fa fa-remove"></i> <?= $lang['eliminar'] ?></button>
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#search<?= $user->uuid ?>" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <hr>

                        </div><!--/tab-pane-->
                        <div class="tab-pane" id="solicitudes">

                        </div><!--/tab-pane-->

                    </div><!--/tab-content-->

                </div><!--/col-9-->
            </div><!--/row-->
        </div>
        <?php
        if (isset($errors['query'])) {
            error($errors['query']);
        }
        ?>
    </div>
</div>
<?php
require_once "core/templates/footer.php";
?>