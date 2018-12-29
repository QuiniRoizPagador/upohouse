<?php

function error($text) {
    echo "<div class='alert alert-danger'>"
    . "<strong>Error!</strong> $text"
    . "</div>";
}

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
?>


<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title><?php echo $title ?></title>
        <link rel = "stylesheet" href = "view/assets/lib/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="view/assets/lib/jquery/jquery.min.js"></script>
        <?php if (!verifyIsLogin()) { ?>
            <!--Bootstrap -->

            <link rel = "stylesheet" href = "view/assets/css/product.css">



        <?php } else { ?>
            <!-- Font Awesome -->

            <!-- Metis core stylesheet -->
            <link rel="stylesheet" href="view/assets/css/main.rtl.css">

            <!-- metisMenu stylesheet -->
            <link rel="stylesheet" href="view/assets/lib/metismenu/metisMenu.css">

            <!-- onoffcanvas stylesheet -->
            <link rel="stylesheet" href="view/assets/lib/onoffcanvas/onoffcanvas.min.css">

            <!-- animate.css stylesheet -->
            <link rel="stylesheet" href="view/assets/lib/animate.css/animate.min.css">

            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->



        <?php } ?>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
        <script src="view/assets/js/charts.js"></script>

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
        <script type="text/javascript">
            var base = "<?=$_SERVER['REQUEST_URI']?>";
            
            
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
        <script type="text/javascript">
            $(document).ready(function () {
                /*$(".searcher").blur(function () {
                 $(".searcher").val("");
                 var lista = $("#searchList");
                 lista.empty();
                 });*/
                $(".searcher").keyup(function () {
                    var lista = $("#searchList");
                    lista.empty();
                    $.post("<?= $helper->url("WebService", "prueba"); ?>", {nombre: $(".searcher").val()}).done(function (data) {
                        if (data !== "" && data !== null) {
                            $.map($.parseJSON(data), function (k, v) {
                                lista.append("<li class='list-group-item' style='width:50em; text-align:left;'> "
                                        + "<a href='<?php echo $helper->url("User", "index"); ?>' class='text-muted'>"
                                        + k.id + "-" + k.nombre +
                                        "</a></li>");
                            });
                        }
                    });
                });
            });
        </script>
        <script type="text/javascript">
<?php
foreach ($allusers as $user) {
    $labels[] = $user->login;
    $datasets[] = date('ms', strtotime($user->timestamp));
}
?>
            var lb = [<?= '"' . implode('","', $labels) . '"' ?>]
            var ds = [<?= '"' . implode('","', $datasets) . '"' ?>]
        </script>
        <script src="view/assets/js/pagination.js"></script>
    </head>
    <body class="<?= $title ?>">
