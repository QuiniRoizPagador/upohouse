<div class="row">
    <?php
    require_once 'core/templates/lateral.php';
    ?>
    <main role="main" class="col-md-10 ml-sm-auto col-lg-10 pt-3 px-4 bg-light">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $lang['tipos vivienda'] ?></h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button data-toggle="modal" data-target="#addHousingType" class="btn btn-primary btn-sm float-lg-right"><i class="fa fa-plus"></i></button>
                <div role="dialog" aria-hidden="true" tabindex="-1" id="addHousingType" class="modal fade">

                    <!-- Modal content-->
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= $lang['añadir tipo de vivienda'] ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?php echo $helper->url("admin", "createHousingTypes", array("show" => "tipos")); ?>" method="post" class="formHousingTypes">
                                <div class="modal-body">
                                    <?php
                                    if (isset($errors['createHousingTypes']['query'])) {
                                        ?>
                                        <div class="alert alert-danger">
                                            <?= $lang[$errors['createHousingTypes']['query']] ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="form-control has-success col-md-12 ml-auto"> 
                                                <label for="nameHousingType" class="col-sm-2 col-form-label"><?= $lang['nombre'] ?></label>
                                                <input type="text" id="nameHousingType" name="name" <?php echo isset($_POST['name']) ? "value='" . $_POST['name'] . "'" : "" ?> class="form-control <?= isset($errors['createHousingTypes']['name']) ? " is-invalid" : "" ?>"/>
                                                <div class="invalid-feedback">
                                                    <?= isset($errors['createHousingTypes']['name']) ? $lang[$errors['createHousingTypes']['name']] : $lang['formato_incorrecto'] ?>
                                                </div>
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
        <?php if (isset($errors['createHousingTypes'])): ?>
            <script> $('#addHousingType').modal('show');</script>
            <?php
        endif;
        ?>

        <div class="table-responsive">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th><?= $lang['nombre'] ?> </th>
                        <th><?= $lang['editar'] ?></th>
                        <th><?= $lang['eliminar'] ?></th>
                    </tr>
                </thead>
                <tbody id="cuerpo">
                    <?php foreach ($allHousingTypes as $housingType) { //recorremos el array de objetos y obtenemos el valor de las propiedades    ?>
                        <?php
                        $class = "";
                        ?>
                        <tr>
                            <td><?= $housingType->id; ?> </td>
                            <td><?= $housingType->name; ?> </td>
                            <td>
                                <button data-toggle="modal" type="button" data-target="#edit<?= $housingType->uuid ?>" data-dismiss="modal" class="btn btn-success"><i class="fa fa-edit"></i></button>

                                <div tabindex="-1" id="edit<?= $housingType->uuid ?>" class="modal fade">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= $lang['editar registro de'] ?> <?= $housingType->name ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" data-toggle="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="<?php echo $helper->url("admin", "updateHousingTypes", array("show" => "tipos")); ?>" method="post" class="formUpdateHousingTypes">
                                                <div class="modal-body">
                                                    <?php
                                                    if (isset($errors['updateHousingTypes']['query'])) {
                                                        ?>
                                                        <div class="alert alert-danger">
                                                            <?= $lang[$errors['updateHousingTypes']['query']] ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="form-control has-success col-md-12 ml-auto"> 
                                                                <input type="hidden" value="<?php echo $housingType->uuid; ?>" name="uuid" />
                                                                <label class="col-sm-2 col-form-label"><?= $lang['nombre'] ?></label>
                                                                <input type="text" name="name" <?php echo isset($_POST['name']) ? "value='" . $_POST['name'] . "'" : "" ?> class="form-control <?= isset($errors['updateHousingTypes']['name']) ? " is-invalid" : "" ?>"/>
                                                                <div class="invalid-feedback">
                                                                    <?= isset($errors['updateHousingTypes']['name']) ? $lang[$errors['updateHousingTypes']['name']] : $lang['formato_incorrecto'] ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Enviar</button>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                            </td>
                            <td>
                                <button data-toggle="modal" data-target="#remove<?= $housingType->uuid ?>"
                                        class="btn btn-danger"><i class="fa fa-window-close"></i></button>



                                <div tabindex="-1" id="remove<?= $housingType->uuid ?>" class="modal fade">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= $lang['eliminar registro de'] ?> <?= $housingType->name ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" data-toggle="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?= $lang['estas seguro'] ?>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="<?= $helper->url("admin", "removeHousingType", array("show" => "tipos")); ?>">
                                                    <input type="hidden" value="<?php echo $housingType->uuid; ?>" name="uuid" />
                                                    <button type="submit" class="btn btn-danger"> <i class="fa fa-window-close"></i> <?= $lang['eliminar'] ?></button>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <?php if (isset($errors[$housingType->uuid])): ?>
                        <script> $('#edit<?= $housingType->uuid ?>').modal('show');</script>
                    <?php endif; ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="text-xs-center">
                <ul class="pagination justify-content-center">
                    <?php
                    for ($i = 0; $i < $numHousingTypes / 10; $i++) {
                        ?>
                        <li class="page-item <?= $pag == $i ? "active" : "" ?>">
                            <a class="page-link pagHousingTypes"><?= $i + 1 ?></a>
                        </li>
                    <?php }
                    ?>       
                </ul>
            </div>

        </div>



        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $lang['tipos operacion'] ?></h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button data-toggle="modal" data-target="#addOperationType" class="btn btn-primary btn-sm float-lg-right"><i class="fa fa-plus"></i></button>
                <div role="dialog" aria-hidden="true" tabindex="-1" id="addOperationType" class="modal fade">

                    <!-- Modal content-->
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= $lang['añadir tipo de operacion'] ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?php echo $helper->url("admin", "createOperationTypes", array("show" => "tipos")); ?>" method="post" class="formOperationTypes">
                                <div class="modal-body">
                                    <?php
                                    if (isset($errors['createOperationTypes']['query'])) {
                                        ?>
                                        <div class="alert alert-danger">
                                            <?= $lang[$errors['createOperationTypes']['query']] ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="form-control has-success col-md-12 ml-auto"> 
                                                <label for="nameOperationType" class="col-sm-2 col-form-label"><?= $lang['nombre'] ?></label>
                                                <input type="text" id="nameOperationType" name="name" <?php echo isset($_POST['name']) ? "value='" . $_POST['name'] . "'" : "" ?> class="form-control <?= isset($errors['createOperationTypes']['name']) ? " is-invalid" : "" ?>"/>
                                                <div class="invalid-feedback">
                                                    <?= isset($errors['createOperationTypes']['name']) ? $lang[$errors['createOperationTypes']['name']] : $lang['formato_incorrecto'] ?>
                                                </div>
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
        <?php if (isset($errors['createOperationTypes'])): ?>
            <script> $('#addOperationType').modal('show');</script>
            <?php
        endif;
        ?>
        <div class="table-responsive">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th><?= $lang['nombre'] ?> </th>
                        <th><?= $lang['editar'] ?></th>
                        <th><?= $lang['eliminar'] ?></th>
                    </tr>
                </thead>
                <tbody id="cuerpo2">
                    <?php foreach ($allOperationTypes as $OperationType) { //recorremos el array de objetos y obtenemos el valor de las propiedades    ?>
                        <?php
                        $class = "";
                        ?>
                        <tr>
                            <td><?= $OperationType->id; ?> </td>
                            <td><?= $OperationType->name; ?> </td>
                            <td>
                                <button data-toggle="modal" type="button" data-target="#edit2<?= $OperationType->uuid ?>" data-dismiss="modal" class="btn btn-success"><i class="fa fa-edit"></i></button>

                                <div tabindex="-1" id="edit2<?= $OperationType->uuid ?>" class="modal fade">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= $lang['editar tipo operacion'] ?> <?= $OperationType->name ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" data-toggle="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="<?php echo $helper->url("admin", "updateOperationTypes", array("show" => "tipos")); ?>" method="post" class="formUpdateOperationTypes">
                                                <div class="modal-body">
                                                    <?php
                                                    if (isset($errors['updateOperationTypes']['query'])) {
                                                        ?>
                                                        <div class="alert alert-danger">
                                                            <?= $lang[$errors['updateOperationTypes']['query']] ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="form-control has-success col-md-12 ml-auto"> 
                                                                <input type="hidden" value="<?php echo $OperationType->uuid; ?>" name="uuid" />
                                                                <label class="col-sm-2 col-form-label"><?= $lang['nombre'] ?></label>
                                                                <input type="text" name="name" <?php echo isset($_POST['name']) ? "value='" . $_POST['name'] . "'" : "" ?> class="form-control <?= isset($errors['updateOperationTypes']['name']) ? " is-invalid" : "" ?>"/>
                                                                <div class="invalid-feedback">
                                                                    <?= isset($errors['updateOperationTypes']['name']) ? $lang[$errors['updateOperationTypes']['name']] : $lang['formato_incorrecto'] ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Enviar</button>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                            </td>
                            <td>
                                <button data-toggle="modal" data-target="#remove2<?= $OperationType->uuid ?>"
                                        class="btn btn-danger"><i class="fa fa-window-close"></i></button>



                                <div tabindex="-1" id="remove2<?= $OperationType->uuid ?>" class="modal fade">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= $lang['eliminar registro de'] ?> <?= $OperationType->name ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" data-toggle="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?= $lang['estas seguro'] ?>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="<?= $helper->url("admin", "removeOperationType", array("show" => "tipos")); ?>">
                                                    <input type="hidden" value="<?php echo $OperationType->uuid; ?>" name="uuid" />
                                                    <button type="submit" class="btn btn-danger"> <i class="fa fa-window-close"></i> <?= $lang['eliminar'] ?></button>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <?php if (isset($errors[$OperationType->uuid])): ?>
                        <script> $('#edit<?= $OperationType->uuid ?>').modal('show');</script>
                    <?php endif; ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="text-xs-center">
                <ul class="pagination justify-content-center">
                    <?php
                    for ($i = 0; $i < $numOperationTypes / 10; $i++) {
                        ?>
                        <li class="page-item <?= $pag == $i ? "active" : "" ?>">
                            <a class="page-link pagOperationTypes"><?= $i + 1 ?></a>
                        </li>
                    <?php }
                    ?>       
                </ul>
            </div>

        </div>
    </main>

</div>