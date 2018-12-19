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

        <!-- Bootstrap -->
        <link rel="stylesheet" href="view/assets/lib/bootstrap/css/bootstrap.min.css">

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
    </head>
    <body class="<?= $title ?>">
