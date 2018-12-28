<nav class="col-md-2 d-none d-md-block sidebar">
    <div class="sidebar-sticky">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Gesti&oacute;n</span>
            <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?=isset($isUsers)?"active":""?>" href="<?php echo $helper->url("Admin", "dashboard"); ?>&show=users">
                    <i class="fa fa-users"></i>
                    Usuarios 
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=isset($isAnuncios)?"active":""?>" href="<?php echo $helper->url("Admin", "dashboard"); ?>&show=anuncios">
                    <i class="fa fa-address-book"></i>
                    Anuncios 
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=isset($iscomentarios)?"active":""?>" href="<?php echo $helper->url("Admin", "dashboard"); ?>&show=comentarios">
                    <i class="fa fa-comment"></i>
                    Comentarios 
                </a>
            </li>
             <li class="nav-item">
                <a class="nav-link <?=isset($isTipos)?"active":""?>" href="<?php echo $helper->url("Admin", "dashboard"); ?>&show=tipos">
                    <i class="fa fa-list"></i>
                    Tipos 
                </a>
            </li>
        </ul>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Incidencias</span>
            <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?=isset($isDenuncias)?"active":""?>" href="<?php echo $helper->url("Admin", "dashboard"); ?>&show=denuncias">
                    <i class="fa fa-asterisk"></i>
                    Denuncias 
                </a>
            </li>
        </ul>
    </div>
</nav>