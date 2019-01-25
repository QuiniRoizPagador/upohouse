<div class="row">
    <?php
    require_once 'core/templates/lateral.php';
    ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $lang["denuncias usuario"] ?></h1>
        </div>
        <div class="table-responsive">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th><?= $lang['titulo'] ?> </th>                        
                        <th><?= $lang['descripcion'] ?> </th>                
                        <th><?= $lang['user'] ?> </th>
                        <th><?= $lang['usuario_reported'] ?> </th>
                        <th><?= $lang['fecha registro'] ?></th>
                        <th><?= $lang["ver"] ?></th>
                    </tr>
                </thead>
                <tbody id="cuerpo">
                    <?php foreach ($allReportsUsers as $reports) { //recorremos el array de objetos y obtenemos el valor de las propiedades    ?>
                        <tr>
                            <td><?= $reports->id; ?> </td>
                            <td><?= $reports->title; ?> </td>
                            <td><?= $reports->description; ?> </td>
                            <td><?= $reports->login; ?> </td>
                            <td><?= $reports->login_reported; ?> </td>
                            <td><?= $reports->timestamp; ?> </td>
                            <td>
                                <button data-toggle="modal" data-target="#searchReportUser<?= $reports->uuid ?>"
                                        class="btn btn-info btn-sm">
                                    <span class="fa fa-eye"></span>
                                </button>


                                <div class="modal fade" id="searchReportUser<?= $reports->uuid ?>" tabindex="-1"
                                     role="dialog" aria-labelledby="search<?= $reports->uuid ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content card">
                                            <div class="card bg-light text-muted">
                                                <div class="card-header modal-header">
                                                    <h5 class="modal-title"><?= $reports->id ?> - <?= $reports->title ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <!--HASTA AQUI-->
                                                <div class="card-body modal-body">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th>ID</th>
                                                                <td><?= $reports->id ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>UUID</th>
                                                                <td><?= $reports->uuid ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['titulo'] ?></th>
                                                                <td><?= $reports->title ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['descripcion'] ?></th>
                                                                <td><?= $reports->description ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['user'] ?></th>
                                                                <td><?= $reports->login ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['usuario_reported'] ?></th>
                                                                <td><?= $reports->login_reported ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['fecha registro'] ?></th>
                                                                <td><?= $reports->timestamp ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="text-center">
                                                <form method="post" action="<?= $helper->url("admin", "acceptReportUser", array("show" => "denuncias")); ?>">
                                                    <input type="hidden" value="<?php echo $reports->uuid; ?>" name="uuid" />
                                                    <input type="hidden" value="<?php echo $reports->uuid_reported; ?>" name="user_uuid" />
                                                    <span class="btn" data-toggle="tooltip" title="<?= $lang['accept'] ?>">
                                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button>
                                                    </span>
                                                </form>
                                                <form method="post" action="<?= $helper->url("admin", "denyReportUser", array("show" => "denuncias")); ?>">
                                                    <input type="hidden" value="<?php echo $reports->uuid; ?>" name="uuid" />
                                                    <input type="hidden" value="<?php echo $reports->uuid_reported; ?>" name="user_uuid" />
                                                    <span class="btn" data-toggle="tooltip" title="<?= $lang['deny'] ?>">
                                                        <button type="submit" class="btn btn-danger"><i class="fa fa-close"></i></button>
                                                    </span>
                                                </form>
                                            </div>
                                            <div class="model-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-xs-center">
                <ul class="pagination justify-content-center">
                    <!--<li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>-->
                    <?php
                    for ($i = 0; $i < $numReportsUsers / 10; $i++) {
                        ?>
                        <li class="page-item <?= $pag == $i ? "active" : "" ?>">
                            <a class="page-link pagReportsUser"><?= $i + 1 ?></a>
                        </li>
                    <?php }
                    ?>       
                    <!--<li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <      span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>-->
                </ul>
            </div>

        </div>


        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $lang["denuncias anuncio"] ?></h1>
        </div>
        <div class="table-responsive">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th><?= $lang['titulo'] ?> </th>                        
                        <th><?= $lang['descripcion'] ?> </th>                
                        <th><?= $lang['user'] ?> </th>
                        <th><?= $lang['anuncio_reported'] ?> </th>
                        <th><?= $lang['fecha registro'] ?></th>
                        <th><?= $lang["ver"] ?></th>
                    </tr>
                </thead>
                <tbody id="cuerpo2">
                    <?php foreach ($allReportsAds as $reports) { //recorremos el array de objetos y obtenemos el valor de las propiedades    ?>
                        <tr>
                            <td><?= $reports->id; ?> </td>
                            <td><?= $reports->title; ?> </td>
                            <td><?= $reports->description; ?> </td>
                            <td><?= $reports->login; ?> </td>
                            <td><?= $reports->ad_reported; ?></td>
                            <td><?= $reports->timestamp; ?> </td>
                            <td>
                                <button data-toggle="modal" data-target="#searchReportAds<?= $reports->uuid ?>"
                                        class="btn btn-info btn-sm">
                                    <span class="fa fa-eye"></span>
                                </button>


                                <div class="modal fade" id="searchReportAds<?= $reports->uuid ?>" tabindex="-1"
                                     role="dialog" aria-labelledby="search<?= $reports->uuid ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content card">
                                            <div class="card bg-light text-muted">
                                                <div class="card-header modal-header">
                                                    <h5 class="modal-title"><?= $reports->id ?> - <?= $reports->title ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="card-body modal-body">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th>ID</th>
                                                                <td><?= $reports->id ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>UUID</th>
                                                                <td><?= $reports->uuid ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['titulo'] ?></th>
                                                                <td><?= $reports->title ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['descripcion'] ?></th>
                                                                <td><?= $reports->description ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['user'] ?></th>
                                                                <td><?= $reports->login ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['anuncio_reported'] ?></th>
                                                                <td><?= $reports->ad_reported ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['fecha registro'] ?></th>
                                                                <td><?= $reports->timestamp ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="text-center">
                                                <form method="post" action="<?= $helper->url("admin", "acceptReportAd", array("show" => "denuncias")); ?>">
                                                    <input type="hidden" value="<?php echo $reports->uuid; ?>" name="uuid" />
                                                    <input type="hidden" value="<?php echo $reports->uuid_reported; ?>" name="ad_uuid" />
                                                    <span class="btn" data-toggle="tooltip" title="<?= $lang['accept'] ?>">
                                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button>
                                                    </span>
                                                </form>
                                                <form method="post" action="<?= $helper->url("admin", "denyReportAd", array("show" => "denuncias")); ?>">
                                                    <input type="hidden" value="<?php echo $reports->uuid; ?>" name="uuid" />
                                                    <input type="hidden" value="<?php echo $reports->uuid_reported; ?>" name="ad_uuid" />
                                                    <span class="btn" data-toggle="tooltip" title="<?= $lang['deny'] ?>">
                                                        <button type="submit" class="btn btn-danger"><i class="fa fa-close"></i></button>
                                                    </span>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-xs-center">
                <ul class="pagination justify-content-center">
                    <!--<li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>-->
                    <?php
                    for ($i = 0; $i < $numReportsAds / 10; $i++) {
                        ?>
                        <li class="page-item <?= $pag == $i ? "active" : "" ?>">
                            <a class="page-link pagReportsAd"><?= $i + 1 ?></a>
                        </li>
                    <?php }
                    ?>       
                    <!--<li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <      span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>-->
                </ul>
            </div>

        </div>


        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $lang["denuncias comentario"] ?></h1>
        </div>
        <div class="table-responsive">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th><?= $lang['titulo'] ?> </th>                        
                        <th><?= $lang['descripcion'] ?> </th>                
                        <th><?= $lang['user'] ?> </th>
                        <th><?= $lang['comentario_reported'] ?> </th>
                        <th><?= $lang['fecha registro'] ?></th>
                        <th><?= $lang["ver"] ?></th>
                    </tr>
                </thead>
                <tbody id="cuerpo3">
                    <?php foreach ($allReportsComments as $reports) { //recorremos el array de objetos y obtenemos el valor de las propiedades    ?>
                        <tr>
                            <td><?= $reports->id; ?> </td>
                            <td><?= $reports->title; ?> </td>
                            <td><?= $reports->description; ?> </td>
                            <td><?= $reports->login; ?> </td>
                            <td><?= $reports->comment_reported; ?></td>
                            <td><?= $reports->timestamp; ?> </td>
                            <td>
                                <button data-toggle="modal" data-target="#searchReportComments<?= $reports->uuid ?>"
                                        class="btn btn-info btn-sm">
                                    <span class="fa fa-eye"></span>
                                </button>


                                <div class="modal fade" id="searchReportComments<?= $reports->uuid ?>" tabindex="-1"
                                     role="dialog" aria-labelledby="search<?= $reports->uuid ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content card">
                                            <div class="card bg-light text-muted">
                                                <div class="card-header modal-header">
                                                    <h5 class="modal-title"><?= $reports->id ?> - <?= $reports->title ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="card-body modal-body">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th>ID</th>
                                                                <td><?= $reports->id ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>UUID</th>
                                                                <td><?= $reports->uuid ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['titulo'] ?></th>
                                                                <td><?= $reports->title ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['descripcion'] ?></th>
                                                                <td><?= $reports->description ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['user'] ?></th>
                                                                <td><?= $reports->login ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['comentario_reported'] ?></th>
                                                                <td><?= $reports->comment_reported ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['fecha registro'] ?></th>
                                                                <td><?= $reports->timestamp ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="text-center">
                                                <form method="post" action="<?= $helper->url("admin", "acceptReportComment", array("show" => "denuncias")); ?>">
                                                    <input type="hidden" value="<?php echo $reports->uuid; ?>" name="uuid" />
                                                    <input type="hidden" value="<?php echo $reports->uuid_reported; ?>" name="comment_uuid" />
                                                    <span class="btn" data-toggle="tooltip" title="<?= $lang['accept'] ?>">
                                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button>
                                                    </span>
                                                </form>
                                                <form method="post" action="<?= $helper->url("admin", "denyReportComment", array("show" => "denuncias")); ?>">
                                                    <input type="hidden" value="<?php echo $reports->uuid; ?>" name="uuid" />
                                                    <input type="hidden" value="<?php echo $reports->uuid_reported; ?>" name="comment_uuid" />
                                                    <span class="btn" data-toggle="tooltip" title="<?= $lang['deny'] ?>">
                                                        <button type="submit" class="btn btn-danger"><i class="fa fa-close"></i></button>
                                                    </span>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
<<<<<<< HEAD
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-xs-center">
                <ul class="pagination justify-content-center">
                    <!--<li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>-->
                    <?php
                    for ($i = 0; $i < $numReportsComments / 10; $i++) {
                        ?>
                        <li class="page-item <?= $pag == $i ? "active" : "" ?>">
                            <a class="page-link pagReportsComment"><?= $i + 1 ?></a>
                        </li>
                    <?php }
                    ?>       
                    <!--<li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <      span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>-->
                </ul>
            </div>

        </div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $lang["denuncias peticion"] ?></h1>
        </div>
        <div class="table-responsive">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th><?= $lang['titulo'] ?> </th>                        
                        <th><?= $lang['descripcion'] ?> </th>                
                        <th><?= $lang['user'] ?> </th>
                        <th><?= $lang['request_reported'] ?> </th>
                        <th><?= $lang['fecha registro'] ?></th>
                        <th><?= $lang["ver"] ?></th>
                    </tr>
                </thead>
                <tbody id="cuerpo4">
                    <?php foreach ($allReportsRequests as $reports) { //recorremos el array de objetos y obtenemos el valor de las propiedades    ?>
                        <tr>
                            <td><?= $reports->id; ?> </td>
                            <td><?= $reports->title; ?> </td>
                            <td><?= $reports->description; ?> </td>
                            <td><?= $reports->login; ?> </td>
                            <td><?= $reports->request_reported; ?></td>
                            <td><?= $reports->timestamp; ?> </td>
                            <td>
                                <button data-toggle="modal" data-target="#çv<?= $reports->uuid ?>"
                                        class="btn btn-info btn-sm">
                                    <span class="fa fa-eye"></span>
                                </button>


                                <div class="modal fade" id="searchReportRequests<?= $reports->uuid ?>" tabindex="-1"
                                     role="dialog" aria-labelledby="search<?= $reports->uuid ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content card">
                                            <div class="card bg-light text-muted">
                                                <div class="card-header modal-header">
                                                    <h5 class="modal-title"><?= $reports->id ?> - <?= $reports->title ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="card-body modal-body">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <th>ID</th>
                                                                <td><?= $reports->id ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>UUID</th>
                                                                <td><?= $reports->uuid ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['titulo'] ?></th>
                                                                <td><?= $reports->title ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['descripcion'] ?></th>
                                                                <td><?= $reports->description ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['user'] ?></th>
                                                                <td><?= $reports->login ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['request_reported'] ?></th>
                                                                <td><?= $reports->request_reported ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?= $lang['fecha registro'] ?></th>
                                                                <td><?= $reports->timestamp ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="text-center">
                                                <form method="post" action="<?= $helper->url("admin", "acceptReportRequest", array("show" => "denuncias")); ?>">
                                                    <input type="hidden" value="<?php echo $reports->uuid; ?>" name="uuid" />
                                                    <input type="hidden" value="<?php echo $reports->uuid_reported; ?>" name="request_uuid" />
                                                    <span class="btn" data-toggle="tooltip" title="<?= $lang['accept'] ?>">
                                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button>
                                                    </span>
                                                </form>
                                                <form method="post" action="<?= $helper->url("admin", "denyReportRequest", array("show" => "denuncias")); ?>">
                                                    <input type="hidden" value="<?php echo $reports->uuid; ?>" name="uuid" />
                                                    <input type="hidden" value="<?php echo $reports->request_reported; ?>" name="request_uuid" />
                                                    <span class="btn" data-toggle="tooltip" title="<?= $lang['deny'] ?>">
                                                        <button type="submit" class="btn btn-danger"><i class="fa fa-close"></i></button>
                                                    </span>
=======
                                                <form method="post" action="<?= $helper->url("admin", "removeComment"); ?>">
                                                    <input type="hidden" value="<?php echo $comment->uuid; ?>" name="uuid" />
                                                    <button type="submit" class="btn btn-danger"> <i class="fa fa-window-close"></i> <?= $lang['eliminar'] ?></button>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
>>>>>>> 17ddce4c737896dc11096a8703e79e0ca5c96987
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-xs-center">
                <ul class="pagination justify-content-center">
                    <!--<li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>-->
                    <?php
                    for ($i = 0; $i < $numReportsRequests / 10; $i++) {
                        ?>
                        <li class="page-item <?= $pag == $i ? "active" : "" ?>">
                            <a class="page-link pagReportsRequest"><?= $i + 1 ?></a>
                        </li>
                    <?php }
                    ?>       
                    <!--<li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <      span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>-->
                </ul>
            </div>

        </div>


    </main>
</div>