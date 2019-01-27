<section class="container py-5">
    <div class="d-flex justify-content-between pb-2 mb-3 border-bottom">
        <h2 class="h2"><?= $lang["anuncio"] ?></h2>
    </div>
    <div class="row">
        <div class="container-fluid col-sm-9">
            <div class="row justify-content-between">
                <div class="col-md-3">
                    <h6><?= $lang["tipoCasa"] ?></h6>
                    <p><?= $housingType->name ?></p>
                </div>
                <div class="col-md-3">
                    <h6><?= $lang["tipoOperacion"] ?></h6>
                    <p><?= $operationType->name ?></p>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-md-3">
                    <h6><?= $lang["precio"] ?></h6>
                    <p><?= $ad->price ?> €</p>
                </div>
                <div class="col-md-3">
                    <h6><?= $lang["habitaciones"] ?></h6>
                    <p><?= $ad->rooms ?> <?= $lang["unidad habitacion"] ?></p>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-md-3">
                    <h6><?= $lang["m2"] ?></h6>
                    <p><?= $ad->m_2 ?> m<sup>2</sup></p>
                </div>
                <div class="col-md-3">
                    <h6><?= $lang["baño"] ?></h6>
                    <p><?= $ad->bath ?> <?= $lang["unidad baño"] ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <h6><?= $lang["descripcion"] ?></h6>
                    <p><?php
                        if ($ad->description) {
                            echo $ad->description;
                        } else {
                            echo $lang['sinDescripcion'];
                        }
                        ?></p>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-md-3">
                    <h6><?= $lang["comunidad"] ?></h6>
                    <p><?= $community->community ?></p>
                </div>
                <div class="col-md-3">
                    <h6><?= $lang["provincia"] ?></h6>
                    <p><?= $province->province ?></p>
                </div>
                <div class="col-md-3">
                    <h6><?= $lang["localidad"] ?></h6>
                    <p><?= $municipality->municipality ?></p>
                </div>
            </div>
            <?php if (count($images) > 0) { ?>
                <div class="row justify-content-between">
                    <div class="col-md-3">
                        <button data-toggle="modal" data-target="#gallery" class="btn btn-primary"><i class="fa fa-images"></i> <?= $lang['fotos'] ?></button>
                        <div role="dialog" aria-labelledby="gallery" aria-hidden="true" tabindex="-1" id="gallery" class="modal fade">
                            <!-- Modal content-->
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content modal-gallery-content">
                                    <div class="modal-header modal-gallery-header">
                                        <button type="button" class="close" data-dismiss="modal" data-toggle="modal" aria-label="Close">
                                            <i class="fa fa-times fa-1x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div id="carouselControl" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner text-center">
                                                    <?php
                                                    $count = 0;
                                                    foreach ($images as $image) {
                                                        ?>
                                                        <div class="carousel-item <?php
                                                        if ($count == 0) {
                                                            echo 'active';
                                                        }
                                                        ?>">
                                                            <img src="<?= $image->image ?>" class="d-block w-100 zoom" alt="<?= $image->uuid ?>">
                                                        </div>
                                                        <?php
                                                        $count++;
                                                    }
                                                    ?>
                                                </div>
                                                <?php if (sizeof($images) > 1) {
                                                    ?>
                                                    <a class="carousel-control-prev" href="#carouselControl" role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#carouselControl" role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="col-sm-3">
            <ul class="list-group">
                <li class="list-group-item text-muted"><?= $lang['anunciante'] ?>: <a <?php if (verifySession()) { ?>href="<?php
                        echo $helper->url("user", "readUser", array("uuid" => "$user->uuid"));
                    }
                    ?>"><?= $user->name ?></a></li>
                <li class="list-group-item text-muted"><?= $lang['actions'] ?> <i class="fa fa-asterisk fa-1x"></i></li>
                <?php if (!$haveReportedAd && !$isSame && verifySession()) { ?>
                    <li class="list-group-item">
                        <span class="pull-left">
                            <strong><?= $lang['reportar'] ?></strong>
                        </span>
                        <span class="btn float-lg-right" data-toggle="tooltip" title="<?= $lang['reportar'] ?>">
                            <form method="post" action="<?= $helper->url("report", "createReport") ?>">
                                <input type="hidden" value="<?= REPORTS['AD'] ?>" name="report"  id="report"/>
                                <input type="hidden" value="<?= $ad->uuid ?>" name="uuid" id="uuid" />
                                <button type="submit" class="btn btn-warning"><i class="fa fa-exclamation-triangle "></i></button>
                            </form>
                        </span>
                    </li>
                <?php } ?>
                <?php
                if ((verifyIsAdmin() || $isSame) && $ad->state !== STATES["BLOQUEADO"]) {
                    ?>
                    <li class="list-group-item">
                        <span class="pull-left">
                            <strong><?= $lang['modificar'] ?></strong>
                        </span>
                        <span class="btn float-lg-right" data-toggle="tooltip" title="<?= $lang['modificar'] ?>">
                            <a href="<?php echo $helper->url("ad", "modifyView", array("uuid" => "$ad->uuid")); ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <span class="pull-left">
                            <strong><?= $lang['eliminar'] ?></strong>
                        </span>
                        <span class="btn float-lg-right" data-toggle="tooltip" title="<?= $lang['eliminar'] ?>">
                            <button type="button" data-toggle="modal" data-target="#remove" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-window-close "></i></button>
                        </span>
                    </li>
                    <div tabindex="-1" id="remove" class="modal fade">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?= $lang['eliminar anuncio'] ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?= $lang['estas seguro'] ?>
                                </div>
                                <div class="modal-footer">
                                    <a href="<?php echo $helper->url("ad", "remove", array("uuid" => "$ad->uuid")); ?>" class="btn btn-danger"><i class="fa fa-window-close"></i></a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
                if (verifyIsAdmin()) {
                    if ($ad->state !== STATES["BLOQUEADO"]) {
                        ?>
                        <li class="list-group-item">
                            <span class="pull-left">
                                <strong><?= $lang['bloquear'] ?></strong>
                            </span>
                            <span class="btn float-lg-right" data-toggle="tooltip" title="<?= $lang['bloquear'] ?>">
                                <button type="button" data-toggle="modal" data-target="#block" data-dismiss="modal" class="btn btn-warning"><i class="fa fa-ban"></i></button>
                            </span>
                        </li>
                        <div tabindex="-1" id="block" class="modal fade">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><?= $lang['bloquear anuncio'] ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?= $lang['estas seguro'] ?>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="<?php echo $helper->url("ad", "block", array("uuid" => "$ad->uuid")); ?>" class="btn btn-warning"><i class="fa fa-ban"></i></a>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $lang['cancelar'] ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else {
                        ?>
                        <li class="list-group-item">
                            <span class="pull-left">
                                <strong><?= $lang['desbloquear'] ?></strong>
                            </span>
                            <span class="btn float-lg-right" data-toggle="tooltip" title="<?= $lang['desbloquear'] ?>">
                                <a href="<?php echo $helper->url("ad", "unblock", array("uuid" => "$ad->uuid")); ?>" class="btn btn-success"><i class="fa fa-check"></i></a>
                            </span>
                        </li>
                        <?php
                    }
                }
                ?>
                <?php if ((verifySession() && !$hasUserRequest && !$isSame) && $ad->state !== STATES["BLOQUEADO"]) { ?>
                    <li class="list-group-item">
                        <span class="pull-left">
                            <strong><?= $lang['interesado'] ?></strong>
                        </span>
                        <span class="btn float-lg-right" data-toggle="tooltip" title="<?= $lang['contacto'] ?>">
                            <button data-toggle="modal" data-target="#request<?= $ad->uuid ?>" data-dismiss="modal" class="btn btn-success btn-sm"><i class="fa fa-comment-alt"></i></button>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <span class="pull-left">
                            <strong>Score</strong>
                        </span>
                        <div class="btn-group float-right">
                            <form action="<?= $helper->url("score", "score") ?>" method="post">
                                <input type="hidden" value="<?= $ad->uuid ?>" name="ad_uuid" />
                                <input type="hidden" value="<?= LIKES['LIKE'] ?>" name="score" />
                                <button class="btn btn-primary btn-sm <?= isset($isScored) && $userScore->score === LIKES['LIKE'] ? "active" : "" ?>"><i class="fa fa-thumbs-up"></i></button>
                            </form>
                            <form action="<?= $helper->url("score", "score") ?>" method="post">
                                <input type="hidden" value="<?= $ad->uuid ?>" name="ad_uuid" />
                                <input type="hidden" value="<?= LIKES['DISLIKE'] ?>" name="score" />
                                <button type="submit" class="btn btn-primary btn-sm <?= isset($isScored) && $userScore->score === LIKES['DISLIKE'] ? "active" : "" ?>"><i class="fa fa-thumbs-down fa-flip-horizontal"></i></button>
                            </form>
                        </div>
                    </li>
                    <div tabindex="-1" id="request<?= $ad->uuid ?>" class="modal fade" >
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?= $lang['contacto'] ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" data-toggle="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="<?= $helper->url("request", "createRequest") ?>" class="formUser">
                                    <div class="modal-body">
                                        <input type="hidden" name="ad_uuid" value="<?= $ad->uuid ?>" />
                                        <div class="form-group">
                                            <label for="content" class="col-form-label"><?= $lang["descripcion"] ?>:</label>
                                            <textarea class="form-control <?= isset($_GET['content']) ? " is-invalid" : "" ?>" id="content" name="content"></textarea>
                                            <div class="invalid-feedback">
                                                <?= isset($_GET['content']) ? $lang[$_GET['content']] : $lang['formato_incorrecto'] ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-comment-alt"></i></button>      
                                    </div>
                                </form>
                                <?php
                                if (isset($_GET['content'])) {
                                    ?>
                                    <script> $('#request<?= $ad->uuid ?>').modal('show');</script>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                } else if ($hasUserRequest) {
                    ?>
                    <div class="alert alert-info">
                        <?= $lang['peticion_existente'] ?>
                    </div>
                <?php } ?>
            </ul>
        </div>
    </div>
    <br>

    <?php
    if (isset($_SESSION["id"])) {
        ?>
        <div class="d-flex justify-content-between pb-2 mb-3 border-bottom">
            <h2 class="h5"><?= $lang["comentarios"] ?></h2>
        </div>
        <div class="row">
            <form class="col-md-12 col-sm-12 formUser" method="post" action="<?= $helper->url("comment", "createComment"); ?>">
                <div class="form-group">
                    <textarea name="comentario" class="form-control" placeholder="<?= $lang['escribir comentario'] ?>" id="insertComentario" rows="4"></textarea>
                    <input name="idAd" type="hidden" value="<?= $ad->id ?>">
                    <input name="uuidAd" type="hidden" value="<?= $ad->uuid ?>">                
                </div>
                <button type="submit" class="btn btn-success"><?= $lang["enviar"] ?></button>
            </form>
        </div>
        <br>
        <?php
    } else {
        ?>
        <div class="media text-center">
            <div class="card card-body media-body">
                <h5 class="mt-0"><a href="index/session/login"><?= $lang["inicie sesion"] ?></a></h5>
            </div>
        </div>
    <?php }
    ?>
    <br>
    <div id="listComentarios">     
        <div>
            <?php foreach ($comments as $result) { ?>
                <div class="media">
                    <div class="card card-body media-body">
                        <h5 class="mt-0"><a href="<?php echo $helper->url("user", "readUser", array("uuid" => "$result->uuid_user")); ?>"><?= $result->login ?></a></h5>
                        <?php if (!$result->denunciado) { ?>
                            <div class="float-lg-right">
                                <form method="post" action="<?= $helper->url("report", "createReport") ?>">
                                    <input type="hidden" value="<?= REPORTS['COMMENT'] ?>" name="report"  id="report"/>
                                    <input type="hidden" value="<?= $result->uuid ?>" name="uuid" id="uuid" />
                                    <button type="submit" class="btn btn-warning btn-sm float-lg-right"><i class="fa fa-exclamation-triangle "></i></button>
                                </form>
                            </div>
                        <?php } ?>
                        <p><?= $result->content ?></p>
                        <div class="container-fluid">
                            <small class="text-muted float-right"><?= to_time_ago(strtotime($result->timestamp), $lang) ?></small>                    
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <br>
    <div class="text-xs-center">
        <div class="text-center paginacionCommentsAd">
            <li pag="1" uuid="<?= $ad->uuid ?>" class="btn btn-info pagCommentAd"><i class="fa fa-plus "></i></li>   
            <input type="hidden" value="<?= $numComments ?>" id="numComments">
        </div>
    </div>
</section>