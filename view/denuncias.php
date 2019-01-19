<div class="row">
    <?php
    require_once 'core/templates/lateral.php';
    ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $lang["denuncias"] ?></h1>
        </div>
        <canvas class="my-4 col-md-3" id="countRegistrations"></canvas>

        <div class="table-responsive">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th><?= $lang['titulo'] ?> </th>                        
                        <th><?= $lang['descripcion'] ?> </th>                
                        <th><?= $lang['user'] ?> </th>
                        <th><?= $lang['usuario_reported'] ?> </th>
                        <th><?= $lang['anuncio_reported'] ?> </th>
                        <th><?= $lang['comentario_reported'] ?></th>
                        <th><?= $lang['fecha registro'] ?></th>
                        <th><?= $lang["ver"] ?></th>
                    </tr>
                </thead>
                <tbody id="cuerpo">
                    <?php foreach ($allReports as $reports) { //recorremos el array de objetos y obtenemos el valor de las propiedades    ?>
                        <tr>
                            <td><?= $reports->id; ?> </td>
                            <td><?= $reports->title; ?> </td>
                            <td><?= $reports->description; ?> </td>
                            <td><?= $reports->user_id; ?> </td>
                            <td><?= $reports->user_reported; ?> </td>
                            <td><?= $reports->comment_reported; ?> </td>
                            <td><?= $reports->ad_reported; ?></td>
                            <td><?= $reports->timestamp; ?> </td>
                            <td>
                                <button data-toggle="modal" data-target="#search<?= $reports->uuid ?>"
                                        class="btn btn-info btn-sm">
                                    <span class="fa fa-eye"></span>
                                </button>


                                <div tabindex="-1" id="search<?= $reports->uuid ?>" class="modal fade">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= $lang['eliminar anuncio con id'] ?> <?= $comment->id ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" data-toggle="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?= $lang['estas seguro'] ?>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="<?= $helper->url("admin", "removeComment"); ?>">
                                                    <input type="hidden" value="<?php echo $comment->uuid; ?>" name="uuid" />
                                                    <button type="submit" class="btn btn-danger"> <i class="fa fa-window-close"></i> <?= $lang['eliminar'] ?></button>
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                                </form>
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
                    for ($i = 0; $i < $numReports / 10; $i++) {
                        ?>
                        <li class="page-item <?= $i == 0 ? "active" : "" ?>">
                            <a class="page-link pagReports"><?= $i + 1 ?></a>
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