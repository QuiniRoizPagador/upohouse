<section class="container py-5">
    <div class="pb-2 mb-3 border-bottom">
        <h2 class="h2"><?= $lang["modificar anuncio"] ?></h2>
    </div>
    <form class="formUpdateUser" action="<?php echo $helper->url("Ad", "modify", array('uuid' => $ad->uuid)); ?>" method="post" enctype="multipart/form-data">
        <?php
        if (isset($errors['modify']['query'])) {
            ?>
            <div class="alert alert-danger">
                <?= $errors['modify']['query'] ?>
            </div>
            <?php
        }
        if (isset($success)) {
            ?>
            <div class="alert alert-success">
                <?= $lang["anuncioModificado"] ?>
            </div>
            <?php
        }
        ?>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="housingType"><?= $lang["tipoCasa"] ?></label>
                <select class="form-control <?= isset($errors['modify']['housingType']) ? " is-invalid" : "" ?>" id="housingType" name="housingType">
                    <?php foreach ($allHousingTypes as $housingType) { ?>
                        <option value="<?= $housingType->uuid; ?>" <?= $ad->housing_type == $housingType->id ? " selected='selected'" : ""?>><?= $housingType->name; ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                    <?= isset($errors['modify']['housingType']) ? $lang[$errors['modify']['housingType']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="operationType"><?= $lang["tipoOperacion"] ?></label>
                <select class="form-control <?= isset($errors['modify']['operationType']) ? " is-invalid" : "" ?>" id="operationType" name="operationType">
                    <?php foreach ($allOperationTypes as $operationType) { ?>
                        <option value="<?= $operationType->uuid; ?>" <?= $ad->operation_type == $operationType->id ? " selected='selected'" : ""?>><?= $operationType->name; ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                    <?= isset($errors['modify']['operationType']) ? $lang[$errors['modify']['operationType']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="price"><?= $lang["precio"] ?></label>
                <input id="price" value="<?= $ad->price?>" type="number" step=".01" class="form-control <?= isset($errors['modify']['price']) ? " is-invalid" : "" ?>" name="price" placeholder="<?= $lang["precio"] ?>">
                <div class="invalid-feedback">
                    <?= isset($errors['modify']['price']) ? $lang[$errors['modify']['price']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label for="rooms"><?= $lang["habitaciones"] ?></label>
                <input id="rooms" value="<?= $ad->rooms?>" type="number" class="form-control <?= isset($errors['modify']['rooms']) ? " is-invalid" : "" ?>" name="rooms"  placeholder="<?= $lang["habitaciones"] ?>">
                <div class="invalid-feedback">
                    <?= isset($errors['modify']['rooms']) ? $lang[$errors['modify']['rooms']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label for="m2"><?= $lang["m2"] ?></label>
                <input id="m2" value="<?= $ad->m_2?>" type="number" class="form-control <?= isset($errors['modify']['m2']) ? " is-invalid" : "" ?>" name="m2"  placeholder="<?= $lang["m2Texto"] ?>">
                <div class="invalid-feedback">
                    <?= isset($errors['modify']['m2']) ? $lang[$errors['modify']['m2']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label for="bath"><?= $lang["baño"] ?></label>
                <input id="bath" value="<?= $ad->bath?>" type="number" class="form-control <?= isset($errors['modify']['bath']) ? " is-invalid" : "" ?>" name="bath"  placeholder="<?= $lang["baño"] ?>">
                <div class="invalid-feedback">
                    <?= isset($errors['modify']['bath']) ? $lang[$errors['modify']['bath']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>             
        </div>
        <div class="form-group">
            <label for="images"><?= $lang["imagenes"] ?></label>
            <input id="images" type="file" multiple class="form-control-file" name="images[]">
            <small id="imagesHelpBlock" class="form-text text-muted">
                <?= $lang["imagenesTextoAyuda"] ?>
            </small>
            <?php if (isset($errors['modify']['images'])) { ?>
                <div style="color:#dc3545;font-size:80%">
                    <?= isset($errors["modify"]["images"]) ? $lang[$errors['modify']['images']] : $lang['formato_incorrecto'] ?>
                </div>
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="description"><?= $lang["descripcion"] ?></label>
            <textarea class="form-control <?= isset($errors['create']['description']) ? " is-invalid" : "" ?>" id="description" name="description" rows="3"><?= $ad->description ?></textarea>
            <div class="invalid-feedback">
                <?= isset($errors['modify']['description']) ? $lang[$errors['modify']['description']] : $lang['formato_incorrecto'] ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="community"><?= $lang["comunidad"] ?></label>
                <select class="form-control <?= isset($errors['modify']['community']) ? " is-invalid" : "" ?>" id="community" name="community">
                    <option selected="selected"><?= $lang["eligeComunidad"] ?></option>
                    <?php foreach ($allCommunities as $community) { ?>
                        <option value="<?= $community->id; ?>"><?= $community->community; ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                    <?= isset($errors['modify']['community']) ? $lang[$errors['modify']['community']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="province"><?= $lang["provincia"] ?></label>
                <select class="form-control <?= isset($errors['modify']['province']) ? " is-invalid" : "" ?>" id="province" name="province" disabled="disabled">
                    <option selected="selected"><?= $lang["eligeProvincia"] ?></option>
                </select>
                <div class="invalid-feedback">
                    <?= isset($errors['modify']['province']) ? $lang[$errors['modify']['province']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="municipality"><?= $lang["localidad"] ?></label>
                <select class="form-control <?= isset($errors['modify']['municipality']) ? " is-invalid" : "" ?>" id="municipality" name="municipality" disabled="disabled">
                    <option selected="selected"><?= $lang["eligeMunicipio"] ?></option>
                </select>
                <div class="invalid-feedback">
                    <?= isset($errors['modify']['municipality']) ? $lang[$errors['modify']['municipality']] : $lang['formato_incorrecto'] ?>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success"><?= $lang["enviar"] ?></button>
    </form>
</section>
