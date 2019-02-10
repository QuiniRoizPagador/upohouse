<section class="jumbotron text-center"  style="z-index: 1;">
    <div class="container dropdown">
        <h1 class="jumbotron-heading">UpoHouse</h1>
        <br/>
        <div class="row dropdown" id="divSearch">
            <input type="text" class='form-control searcher' name="search" placeholder="<?= $lang['buscar'] ?>" /> 
            <div class="dropdown-menu" id="searchList">
            </div>
        </div>
    </div>
</section>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            <?php
            foreach ($ads as $result) {
                ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <a href="index/Ad/read&uuid=<?= $result->uuid ?>" class="text-center">
                            <picture>
                                <source srcset="<?= isset($result->thumbnail) ? $result->thumbnail : "view/images/home.png" ?>" type="image/svg+xml">
                                <img src="<?= isset($result->thumbnail) ? $result->thumbnail : "view/images/home.png" ?>" class="img-fluid img-thumbnail" alt="Card Image">
                            </picture>
                        </a>
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
    </div>
</div>