<?php
require_once 'core/templates/head.php';
?>

<div class="bg-light" id="wrap">
    <div id="top">
        <?php require_once 'core/templates/nav.php' ?>  
    </div>
    <div class="container-fluid bg-light">
        <div class="container-fluid content-center">
            <div class="col-sm-6  content-center"><h1><?= $lang['crear_denuncia'] ?></h1></div>
        </div>
        <hr />
        <div class="col-md-12 ">
            <?php
            switch ($report) {
                case REPORTS['REQUEST']:
                    $url = $helper->url("report", "reportRequest");
                    break;
                case REPORTS['USER']:
                    $url = $helper->url("report", "reportUser");
                    break;
                case REPORTS['COMMENT']:
                    $url = $helper->url("report", "reportComment");
                    break;
                case REPORTS['AD']:
                    $url = $helper->url("report", "reportAd");
                    break;
            }
            ?>
            <form method="post" action="<?= $url ?>" class="form">
                <div class="form-control col-md-6 content-center has-success">
                    <input type="hidden" value="<?= $_POST['uuid'] ?>" name="uuid" id="uuid" />
                    <label for="title" class="col-form-label"><?= $lang["titulo"] ?>:</label>
                    <input type="text" class="form-control" name="title" id="title" />
                    <div class="invalid-feedback">
                        <?= isset($_GET['title']) ? $lang[$_GET['title']] : $lang['formato_incorrecto'] ?>
                    </div>
                    <label for="description" class="col-form-label"><?= $lang["descripcion"] ?>:</label>
                    <textarea class="form-control <?= isset($_GET['content']) ? " is-invalid" : "" ?>" id="description" name="description"></textarea>
                    <div class="invalid-feedback">
                        <?= isset($_GET['content']) ? $lang[$_GET['content']] : $lang['formato_incorrecto'] ?>
                    </div>
                    <hr />
                    <div class="container-fluid text-right">
                        <button type="submit" class="btn btn-warning"><i class="fa fa-exclamation-triangle"></i></button>      
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<?php
require_once "core/templates/footer.php";
?>