<?php
require_once 'core/templates/header.html';
?>
<form action="<?php echo $helper->url("user", "create"); ?>" method="post" class="col-lg-5" enctype="multipart/form-data">
    <h3>Añadir usuario</h3>
    <hr/>
    Nombre: <input type="text" name="name" <?php echo isset($_POST['name']) ? "value='" . $_POST['name'] . "'" : "" ?> class="form-control"/><?= isset($errors['name']) ? "<p class='alert alert-danger'>Requerido</p>" : "" ?> <br />
    Apellido: <input type="text" name="surname" <?php echo isset($_POST['surname']) ? "value='" . $_POST['surname'] . "'" : "" ?> class="form-control"/><?= isset($errors['surname']) ? "<p class='alert alert-danger'>Requerido</p> " : "" ?> <br />
    Email: <input type="text" name="email" <?php echo isset($_POST['email']) ? "value='" . $_POST['email'] . "'" : "" ?> class="form-control"/><?= isset($errors['email']) ? "<p class='alert alert-danger'>Requerido</p>" : "" ?> <br />
    Contraseña: <input type="password" name="password" class="form-control"/><?= isset($errors['password']) ? "<p class='alert alert-danger'>Requerido</p> <br />" : "" ?> <br />
    Imagen Perfil: <input type="file" name="image" /><br />
    <input type="submit" value="enviar" class="btn btn-success"/>
</form>

<div class="col-lg-7">
    <h3>Usuarios</h3>
    <hr/>
</div>
<section class="col-lg-7 usuario" style="height:400px;overflow-y:scroll;">
    <?php foreach ($allusers as $user) { //recorremos el array de objetos y obtenemos el valor de las propiedades   ?>
        <?php if (isset($user->image)) { ?>    
            <img src="<?= $user->image ?>" alt="imgPerfil" class="img img-responsive" style="height: 10%; float:left"/> - 
        <?php } ?>
        <?= $user->id; ?> -
        <?= $user->nombre; ?> -
        <?= $user->apellido; ?> -
        <?= $user->email; ?> -
        <div class="right">
            <a href="<?= $helper->url("user", "remove"); ?>&id=<?php echo $user->id; ?>" class="btn btn-danger">Borrar</a>
        </div>
        <hr/>
    <?php } ?>
</section>
<?php
require_once "core/templates/footer.html";
?>