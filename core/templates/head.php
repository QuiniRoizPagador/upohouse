<?php
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    if (!empty($lang)) {
        $_SESSION['lang'] = $lang;
    }
}

if (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
    if (is_file("config/lang/$lang.php") && file_exists("config/lang/$lang.php")) {
        require_once "config/lang/$lang.php";
    } else {
        require_once 'config/lang/es.php';
    }
} else {
    require_once 'config/lang/es.php';
}

function to_time_ago($time) {

    $diff = time() - $time;

    if ($diff < 1) {
        return 'less than 1 second ago';
    }

    $time_rules = array(
        12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($time_rules as $secs => $str) {
        $div = $diff / $secs;

        if ($div >= 1) {
            $t = round($div);
            return $t . ' ' . $str .
                    ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}

function error($text) {
    echo "<div class='alert alert-danger alert-dismissible fade show col-md-2 content-center' role='alert'>
  <strong>Error!</strong> " . $text .
    "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}
?>


<!DOCTYPE HTML>
<html lang="es">
    <head>
        <!-- PRUEBAS -->
        <base href="//<?= $_SERVER['HTTP_HOST'] ?>/CorePHPMVC/">

        <?php /*
         * <!-- PRODUCCIÓN -->
         * <base href="//<?=$_SERVER['HTTP_HOST']?>"> 
         * 
         */ ?>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title ?></title>
        <link rel="icon" href="view/images/house.ico">
        <link rel="stylesheet" href="view/assets/lib/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="view/assets/css/product.css">
        <script src='view/assets/js/global.js'></script>
        <script src="view/assets/lib/jquery/jquery.min.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style>
            body{
                min-height: 100vh;
                position: relative;
                margin: 0;
            }
            .content-center{
                margin:0 auto;
            }
            .footer-absolute{
                position: absolute;
            }
            .footer{
                bottom: 0;
                width: 100%;
                padding: 2%;
            }
            @media (max-width: 575.98px){
                .footer-absolute{
                    position: relative;
                }
            }
            .resultado{
                text-decoration: none;  
                white-space: normal;
            }
            #searchList{
                display: none;
                width: 100%; 
            }
            #divSearch{
                display:flex;
                align-items: center;
                justify-content: center;
            }
            @media (min-width:992px) {
                .navbar-nav.navbar-center {
                    position: absolute;
                    left: 50%;
                    transform: translatex(-50%);
                }
                .navbar-nav.navbar-right {
                    position: absolute;
                    right: 0%;
                    transform: translatex(-50%);
                }
            }

        </style>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
        <script src="view/assets/js/charts.js"></script>
        <script src="view/assets/js/searcher.js"></script>
        <style>
            .jumbotron{
                background-image: url('view/images/jumbotron.jpg');
                background-repeat: no-repeat;
                background-size: cover;
                padding: 10rem 2rem;
                margin:0;
            }
            .site-header{
                background-color: inherit;
            }
            .site-header a{
                /* color:black;*/
            }
            .searcher {
                width: 130px;
                -webkit-transition: width 0.4s ease-in-out;
                transition: width 0.4s ease-in-out;
            }

            /* When the input field gets focus, change its width to 100% */
            .searcher:focus {
                width: 100%;
            }
        </style>
        <script>
            var base = "<?= $_SERVER['REQUEST_URI'] ?>";
<?php
$list = "";
foreach ($lang as $key => $value) {
    $list .= '\'' . $key . '\':\'' . $value . '\',' . "\n";
}
?>
            const LANG = {<?= $list ?>};
            (function ($) {
                $(document).ready(function () {
                    $('.list-inline li > a').click(function () {
                        var activeForm = $(this).attr('href') + ' > form';
                        //console.log(activeForm);
                        $(activeForm).addClass('animated fadeIn');
                        //set timer to 1 seconds, after that, unload the animate animation
                        setTimeout(function () {
                            $(activeForm).removeClass('animated fadeIn');
                        }, 1000);
                    });
                });
            })(jQuery);
        </script>

        <script>
<?php
if (isset($_GET['show'])) {
    switch ($_GET['show']) {
        case "comentarios":
            $count = $countComments;
            break;
        case "users":
        default:
            $count = $countRegistrations;
            break;
    }
} else {
    if (isset($countRegistrations)) {
        $count = $countRegistrations;
    }
}
if (isset($count)) {
    foreach ($count as $c) {
        $labels[] = $c->month . "/" . $c->year;
        $datasets[] = $c->count;
    }
    ?>
                var lb = [<?= '"' . implode('","', $labels) . '"' ?>]
                var ds = [<?= '"' . implode('","', $datasets) . '"' ?>]
<?php }
?>

        </script>
        <script src="view/assets/js/pagination.js"></script>
        <script src="view/assets/js/localization.js"></script>
        <script src="view/assets/js/validations.js"></script>
    </head>
    <body class="<?= $title ?>">
        <?php if (!verifyIsLogin()) { ?>
            <div data-backdrop="static" class="modal" id="lockModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>
