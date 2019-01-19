<section class="container py-5">
    <div class="pb-2 mb-3 border-bottom">
        <h2 class="h2"><?= $lang["anuncio"] ?></h2>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h6><?= $lang["tipoCasa"] ?></h6>
                <p><?= $housingType->name?></p>
            </div>
            <div class="col-md-6">
                <h6><?= $lang["tipoOperacion"] ?></h6>
                <p><?= $operationType->name?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <h6><?= $lang["precio"] ?></h6>
                <p><?= $ad->price?></p>
            </div>
            <div class="col-md-3">
                <h6><?= $lang["habitaciones"] ?></h6>
                <p><?= $ad->rooms?></p>
            </div>
            <div class="col-md-3">
                <h6><?= $lang["m2"] ?></h6>
                <p><?= $ad->m_2?></p>
            </div>
            <div class="col-md-3">
                <h6><?= $lang["baño"] ?></h6>
                <p><?= $ad->bath?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <h6><?= $lang["descripcion"] ?></h6>
                <p><?php if ($ad->description) { echo $ad->description; } else { echo $lang['sinDescripcion']; }?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h6><?= $lang["comunidad"] ?></h6>
                <p><?= $community->community?></p>
            </div>
            <div class="col-md-4">
                <h6><?= $lang["provincia"] ?></h6>
                <p><?= $province->province?></p>
            </div>
            <div class="col-md-4">
                <h6><?= $lang["localidad"] ?></h6>
                <p><?= $municipality->municipality?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md text-center">
                <a href="#" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <a href="<?php echo $helper->url("ad", "remove", array("uuid" => "$ad->uuid")); ?>" class="btn btn-danger"><i class="fa fa-window-close"></i></a>
                <a href="<?php echo $helper->url("ad", "block", array("uuid" => "$ad->uuid")); ?>" class="btn btn-warning"><i class="fa fa-ban"></i></a>
            </div>
        </div>
    </div>
</section>
