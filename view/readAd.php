<section class="container py-5">
    <div class="d-flex justify-content-between pb-2 mb-3 border-bottom">
        <h2 class="h2"><?= $lang["anuncio"] ?></h2>
        <div>
            <a href="<?php echo $helper->url("ad", "modifyView", array("uuid" => "$ad->uuid")); ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
            <a href="<?php echo $helper->url("ad", "remove", array("uuid" => "$ad->uuid")); ?>" class="btn btn-danger"><i class="fa fa-window-close"></i></a>
            <a href="<?php echo $helper->url("ad", "block", array("uuid" => "$ad->uuid")); ?>" class="btn btn-warning"><i class="fa fa-ban"></i></a>
        </div>
    </div>
    <div class="container-fluid">
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
        <div class="row justify-content-between">
            <div class="col-md-3">
                <button data-toggle="modal" data-target="#gallery" class="btn btn-primary"><i class="fa fa-images"></i> <?= $lang['fotos'] ?></button>
                <div role="dialog" aria-labelledby="gallery" aria-hidden="true" tabindex="-1" id="gallery" class="modal fade">
                    <!-- Modal content-->
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-gallery-content">
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
        <br>
        <div class="d-flex justify-content-between pb-2 mb-3 border-bottom">
            <h2 class="h5"><?= $lang["comentarios"] ?></h2>
        </div>
        <div class="row">
            <form class="col-md-12 col-sm-12">
                <div class="form-group" method="post" action="<?= $helper->url("comment", "createComment"); ?>">

                    <textarea name="comentario" class="form-control" placeholder="<?= $lang['escribir comentario'] ?>" id="insertComentario" rows="4"></textarea>
                    <input name="idAd" type="hidden" value="<?= $ad->id ?>">
                    <input name="idUser" type="hidden" value="<?= $_SESSION['id'] ?>">                 



                </div>
                <button type="submit" class="btn btn-success">Enviar</button>
            </form>
        </div>

        <div>
            <!--      <div class="media">
                      <div class="media-body">
                          <h5 class="mt-0"><?= $result->title ?></h5>
                          <p>
            <?= $lang['precio'] . ": " . $result->price ?>
            <?= $lang['habitaciones'] . ": " . $result->rooms ?>
            <?= $lang['m2'] . ": " . $result->m_2 ?>
            <?= $result->municipality . ", " . $result->province ?>
                          </p>
                          <p><?= $result->description ?></p>
                          <a type="button"  href="index/Ad/read&uuid=<?= $result->uuid ?>" class="btn btn-sm btn-outline-secondary"><i class="fa fa-eye"></i></a>
                          <small class="text-muted float-lg-right"><?= to_time_ago(strtotime($result->timestamp), $lang) ?></small>
                      </div>
                  </div>-->



        </div>
    </div>
</section>
