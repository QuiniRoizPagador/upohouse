<?php
require_once 'core/templates/head.php';
require_once 'core/templates/nav.php';
$_house = null;
$_operation = null;
$_pag = 0;
if (filter_has_var(INPUT_GET, "type_house") && trim($_GET['type_house']) != "") {
    $_house = filter_var($_GET['type_house'], FILTER_SANITIZE_STRING);
}
if (filter_has_var(INPUT_GET, "type_operation") && trim($_GET['type_operation']) != "") {
    $_operation = filter_var($_GET['type_operation'], FILTER_SANITIZE_STRING);
}
if (filter_has_var(INPUT_GET, 'pag') && trim($_GET['pag']) != "") {
    $_pag = filter_var($_GET['pag'], FILTER_SANITIZE_NUMBER_INT);
}

?>
<div class="row col-md-12">
    <nav class="col-md-2 d-md-block sidebar">
        <div class="container">
            <h3><?= $lang['filtros'] ?></h3>

            <div class = "sidebar-sticky">
                <h6 class = "sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span><?= $lang['tipoOperacion'] ?></span>
                    <a class="d-flex align-items-center text-muted" href="#">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column">
                    <?php
                    foreach ($operations as $operation) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo $helper->url("Ad", "listAds", array("type_operation" => $_operation != $operation->uuid ? $operation->uuid : null, "type_house" => $_house, "pag" => 0)); ?>">
                                <?= $_operation == $operation->uuid ? "<i class='fa fa-arrow-alt-circle-right'></i>" : "<i class='fa fa-circle'></i>" ?>
                                <?= $operation->name ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span><?= $lang['tipoCasa'] ?></span>
                    <a class="d-flex align-items-center text-muted" href="#">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column">
                    <?php
                    foreach ($houses as $house) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo $helper->url("Ad", "listAds", array("type_house" => $_house != $house->uuid ? $house->uuid : null, "type_operation" => $_operation, "pag" => 0)); ?>">
                                <?= $_house == $house->uuid ? "<i class='fa fa-arrow-alt-circle-right'></i>" : "<i class='fa fa-circle'></i>" ?>
                                <?= $house->name ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>

            </div>
        </div>
    </nav>
    <main class="col-md-10 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="container-fluid">
            <div class="float-lg-right">
                <?= $_pag * 10 + 1 ?>-<?= $_pag * 10 + sizeof($results) ?>/<?= $countList ?>
            </div>
            <?php
            foreach ($results as $result) {
                ?>
                <div class="media">
                    <picture class="align-self-center mr-3">
                        <source srcset="<?= isset($result->image) ? $result->image : "view/images/home.png" ?>" type="image/svg+xml">
                        <img src="<?= isset($result->image) ? $result->image : "view/images/home.png" ?>" class="img-fluid img-thumbnail" alt="Card Image">
                    </picture>
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
                </div>
                <hr />
                <?php
            }
            ?>
        </div>
        <div class="text-xs-center">
            <ul class="pagination pagination-sm justify-content-center">
                <?php
                for ($i = 0; $i < $countList / 10; $i++) {
                    ?>
                    <li class="page-item <?= $pag == $i ? "active" : "" ?>">
                        <a class="page-link" href="<?php echo $helper->url("Ad", "listAds", array("type_house" => $_house, "type_operation" => $_operation, "pag" => $i)); ?>"><?= $i + 1 ?></a>
                    </li>
                <?php }
                ?> 
            </ul>
        </div>
    </main>
</div>
<?php
require_once "core/templates/footer.php";
?>