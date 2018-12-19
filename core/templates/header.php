<header class="navbar">
    <!--<div class="search-bar">
        <form class="main-search" action="">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Live Search ...">
                <span class="input-group-btn">
                    <button class="btn btn-primary btn-sm text-muted" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
</div>-->

    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container-fluid">


            <!-- Brand and toggle get grouped for better mobile display -->
            <header class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="<?= $helper->url("user", "index") ?>" class="navbar-brand"><img src="view/assets/img/logo.png" alt=""></a>

            </header>

            <div class="collapse navbar-collapse navbar-ex1-collapse">

                <!-- .nav -->
                <ul class="nav navbar-nav">
                    <li><a href="<?= $helper->url("user", "index") ?>">Dashboard</a></li>
                    <!--<li><a href="<?= $helper->url("user", "index") ?>">Admin</a></li>-->
                    <!--<li class='dropdown '>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Admin <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= $helper->url("user", "index") ?>">Admin</a></li>
                        </ul>
                    </li>-->
                </ul>
                <!-- /.nav -->


                <!-- .nav -->
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo $helper->url("Session", "logout"); ?>">Logout</a></li>
                    
                </ul>
                <!-- /.nav -->
            </div>

        </div>
        <!-- /.container-fluid -->
    </nav>



    <!-- /.main-bar -->
</header>
<!-- /.head -->

