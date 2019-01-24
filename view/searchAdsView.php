<?php
require_once 'core/templates/head.php';
require_once 'core/templates/nav.php';
?>  

<div class="container-fluid">
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                <?php
                foreach ($results as $result) {
                    ?>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <picture class="text-center">
                                <source srcset="<?= isset($result->thumbnail)?$result->thumbnail:"view/images/home.png" ?>" type="image/svg+xml">
                                <img src="<?= isset($result->thumbnail)?$result->thumbnail:"view/images/home.png" ?>" class="img-fluid img-thumbnail" alt="Card Image">
                            </picture>
                            <div class="card-body">
                                <p class="card-text">
                                    <?= $lang['precio'] . ": " . $result->price ?>
                                </p>
                                <p class="card-text">
                                    <?= $lang['habitaciones'] . ": " . $result->rooms ?>
                                </p>
                                <p class="card-text">
                                    <?= $lang['m2'] . ": " . $result->m_2 ?>
                                </p>
                                <p class="card-text">
                                    <?= $result->municipality . ", " . $result->province ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a type="button"  href="index/Ad/read&uuid=<?= $result->uuid ?>" class="btn btn-sm btn-outline-secondary"><i class="fa fa-eye"></i></a>
                                    </div>
                                    <small class="text-muted"><?= to_time_ago(strtotime($result->timestamp), $lang) ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <a class="page-link" href="index/Ad/paginate&query=<?= $query ?>&pag=<?= $i ?>"><?= $i + 1 ?></a>
                        </li>
                    <?php }
                    ?> 
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
require_once "core/templates/footer.php";
?>