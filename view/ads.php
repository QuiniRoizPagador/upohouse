<div class="row">
    <?php
    require_once 'core/templates/lateral.php';
    ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 bg-light">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $lang["anuncios"] ?></h1>
        </div>
        <div class="alert alert-light col-md-3 float-lg-right text-right">
            <span class="badge  badge-pill badge-light"><?= $lang['NEUTRO'] ?></span>
            <span class="badge  badge-pill badge-warning"><?= $lang['BLOQUEADO'] ?></span>
        </div>
        <div class="table-responsive">
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>UUID</th>
                        <th><?= $lang['precio'] ?> </th>
                        <th><?= $lang['fecha registro'] ?></th>
                        <th>Ver</th>
                    </tr>
                </thead>
                <tbody id="cuerpo">
                    <?php foreach ($allAds as $ad) { //recorremos el array de objetos y obtenemos el valor de las propiedades    ?>
                        <?php
                        $class = "";
                        if ($ad->state == STATES['BLOQUEADO']) {
                            $class = "table-warning";
                        }
                        ?>
                        <tr>
                            <td class="<?= $class ?>"><?= $ad->id; ?> </td>
                            <td class="<?= $class ?>"><?= $ad->uuid; ?> </td>
                            <td class="<?= $class ?>"><?= $ad->price; ?> </td>
                            <td class="<?= $class ?>"><?= $ad->timestamp; ?> </td>
                            <td class="<?= $class ?>">
                                <a href="#" class="btn btn-info btn-sm">
                                    <span class="fa fa-eye"></span>
                                </a>                  
                            </td>
                        </tr>
                    <?php } ?>
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
                    for ($i = 0; $i < $numAds / 10; $i++) {
                        ?>
                        <li class="page-item <?= $i == 0 ? "active" : "" ?>">
                            <a class="page-link pagAd"><?= $i + 1 ?></a>
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