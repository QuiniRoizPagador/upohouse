<?php
require_once 'core/templates/head.php';
?>


<div class="bg-dark dk" id="wrap">
    <div id="top">
        <!-- .navbar -->

        <?php require_once 'core/templates/header.php' ?>    
        <?php //require_once 'core/templates/nav.php' ?>
    </div>
    <!-- /#left -->
    <div class="" id="content">
        <div class="">
            <div class="inner bg-light lter">
                <div class="text-left">
                    <div class="quick-btn">
                        <i class="fa fa-user-circle fa-2x"></i>
                        <span>Users</span>
                        <span class="label label-default"><?= sizeof($allusers) ?></span>
                    </div>
                </div>
                <hr>
                <div class="col-lg-12">
                    <div class="col-lg-5">
                        <div class="box">
                            <header>
                                <h5>Añadir usuario</h5>
                            </header>
                            <form action="<?php echo $helper->url("user", "create"); ?>" method="post" enctype="multipart/form-data">
                                <h3>Añadir usuario</h3>
                                <hr/>
                                Nombre: <input type="text" name="name" <?php echo isset($_POST['name']) ? "value='" . $_POST['name'] . "'" : "" ?> class="form-control"/><?= isset($errors['name']) ? "<p class='alert alert-danger'>Requerido</p>" : "" ?> <br />
                                Apellido: <input type="text" name="surname" <?php echo isset($_POST['surname']) ? "value='" . $_POST['surname'] . "'" : "" ?> class="form-control"/><?= isset($errors['surname']) ? "<p class='alert alert-danger'>Requerido</p> " : "" ?> <br />
                                Email: <input type="text" name="email" <?php echo isset($_POST['email']) ? "value='" . $_POST['email'] . "'" : "" ?> class="form-control"/><?= isset($errors['email']) ? "<p class='alert alert-danger'>Requerido</p>" : "" ?> <br />
                                Contraseña: <input type="password" name="password" class="form-control"/><?= isset($errors['password']) ? "<p class='alert alert-danger'>Requerido</p> <br />" : "" ?> <br />
                                Imagen Perfil: <input type="file" name="image" /><br />
                                <button type="submit" class="btn btn-success">Enviar</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="box">
                            <table class="table table-condensed sortableTable text-left">
                                <thead>
                                    <tr>
                                        <th>Id <i class="fa fa-sort"></i></th>
                                        <th>Image <i class="fa fa-sort"></i></th>
                                        <th>Name <i class="fa fa-sort"></i></th>
                                        <th>Surname <i class="fa fa-sort"></i></th>
                                        <th>Mail <i class="fa fa-sort"></i></th>
                                        <th>Remove <i class="fa fa-sort"></i></th>
                                        <th>Edit <i class="fa fa-sort"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($allusers as $user) { //recorremos el array de objetos y obtenemos el valor de las propiedades   ?>
                                        <tr class="active">
                                            <td><?= $user->id; ?> </td>
                                            <td>
                                                <?php if (isset($user->image)) { ?>    
                                                    <img class="img img-responsive quick-btn" src="<?= $user->image ?>" alt="imgPerfil"/> 
                                                <?php } ?>
                                            </td>
                                            <td><?= $user->nombre; ?> </td>
                                            <td><?= $user->apellido; ?> </td>
                                            <td><?= $user->email; ?> -</td>
                                            <td>
                                                <form method="post" action="<?= $helper->url("user", "remove"); ?>">
                                                    <input type="hidden" value="<?php echo $user->id; ?>" name="id" />
                                                    <button type="submit" class="btn btn-danger"> <i class="fa fa-database"></i> Borrar</button>
                                                </form>
                                            </td>
                                            <td>
                                                <button type="button" data-toggle="modal" data-target="#edit<?= $user->id ?>" class="btn btn-warning"><i class="fa fa-user"></i>  Edit</button> 
                                                <div id="edit<?= $user->id ?>" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Editar datos de <?= $user->nombre ?></h4>
                                                            </div>
                                                            <form action="<?php echo $helper->url("user", "update"); ?>" method="post" enctype="multipart/form-data">
                                                                <div class="modal-body">    
                                                                    <input type="hidden" value="<?= $user->id ?>" name="id"/>
                                                                    Nombre: <input type="text" name="name" value="<?= $user->nombre ?>" class="form-control"/><?= isset($errors['name']) ? "<p class='alert alert-danger'>Requerido</p>" : "" ?> <br />
                                                                    Apellido: <input type="text" name="surname" value="<?= $user->apellido ?>" class="form-control"/><?= isset($errors['surname']) ? "<p class='alert alert-danger'>Requerido</p> " : "" ?> <br />
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
            </div>
            <!-- /.inner -->
        </div>
        <!-- /.outer -->
    </div>
    <!-- /#content -->
    <?php
    if (isset($errors['query'])) {
        error($errors['query']);
    }
    ?>

    <?php
    require_once "core/templates/footer.php";
    ?>