<div class="row">
    <?php
    require_once 'core/templates/lateral.php';
    ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $lang['usuarios'] ?></h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button data-toggle="modal" data-target="#addUser" class="btn btn-primary float-lg-right"><i class="fa fa-plus"></i></button>
                <div role="dialog" aria-labelledby="A&ntilde;adir Usuario" aria-hidden="true" tabindex="-1" id="addUser" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?= $lang['añadir usuario'] ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?php echo $helper->url("user", "create"); ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">    
                                        <?= $lang['nombre'] ?>: <input type="text" name="name" <?php echo isset($_POST['name']) ? "value='" . $_POST['name'] . "'" : "" ?> class="form-control"/><?= isset($errors['name']) ? "<p class='alert alert-danger'>" . $lang['requerido'] . "</p>" : "" ?> <br />
                                        <?= $lang['apellido'] ?>: <input type="text" name="surname" <?php echo isset($_POST['surname']) ? "value='" . $_POST['surname'] . "'" : "" ?> class="form-control"/><?= isset($errors['surname']) ? "<p class='alert alert-danger'>" . $lang['requerido'] . "</p> " : "" ?> <br />
                                        <?= $lang['login'] ?>: <input type="text" name="login" <?php echo isset($_POST['login']) ? "value='" . $_POST['login'] . "'" : "" ?> class="form-control"/><?= isset($errors['login']) ? "<p class='alert alert-danger'>" . $lang['requerido'] . "</p>" : "" ?> <br />
                                        <?= $lang['email'] ?>: <input type="text" name="email" <?php echo isset($_POST['email']) ? "value='" . $_POST['email'] . "'" : "" ?> class="form-control"/><?= isset($errors['email']) ? "<p class='alert alert-danger'>" . $lang['requerido'] . "</p>" : "" ?> <br />
                                        <?= $lang['contraseña'] ?>: <input type="password" name="password" class="form-control"/><?= isset($errors['password']) ? "<p class='alert alert-danger'>" . $lang['requerido'] . "</p> <br />" : "" ?> <br />
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
        </div>
        <canvas class="my-4 col-md-6" id="myChart"></canvas>
        <?php if (isset($errors)): ?>
            <script> $('#addUser').modal('show');</script>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th>uuid </th>
                        <th><?= $lang['login'] ?></th>
                        <th><?= $lang['nombre'] ?> </th>
                        <th><?= $lang['apellido'] ?> </th>
                        <th><?= $lang['email'] ?> </th>
                        <th><?= $lang['rol'] ?> </th>
                        <th><?= $lang['fecha registro'] ?></th>
                        <th><?= $lang['eliminar'] ?> </th>
                        <th><?= $lang['editar'] ?> </th>
                        <th><?= $lang['bloquear'] ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allusers as $user) { //recorremos el array de objetos y obtenemos el valor de las propiedades    ?>
                        <tr class="<?= $user->state == STATES['BLOQUEADO'] ? 'alert-danger' : "" ?>">
                            <td><?= $user->id; ?> </td>
                            <td>
                                <?= $user->uuid; ?>
                            </td>
                            <td>
                                <?= $user->login; ?>
                            </td>
                            <td><?= $user->name; ?> </td>
                            <td><?= $user->surname; ?> </td>
                            <td><?= $user->email; ?> </td>
                            <td><?= ROLES[$user->user_role]; ?> </td>
                            <td><?= $user->timestamp; ?> </td>
                            <td>
                                <button type="button" data-toggle="modal" data-target="#remove<?= $user->uuid ?>" class="btn btn-danger"><i class="fa fa-database"></i>  <?= $lang['borrar'] ?></button>
                                <div role="dialog" aria-labelledby="<?= $user->name ?>" aria-hidden="true" tabindex="-1" id="remove<?= $user->uuid ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><?= $lang['eliminar registro de'] ?> <?= $user->name ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?= $lang['estas seguro'] ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post" action="<?= $helper->url("user", "remove"); ?>">
                                                        <input type="hidden" value="<?php echo $user->uuid; ?>" name="uuid" />
                                                        <button type="submit" class="btn btn-danger"> <i class="fa fa-database"></i> <?= $lang['borrar'] ?></button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                            </td>
                            <td>
                                <button type="button" data-toggle="modal" data-target="#edit<?= $user->uuid ?>" class="btn btn-warning"><i class="fa fa-user"></i>  <?= $lang['editar'] ?></button>
                                <div role="dialog" aria-labelledby="<?= $user->name ?>" aria-hidden="true" tabindex="-1" id="edit<?= $user->uuid ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><?= $lang['editar datos de'] ?> <?= $user->name ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?php echo $helper->url("user", "update"); ?>" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="hidden" value="<?= $user->uuid ?>" name="uuid"/>
                                                        <?= $lang['nombre'] ?>: <input type="text" name="name" value="<?= $user->name ?>" class="form-control"/><?= isset($errors['name']) ? "<p class='alert alert-danger'>" . $lang['requerido'] . "</p>" : "" ?> <br />
                                                        <?= $lang['apellido'] ?>: <input type="text" name="surname" value="<?= $user->surname ?>" class="form-control"/><?= isset($errors['surname']) ? "<p class='alert alert-danger'>" . $lang['requerido'] . "</p> " : "" ?> <br />
                                                        <?= $lang['contraseña'] ?>: <input type="password" name="password" class="form-control"/><?= isset($errors['password']) ? "<p class='alert alert-danger'>" . $lang['requerido'] . "</p> <br />" : "" ?> <br />
                                                        <!--Imagen Perfil: <input type="file" name="image" /><br />-->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success"><?= $lang['enciar'] ?></button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                            </td>
                            <td>
                                <?php if ($user->state == STATES['BLOQUEADO']) { ?>
                                    <label><?= $lang['BLOQUEADO'] ?></label>
                                <?php } else { ?>
                                    <button type="button" data-toggle="modal" data-target="#block<?= $user->uuid ?>" class="btn btn-danger"><i class="fa fa-ban"></i></button>
                                    <div role="dialog" aria-labelledby="<?= $user->name ?>" aria-hidden="true" tabindex="-1" id="block<?= $user->uuid ?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Bloquear usuario <?= $user->name ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?= $lang['estas seguro'] ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post" action="<?= $helper->url("user", "blockUser"); ?>">
                                                            <input type="hidden" value="<?php echo $user->uuid; ?>" name="uuid" />
                                                            <button type="submit" class="btn btn-danger"> <i class="fa fa-database"></i> <?= $lang['bloquear'] ?></button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php } ?>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
</div>