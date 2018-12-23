<?php

function error($text) {
    echo "<div class='alert alert-danger'>"
    . "<strong>Error!</strong> $text"
    . "</div>";
}
?>


<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title><?php echo $title ?></title>
        <link rel = "stylesheet" href = "view/assets/lib/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <?php if (!verifyIsLogin()) { ?>
            <!--Bootstrap -->

            <link rel = "stylesheet" href = "view/assets/css/product.css">

            <!--Bootstrap core JavaScript === === === === === === === === === === === === === === === === == -->
            <!--Placed at the end of the document so the pages load faster -->
            <script src="view/assets/lib/jquery/jquery.min.js"></script>

            <!--Bootstrap -->
            <script src="view/assets/lib/bootstrap/js/bootstrap.min.js"></script>

        <?php } else { ?>
            <!-- Font Awesome -->
            <!--<link rel="stylesheet" href="view/assets/lib/font-awesome/css/font-awesome.css">-->
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

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
            <!--jQuery -->
            <script src="view/assets/lib/jquery/jquery.min.js"></script>

            <!--Bootstrap -->
            <script src="view/assets/lib/bootstrap/js/bootstrap.min.js"></script>


            <script type="text/javascript">
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
        <?php } ?>
        <style>
            .jumbotron{
                background-image: url('https://proxy.duckduckgo.com/iu/?u=https%3A%2F%2Fsavannahrealestate.com%2Fwp-content%2Fuploads%2F2014%2F06%2Fhome.jpg&f=1');
                background-repeat: no-repeat;
                background-size: 100%;
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

    </head>
    <body class="<?= $title ?>">
