<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?php echo FRONT_ROOT ?>Company/dashboard">
            <img src="<?= IMG_PATH ?>Lets.png" width="30" height="30" class="d-inline-block align-top" alt="">
            <strong>LETS WORK</strong> <span class="badge badge-info">Compañía</span>
        </a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT ?>CompanyJobOffer/listMyOffers">Mis Ofertas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT ?>Company/profile">Perfil</a>
                </li>
                <li class="nav-item ml-lg-3">
                    <a class="btn btn-outline-light btn-sm ml-lg-3" href="<?php echo FRONT_ROOT ?>Home/Logout">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>