<div class="row">
    <?php
    require_once 'core/templates/lateral.php';
    ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $lang["comentarios"]?></h1>
        </div>
        <canvas class="my-4 col-md-3" id="countRegistrations"></canvas>

        <div class="table-responsive">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>Id </th>
                        <th><?= $lang['anuncio'] ?> </th>
                        <th><?= $lang['user'] ?> </th>
                        <th><?= $lang['contenido'] ?> </th>
                        <th><?= $lang['fecha registro'] ?></th>
                        <th><?= $lang['eliminar']?></th>
                    </tr>
                </thead>
                <tbody id="cuerpo">
                    <?php foreach ($allComments as $comment) { //recorremos el array de objetos y obtenemos el valor de las propiedades    ?>
                        <tr>
                            <td><?= $comment->id; ?> </td>
                            <td><?= $comment->ad_id; ?> </td>
                            <td><?= $comment->user_id; ?> </td>
                            <td><?= $comment->content; ?> </td>
                            <td><?= $comment->timestamp; ?> </td>
                            <td>
                                <button data-toggle="modal" data-target="#remove<?= $comment->uuid ?>"
                                        class="btn btn-danger"><i class="fa fa-window-close"></i></button>



                                    <div tabindex="-1" id="remove<?= $comment->uuid ?>" class="modal fade">
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
                                                    <form method="post" action="<?= $helper->url("admin", "removeComment", array("show" => "comentarios")); ?>">
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
                    for ($i = 0; $i < $numComments / 10; $i++) {
                        ?>
                        <li class="page-item <?= $pag == $i ? "active" : "" ?>">
                            <a class="page-link pagComment"><?= $i + 1 ?></a>
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