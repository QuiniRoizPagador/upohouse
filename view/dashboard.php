<div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
    <div class="bg-dark col-md-4 text-left text-white overflow-hidden">
        <div class="my-3 py-3">
            <h2 class="display-5">Añadir usuario</h2>
            <form action="<?php echo $helper->url("user", "create"); ?>" method="post" enctype="multipart/form-data">
                Nombre: <input type="text" name="name" <?php echo isset($_POST['name']) ? "value='" . $_POST['name'] . "'" : "" ?> class="form-control"/><?= isset($errors['name']) ? "<p class='alert alert-danger'>Requerido</p>" : "" ?> <br />
                Apellido: <input type="text" name="surname" <?php echo isset($_POST['surname']) ? "value='" . $_POST['surname'] . "'" : "" ?> class="form-control"/><?= isset($errors['surname']) ? "<p class='alert alert-danger'>Requerido</p> " : "" ?> <br />
                Login: <input type="text" name="login" <?php echo isset($_POST['login']) ? "value='" . $_POST['login'] . "'" : "" ?> class="form-control"/><?= isset($errors['login']) ? "<p class='alert alert-danger'>Requerido</p>" : "" ?> <br />
                Email: <input type="text" name="email" <?php echo isset($_POST['email']) ? "value='" . $_POST['email'] . "'" : "" ?> class="form-control"/><?= isset($errors['email']) ? "<p class='alert alert-danger'>Requerido</p>" : "" ?> <br />
                Contraseña: <input type="password" name="password" class="form-control"/><?= isset($errors['password']) ? "<p class='alert alert-danger'>Requerido</p> <br />" : "" ?> <br />
                
                <button type="submit" class="btn btn-success">Enviar</button>
            </form>
        </div>
    </div>
    <div class="bg-light col-md-8 text-center overflow-hidden">
        <div class="my-3 p-3">
            <h2 class="display-5">Usuarios</h2>
            <table class="table table-responsive table-condensed sortableTable text-left">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th>uuid </th>
                        <th>Login</th>
                        <th>Name </th>
                        <th>Surname </th>
                        <th>Mail </th>
                        <th>Role </th>
                        <th>Fecha Registro </th>
                        <th>Remove </th>
                        <th>Edit </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allusers as $user) { //recorremos el array de objetos y obtenemos el valor de las propiedades   ?>
                        <tr class="active">
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
                                <button type="button" data-toggle="modal" data-target="#remove<?= $user->uuid ?>" class="btn btn-danger"><i class="fa fa-database"></i>  Borrar</button> 
                                <div role="dialog" aria-labelledby="<?= $user->name ?>" aria-hidden="true" tabindex="-1" id="remove<?= $user->uuid ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Eliminar registro de <?= $user->name ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                    <div class="modal-body">    
                                                        &iquest;Estás Seguro?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post" action="<?= $helper->url("user", "remove"); ?>">
                                                            <input type="hidden" value="<?php echo $user->uuid; ?>" name="uuid" />
                                                            <button type="submit" class="btn btn-danger"> <i class="fa fa-database"></i> Borrar</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        </form>
                                                    </div>
                                            </div>

                                        </div>
                                    </div>

                            </td>
                            <td>
                                <button type="button" data-toggle="modal" data-target="#edit<?= $user->uuid ?>" class="btn btn-warning"><i class="fa fa-user"></i>  Edit</button> 
                                <div role="dialog" aria-labelledby="<?= $user->name ?>" aria-hidden="true" tabindex="-1" id="edit<?= $user->uuid ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Editar datos de <?= $user->name ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="<?php echo $helper->url("user", "update"); ?>" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">    
                                                        <input type="hidden" value="<?= $user->uuid ?>" name="uuid"/>
                                                        Nombre: <input type="text" name="name" value="<?= $user->name ?>" class="form-control"/><?= isset($errors['name']) ? "<p class='alert alert-danger'>Requerido</p>" : "" ?> <br />
                                                        Apellido: <input type="text" name="surname" value="<?= $user->surname ?>" class="form-control"/><?= isset($errors['surname']) ? "<p class='alert alert-danger'>Requerido</p> " : "" ?> <br />
                                                        Contraseña: <input type="password" name="password" class="form-control"/><?= isset($errors['password']) ? "<p class='alert alert-danger'>Requerido</p> <br />" : "" ?> <br />
                                                        <!--Imagen Perfil: <input type="file" name="image" /><br />-->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>