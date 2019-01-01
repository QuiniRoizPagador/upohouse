<section class="container py-5">
    <div class="pb-2 mb-3 border-bottom">
        <h2 class="h2"><?= $lang["añadir anuncio"] ?></h2>
    </div>
    <form action="<?php echo $helper->url("Ad", "create"); ?>" method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="housingType"><?= $lang["tipoCasa"] ?></label>
                <select class="form-control" id="housingType" name="housingType">
                    <?php foreach ($allHousingTypes as $housingType) { ?>
                        <option value="<?= $housingType['uuid']; ?>"><?= $housingType['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="operationType"><?= $lang["tipoOperacion"] ?></label>
                <select class="form-control" id="operationType" name="operationType">
                    <?php foreach ($allHousingTypes as $housingType) { ?>
                        <option value="<?= $operationType['uuid']; ?>"><?= $operationType['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="price"><?= $lang["precio"] ?></label>
                <input id="price" type="number" class="form-control" name="price" placeholder="<?= $lang["precio"] ?>">
            </div>
            <div class="form-group col-md-4">
                <label for="rooms"><?= $lang["habitaciones"] ?></label>
                <input id="rooms" type="number" class="form-control" name="rooms"  placeholder="<?= $lang["habitaciones"] ?>">
            </div>
            <div class="form-group col-md-4">
                <label for="m2"><?= $lang["m2"] ?></label>
                <input id="m2" type="number" class="form-control" name="m2"  placeholder="<?= $lang["m2Texto"] ?>">
            </div>            
        </div>
        <div class="form-group">
            <label for="images"><?= $lang["imagenes"] ?></label>
            <input id="images" type="file" multiple="multiple" class="form-control-file" name="images">
            <small id="imagesHelpBlock" class="form-text text-muted">
                <?= $lang["imagenesTextoAyuda"] ?>
            </small>
        </div>
        <div class="form-group">
            <label for="description"><?= $lang["descripcion"] ?></label>
            <textarea class="form-control" id="description" rows="3"></textarea>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="community"><?= $lang["comunidad"] ?></label>
                <select class="form-control" id="community" name="community">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="province"><?= $lang["provincia"] ?></label>
                <select class="form-control" id="province" name="province">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="municipality"><?= $lang["localidad"] ?></label>
                <select class="form-control" id="municipality" name="municipality">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success"><?= $lang["enviar"] ?></button>
    </form>
</section>
