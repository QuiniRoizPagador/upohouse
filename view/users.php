<div class="row">
    <?php
    require_once 'core/templates/lateral.php';
    ?>
    <main role="main" class="col-md-10 ml-sm-auto col-lg-10 pt-3 px-4 bg-light">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $lang['usuarios'] ?></h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button data-toggle="modal" data-target="#addUser" class="btn btn-primary btn-sm float-lg-right"><i class="fa fa-plus"></i></button>
                <div role="dialog" aria-labelledby="A&ntilde;adir Usuario" aria-hidden="true" tabindex="-1" id="addUser" class="modal fade" role="dialog">
                    <!-- Modal content-->
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= $lang['añadir usuario'] ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?php echo $helper->url("admin", "createUser", array("show" => "user")); ?>" method="post" class="formUser">
                                <div class="modal-body">
                                    <?php
                                    if (isset($errors['createUser']['query'])) {
                                        ?>
                                        <div class="alert alert-danger">
                                            <?= $lang[$errors['createUser']['query']] ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="form-control has-success col-md-6 ml-auto"> 
                                                <label for="name" class="col-sm-2 col-form-label"><?= $lang['nombre'] ?></label>
                                                <input type="text" id="name" name="name" <?php echo isset($_POST['name']) ? "value='" . $_POST['name'] . "'" : "" ?> class="form-control <?= isset($errors['createUser']['name']) ? " is-invalid" : "" ?>"/>
                                                <div class="invalid-feedback">
                                                    <?= isset($errors['createUser']['name']) ? $lang[$errors['createUser']['name']] : $lang['formato_incorrecto'] ?>
                                                </div>

                                                <label for="surname" class="col-sm-2 col-form-label"><?= $lang['apellido'] ?></label>
                                                <input type="text" id="surname" name="surname" <?php echo isset($_POST['surname']) ? "value='" . $_POST['surname'] . "'" : "" ?> class="form-control  <?= isset($errors['createUser']['surname']) ? " is-invalid" : "" ?>"/>
                                                <div class="invalid-feedback">
                                                    <?= isset($errors['createUser']['surname']) ? $lang[$errors['createUser']['surname']] : $lang['formato_incorrecto'] ?>
                                                </div>

                                                <label for="email" class="col-sm-2 col-form-label"> <?= $lang['email'] ?></label>
                                                <input type="email" id="email" name="email" <?php echo isset($_POST['email']) ? "value='" . $_POST['email'] . "'" : "" ?> class="form-control  <?= isset($errors['createUser']['email']) ? " is-invalid" : "" ?>"/>
                                                <div class="invalid-feedback">
                                                    <?= isset($errors['createUser']['email']) ? $lang[$errors['createUser']['email']] : $lang['formato_incorrecto'] ?>
                                                </div>

                                                <label for="phone" class="col-sm-2 col-form-label"><?= $lang['phone'] ?></label>
                                                <input type="tel" id="phone" name="phone" <?php echo isset($_POST['phone']) ? "value='" . $_POST['phone'] . "'" : "" ?> class="form-control <?= isset($errors['createUser']['phone']) ? " is-invalid" : "" ?>"/>
                                                <div class="invalid-feedback">
                                                    <?= isset($errors['createUser']['phone']) ? $lang[$errors['createUser']['phone']] : $lang['formato_incorrecto'] ?>
                                                </div>
                                            </div>
                                            <div class="form-control has-success col-md-6 ml-auto">
                                                <label for="login" class="col-sm-2 col-form-label"><?= $lang['login'] ?></label>
                                                <input type="text" id="login" name="login" <?php echo isset($_POST['login']) ? "value='" . $_POST['login'] . "'" : "" ?> class="form-control <?= isset($errors['createUser']['login']) ? " is-invalid" : "" ?>"/>
                                                <div class="invalid-feedback">
                                                    <?= isset($errors['createUser']['login']) ? $lang[$errors['createUser']['login']] : $lang['formato_incorrecto'] ?>
                                                </div>
                                                <label for="password" class="col-sm-2 col-form-label "><?= $lang['contraseña'] ?></label>
                                                <input type="password" id="password" name="password" class="form-control password <?= isset($errors['createUser']['password']) ? " is-invalid" : "" ?>"/>
                                                <div class="invalid-feedback">
                                                    <?= isset($errors['createUser']['password']) ? $lang[$errors['createUser']['password']] : $lang['formato_incorrecto'] ?>
                                                </div>
                                                <label for="password2" class="col-sm-2 col-form-label"><?= $lang['contraseña'] ?></label>
                                                <input type="password" id="password2" name="password2" class="form-control password2 <?= isset($errors['createUser']['password2']) ? " is-invalid" : "" ?>"/>
                                                <div class="invalid-feedback">
                                                    <?= isset($errors['createUser']['password2']) ? $lang[$errors['createUser']['password2']] : $lang['formato_incorrecto'] ?>
                                                </div>
                                                <label for="user_role" class="col-sm-2 col-form-label <?= isset($errors['user_role']) ? " is-invalid" : "" ?>"><?= $lang['rol'] ?></label>
                                                <select class="form-control" name="user_role">
                                                    <option value="0">USER</option>
                                                    <option value="1">ADMIN</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Enviar</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <canvas class="my-4 col-md-3" id="countRegistrations"></canvas>
        <?php if (isset($errors['createUser'])): ?>
            <script> $('#addUser').modal('show');</script>
        <?php endif; ?>
        <div class="alert alert-light col-md-3 float-lg-right text-right">
            <span class="badge  badge-pill badge-light"><?= $lang['NEUTRO'] ?></span>
            <span class="badge  badge-pill badge-warning"><?= $lang['BLOQUEADO'] ?></span>
        </div>
        <?php
        if (isset($errors['blockUser']) || isset($errors['removeUser'])) {
            ?>
            <div class='alert alert-danger col-md-3 float-lg-left text-left'>
                <?php
                if (isset($errors['blockUser']['uuid'])) {
                    ?>
                    UUID: <?= $lang[$errors['blockUser']["uuid"]] ?>
                    <?php
                }
                if (isset($errors['removeUser']['uuid'])) {
                    ?>
                    UUID: <?= $lang[$errors['removeUser']["uuid"]] ?>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>

        <div class="table-responsive">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th><?= $lang['nombre'] ?> </th>
                        <th><?= $lang['apellido'] ?> </th>
                        <th><?= $lang['email'] ?> </th>
                        <th><?= $lang['rol'] ?> </th>
                        <th><?= $lang['fecha registro'] ?></th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody id="cuerpo">
                    <?php foreach ($allusers as $user) { //recorremos el array de objetos y obtenemos el valor de las propiedades    ?>
                        <?php
                        $class = "";
                        if ($user->state == STATES['BLOQUEADO']) {
                            $class = "table-warning";
                        }
                        ?>
                        <tr>
                            <td class="<?= $class ?>"><?= $user->id; ?> </td>
                            <td class="<?= $class ?>"><?= $user->name; ?> </td>
                            <td class="<?= $class ?>"><?= $user->surname; ?> </td>
                            <td class="<?= $class ?>"><?= $user->email; ?> </td>
                            <td class="<?= $class ?>"><?= ROLES[$user->user_role]; ?> </td>
                            <td class="<?= $class ?>"><?= $user->timestamp; ?> </td>
                            <td class="<?= $class ?>">
                                <button data-toggle="modal" data-target="#search<?= $user->uuid ?>"
                                        class="btn btn-info btn-sm">
                                    <span class="fa fa-eye"></span>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="search<?= $user->uuid ?>" tabindex="-1"
                                     role="dialog" aria-labelledby="search<?= $user->uuid ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content card">
                                            <div class="card bg-light text-muted">
                                                <div class="card-header modal-header">
                                                    <h5 class="modal-title" id="myModalLabel"><?= $user->name ?>
                                                        <?= $user->surname ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="card-body modal-body">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th>ID</th>
                                                                <td><?= $user->id ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>UUID</th>
                                                                <td><?= $user->uuid ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['nombre'] ?></th>
                                                                <td><?= $user->name ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['login'] ?></th>
                                                                <td><?= $user->login ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['email'] ?></th>
                                                                <td><?= $user->email ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['phone'] ?></th>
                                                                <td><?= $user->phone ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['fecha registro'] ?></th>
                                                                <td><?= $user->timestamp ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['rol'] ?></th>
                                                                <td><?= ROLES[$user->user_role]; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <br>
                                            <div class="text-center">
                                                <?php
                                                if ($user->user_role != ROLES['ADMIN']) {
                                                    if ($user->state == STATES['BLOQUEADO']) {
                                                        ?>
                                                        <div class="alert alert-warning" role="alert">
                                                            <?= $lang['BLOQUEADO'] ?>
                                                        </div>
                                                        <span class="btn" data-toggle="tooltip" title="<?= $lang['desbloquear'] ?>">
                                                            <button type="button" data-toggle="modal" data-target="#unlock<?= $user->uuid ?>" data-dismiss="modal" class="btn btn-success"><i class="fa fa-check"></i></button>
                                                        </span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <span class="btn" data-toggle="tooltip" title="<?= $lang['bloquear'] ?>">
                                                            <button type="button" data-toggle="modal" data-target="#block<?= $user->uuid ?>" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-ban"></i></button>
                                                        </span>
                                                        <?php
                                                    }
                                                    ?>
                                                    <span class="btn" data-toggle="tooltip" title="<?= $lang['eliminar'] ?>">
                                                        <button type="button" data-toggle="modal" data-target="#remove<?= $user->uuid ?>" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-remove"></i></button>
                                                    </span>
                                                    <?php
                                                }
                                                ?>
                                                <span class="btn" data-toggle="tooltip" title="<?= $lang['editar'] ?>">
                                                    <button type="button" data-toggle="modal" data-target="#edit<?= $user->uuid ?>" data-dismiss="modal" class="btn btn-success"><i class="fa fa-pencil"></i></button>
                                                </span>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($user->user_role != ROLES['ADMIN']) {
                                    if ($user->state != STATES['BLOQUEADO']) {
                                        ?>
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
                                    } else {
                                        ?>
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
                                                        <form method="post" action="<?= $helper->url("admin", "unlockUser"); ?>">
                                                            <input type="hidden" value="<?php echo $user->uuid; ?>" name="uuid" />
                                                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i><?= $lang['desbloquear'] ?></button>
                                                            <button type="button" class="btn btn-secondary" data-toggle='modal' data-target="#search<?= $user->uuid ?>" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>

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
                                    <?php
                                }
                                ?>
                                <div tabindex="-1" id="edit<?= $user->uuid ?>" class="modal fade">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content card">
                                            <div class="card-header modal-header">
                                                <h5 class="modal-title"><?= $lang['editar datos de'] ?> <?= $user->name ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#search<?= $user->uuid ?>" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="<?php echo $helper->url("admin", "updateUser", array("show" => "user")); ?>" method="post" class="formUpdateUser">
                                                <div class="modal-body">
                                                    <?php
                                                    if (isset($errors['updateUser'][$user->uuid]['query'])) {
                                                        ?>
                                                        <div class="alert alert-danger">
                                                            <?= $lang[$errors['updateUser'][$user->uuid]['query']] ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="row">
                                                        <div class="form-control has-success col-md-6 ml-auto"> 
                                                            <input type="hidden" value="<?php echo $user->uuid; ?>" name="uuid" />
                                                            <label for="name"><?= $lang['nombre'] ?></label>
                                                            <input type="text" name="name" value="<?= $user->name ?>" class="form-control <?= isset($errors[$user->uuid]['name']) ? " is-invalid" : "" ?>"/>
                                                            <div class="invalid-feedback">
                                                                <?= isset($errors[$user->uuid]['updateUser']['name']) ? $lang[$errors[$user->uuid]['updateUser']['name']] : $lang['formato_incorrecto'] ?>
                                                            </div>

                                                            <label for="surname"><?= $lang['apellido'] ?></label>
                                                            <input type="text" name="surname" value="<?= $user->surname ?>" class="form-control  <?= isset($errors[$user->uuid]['surname']) ? " is-invalid" : "" ?>"/>
                                                            <div class="invalid-feedback">
                                                                <?= isset($errors[$user->uuid]['updateUser']['surname']) ? $lang[$errors[$user->uuid]['updateUser']['surname']] : $lang['formato_incorrecto'] ?>
                                                            </div>

                                                            <label for="phone"><?= $lang['phone'] ?></label>
                                                            <input type="tel" name="phone" value="<?= $user->phone ?>" class="form-control <?= isset($errors[$user->uuid]['updateUser']['phone']) ? " is-invalid" : "" ?>"/>
                                                            <div class="invalid-feedback">
                                                                <?= isset($errors[$user->uuid]['updateUser']['phone']) ? $lang[$errors[$user->uuid]['updateUser']['phone']] : $lang['formato_incorrecto'] ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-control has-success col-md-6 ml-auto">
                                                            <label for="password"><?= $lang['contraseña'] ?></label>
                                                            <input type="password" name="password" class="form-control password <?= isset($errors[$user->uuid]['password']) ? " is-invalid" : "" ?>"/>
                                                            <div class="invalid-feedback">
                                                                <?= isset($errors[$user->uuid]['updateUser']['password']) ? $lang[$errors[$user->uuid]['updateUser']['password']] : $lang['formato_incorrecto'] ?>
                                                            </div>
                                                            <label for="password2"><?= $lang['contraseña'] ?></label>
                                                            <input type="password" name="password2" class="form-control password2 <?= isset($errors[$user->uuid]['password2']) ? " is-invalid" : "" ?>"/>
                                                            <div class="invalid-feedback">
                                                                <?= isset($errors[$user->uuid]['updateUser']['password2']) ? $lang[$errors[$user->uuid]['updateUser']['password2']] : $lang['formato_incorrecto'] ?>
                                                            </div>
                                                            <label for="user_role"><?= $lang['rol'] ?></label>
                                                            <select class="form-control <?= isset($errors[$user->uuid]['updateUser']['user_role']) ? " is-invalid" : "" ?>" name="user_role">
                                                                <option value="0">USER</option>
                                                                <option value="1">ADMIN</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                <?= isset($errors[$user->uuid]['updateUser']['user_role']) ? $lang[$errors[$user->uuid]['updateUser']['user_role']] : $lang['formato_incorrecto'] ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success"><?= $lang['enviar'] ?></button>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#search<?= $user->uuid ?>" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin Modal editar -->
                            </td>

                            <?php if (isset($errors[$user->uuid])) { ?>
                        <script> $('#edit<?= $user->uuid ?>').modal('show');</script>
                    <?php
                    }
                    if (isset($errors['blockUser'][$user->uuid]) || isset($errors['unlockUser'][$user->uuid]) || isset($errors['removeUser'][$user->uuid])) {
                        ?>
                        <script> $('#show<?= $user->uuid ?>').modal('show');</script>
                    <?php }
                    ?>
                    </tr>
<?php } ?>
                </tbody>
            </table>
            <div class="text-xs-center">
                <ul class="pagination pagination-sm justify-content-center">
                    <?php
                    for ($i = 0; $i < $numUsers / 10; $i++) {
                        ?>
                        <li class="page-item <?= $pag == $i ? "active" : "" ?>">
                            <a class="page-link pagUser"><?= $i + 1 ?></a>
                        </li>
                    <?php }
                    ?> 
                </ul>
            </div>

        </div>
    </main>
</div>