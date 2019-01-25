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
                        <li class="list-group-item text-muted"><?=$lang['activity']?> <span class="float-lg-right"><i class="fa fa-tachometer-alt  fa-1x"></i></span></li>
                        <li class="list-group-item"><span class="pull-left"><strong><?= $lang['anuncio'] ?>s</strong></span><span class="float-lg-right"><?= $userAds ?></span></li>
                        <li class="list-group-item"><span class="pull-left"><strong><?= $lang['comments'] ?></strong></span> <span class="float-lg-right"><?= $userComments ?></span></li>
                    </ul> 

                </div><!--/col-3-->
                <div class="col-sm-9">
                    <?php
                    if (verifyIsSame()) {
                        ?>
                        <ul class="nav nav-tabs"  role="tablist">
                            <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab" aria-selected="true"><?= $lang['profile'] ?></a></li>
                            <?php
                            if (verifyIsSame()) {
                                ?>
                                <li class="nav-item"><a class="nav-link" href="#solicitudes" data-toggle="tab" aria-selected="false"><?= $lang['solicitudes'] ?></a></li>
                            <?php }
                            ?>
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
                                        <button type="button" data-toggle="modal" data-target="#remove<?= $user->uuid ?>" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-window-close"></i></button>
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
                                                        <button type="submit" class="btn btn-danger"> <i class="fa fa-window-close"></i> <?= $lang['eliminar'] ?></button>
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

                        </div>
                        <?php
                        if (verifyIsSame()) {
                            ?>
                            <div class="tab-pane" id="solicitudes">
                                <div class="table table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <?= $lang['anuncio'] ?>
                                                </th>
                                                <th>
                                                    <?= $lang['user'] ?>
                                                </th>
                                                <th>
                                                    <?= $lang['when'] ?>
                                                </th>
                                                <th>
                                                    <?= $lang['ver'] ?>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpo">
                                            <?php
                                            foreach ($requests as $request) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?= $helper->url("ad", "read", array("uuid" => $request->ad)) ?>"><?= $request->title ?></a>
                                                    </td>
                                                    <td>
                                                        <a href="<?= $helper->url("user", "readUser", array("uuid" => $request->user_uuid)) ?>"><?= $request->name ?></a>
                                                    </td>
                                                    <td>
                                                        <?= to_time_ago(strtotime($request->timestamp),$lang) ?>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#show<?= $request->ad ?>">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        <div class="modal fade" id="show<?= $request->ad ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                <div class="modal-content card">
                                                                    <div class="card bg-light text-muted">
                                                                        <div class="card-header modal-header">
                                                                            <h5 class="modal-title"><?= $lang['solicitud'] . " " . $request->user ?></h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="card-body modal-body">
                                                                            <button class="btn btn-warning btn-sm float-lg-right"><i class="fa fa-exclamation-triangle "></i></button>
                                                                            <p>
                                                                                <strong><?= $lang['user'] ?></strong>:  <a href="<?= $helper->url("user", "readUser", array("uuid" => $request->user_uuid)) ?>"><?= $request->name ?></a>
                                                                            </p>
                                                                            <h4><?= $lang['contacto'] ?></h4>
                                                                            <p>
                                                                                <strong><?= $lang['phone'] ?></strong>: <?= $request->phone ?>
                                                                            </p>
                                                                            <p>
                                                                                <strong><?= $lang['email'] ?></strong>:<a href="mailto:<?= $request->mail ?>?Subject=<?= $request->ad ?>"> <?= $request->mail ?></a>
                                                                            </p>
                                                                            <hr />
                                                                            <p>
                                                                                <strong><?= $lang['contenido'] ?>:</strong>
                                                                                <br />
                                                                                <?= $request->content ?>
                                                                            </p>
                                                                            <div class="center-block float-lg-right">
                                                                                <div class="btn-group">
                                                                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#refuse<?= $request->req_uuid ?>" data-dismiss="modal"><i class="fa fa-window-close"></i></button>
                                                                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#accept<?= $request->req_uuid ?>" data-dismiss="modal"><i class="fa fa-check"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-foooter modal-footer">
                                                                            <p>
                                                                                <strong><?= $lang['date'] ?>:</strong>
                                                                                <br />
                                                                                <?= $request->timestamp ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div tabindex="-1" id="refuse<?= $request->req_uuid ?>" class="modal fade" >
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"><?= $lang['refuse'] ?></h5>
                                                                        <button type="button" class="close" data-toggle='modal' data-target="#show<?= $request->ad ?>" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?= $lang['estas seguro'] ?>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form method="post" action="<?= $helper->url("request", "refuse") ?>">
                                                                            <input type="hidden" value="<?php echo $request->req_uuid ?>" name="req_uuid" />
                                                                            <input type="hidden" value="<?php echo $request->ad ?>" name="ad_uuid" />
                                                                            <input type="hidden" value="<?php echo $request->user_uuid ?>" name="user_uuid" />
                                                                            <button type="submit" class="btn btn-danger"><i class="fa fa-window-close"></i><?= $lang['refuse'] ?></button>
                                                                            <button type="button" class="btn btn-secondary" data-toggle='modal' data-target="#show<?= $request->ad ?>" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div tabindex="-1" id="accept<?= $request->req_uuid ?>" class="modal fade" >
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"><?= $lang['accept'] ?></h5>
                                                                        <button type="button" class="close" data-toggle='modal' data-target="#show<?= $request->ad ?>" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?= $lang['estas seguro'] ?>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form method="post" action="<?= $helper->url("request", "accept") ?>">
                                                                            <input type="hidden" value="<?php echo $request->req_uuid ?>" name="req_uuid" />
                                                                            <input type="hidden" value="<?php echo $request->ad ?>" name="ad_uuid" />
                                                                            <input type="hidden" value="<?php echo $request->user_uuid ?>" name="user_uuid" />
                                                                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i><?= $lang['accept'] ?></button>
                                                                            <button type="button" class="btn btn-secondary" data-toggle='modal' data-target="#show<?= $request->ad ?>" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="text-xs-center">
                                        <ul class="pagination pagination-sm justify-content-center">
                                            <?php
                                            for ($i = 0; $i < $numRequests / 10; $i++) {
                                                ?>
                                                <li class="page-item <?= $pag == $i ? "active" : "" ?>">
                                                    <a class="page-link pagRequest"><?= $i + 1 ?></a>
                                                </li>
                                            <?php }
                                            ?> 
                                        </ul>
                                    </div>
                                </div>
                            </div><!--/tab-pane-->

                            <?php
                        }
                        ?>
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