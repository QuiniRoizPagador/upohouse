<section class="container py-5">
    <div class="pb-2 mb-3 border-bottom">
        <h2 class="h2"><?= $lang["añadir anuncio"] ?></h2>
    </div>
    <form action="<?php echo $helper->url("Ad", "create"); ?>" method="post" enctype="multipart/form-data">
        <?php
        if (isset($errors['create']['query'])) {
            ?>
            <div class="alert alert-danger">
                <?= $errors['create']['query'] ?>
            </div>
            <?php
        }
        if (isset($success)) {
            ?>
            <div class="alert alert-success">
                <?= $lang["anuncioCreado"] ?>
            </div>
            <?php
        }
        ?>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="housingType"><?= $lang["tipoCasa"] ?></label>
                <select class="form-control <?= isset($errors['create']['housingType']) ? " is-invalid" : "" ?>" id="housingType" name="housingType">
                    <?php foreach ($allHousingTypes as $housingType) { ?>
                        <option value="<?= $housingType->uuid; ?>"><?= $housingType->name; ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                    <?= isset($errors['create']['housingType']) ? $lang[$errors['create']['housingType']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="operationType"><?= $lang["tipoOperacion"] ?></label>
                <select class="form-control <?= isset($errors['create']['operationType']) ? " is-invalid" : "" ?>" id="operationType" name="operationType">
                    <?php foreach ($allOperationTypes as $operationType) { ?>
                        <option value="<?= $operationType->uuid; ?>"><?= $operationType->name; ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                    <?= isset($errors['create']['operationType']) ? $lang[$errors['create']['operationType']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="price"><?= $lang["precio"] ?></label>
                <input id="price" type="number" step=".01" class="form-control <?= isset($errors['create']['price']) ? " is-invalid" : "" ?>" name="price" placeholder="<?= $lang["precio"] ?>">
                <div class="invalid-feedback">
                    <?= isset($errors['create']['price']) ? $lang[$errors['create']['price']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label for="rooms"><?= $lang["habitaciones"] ?></label>
                <input id="rooms" type="number" class="form-control <?= isset($errors['create']['rooms']) ? " is-invalid" : "" ?>" name="rooms"  placeholder="<?= $lang["habitaciones"] ?>">
                <div class="invalid-feedback">
                    <?= isset($errors['create']['rooms']) ? $lang[$errors['create']['rooms']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label for="m2"><?= $lang["m2"] ?></label>
                <input id="m2" type="number" class="form-control <?= isset($errors['create']['m2']) ? " is-invalid" : "" ?>" name="m2"  placeholder="<?= $lang["m2Texto"] ?>">
                <div class="invalid-feedback">
                    <?= isset($errors['create']['m2']) ? $lang[$errors['create']['m2']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label for="bath"><?= $lang["baño"] ?></label>
                <input id="bath" type="number" class="form-control <?= isset($errors['create']['bath']) ? " is-invalid" : "" ?>" name="bath"  placeholder="<?= $lang["baño"] ?>">
                <div class="invalid-feedback">
                    <?= isset($errors['create']['bath']) ? $lang[$errors['create']['bath']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>             
        </div>
        <div class="form-group">
            <label for="images"><?= $lang["imagenes"] ?></label>
            <input id="images" type="file" multiple class="form-control-file <?= isset($errors['create']['images']) ? " is-invalid" : "" ?>" name="images[]">
            <small id="imagesHelpBlock" class="form-text text-muted">
                <?= $lang["imagenesTextoAyuda"] ?>
            </small>
            <div class="invalid-feedback">
                <?= isset($errors["create"]["images"]) ? $lang[$errors['create']['images']] : $lang['formato_incorrecto'] ?>
            </div>
        </div>
        <div class="form-group">
            <label for="description"><?= $lang["descripcion"] ?></label>
            <textarea class="form-control <?= isset($errors['create']['description']) ? " is-invalid" : "" ?>" id="description" name="description" rows="3"></textarea>
            <div class="invalid-feedback">
                <?= isset($errors['create']['description']) ? $lang[$errors['create']['description']] : $lang['formato_incorrecto'] ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="community"><?= $lang["comunidad"] ?></label>
                <select class="form-control <?= isset($errors['create']['community']) ? " is-invalid" : "" ?>" id="community" name="community">
                    <option selected="selected"><?= $lang["eligeComunidad"] ?></option>
                    <?php foreach ($allCommunities as $community) { ?>
                        <option value="<?= $community->id; ?>"><?= $community->community; ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                    <?= isset($errors['create']['community']) ? $lang[$errors['create']['community']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="province"><?= $lang["provincia"] ?></label>
                <select class="form-control <?= isset($errors['create']['province']) ? " is-invalid" : "" ?>" id="province" name="province" disabled="disabled">
                    <option selected="selected"><?= $lang["eligeProvincia"] ?></option>
                </select>
                <div class="invalid-feedback">
                    <?= isset($errors['create']['province']) ? $lang[$errors['create']['province']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="municipality"><?= $lang["localidad"] ?></label>
                <select class="form-control <?= isset($errors['create']['municipality']) ? " is-invalid" : "" ?>" id="municipality" name="municipality" disabled="disabled">
                    <option selected="selected"><?= $lang["eligeMunicipio"] ?></option>
                </select>
                <div class="invalid-feedback">
                    <?= isset($errors['create']['municipality']) ? $lang[$errors['create']['municipality']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success"><?= $lang["enviar"] ?></button>
    </form>
</section>
