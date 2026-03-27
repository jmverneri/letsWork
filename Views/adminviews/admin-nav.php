<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm" style="border-bottom: 3px solid #007bff;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo FRONT_ROOT ?>Home/menuAdmin">
            <img src="<?= IMG_PATH ?>Lets.png" width="30" height="30" class="d-inline-block align-top" alt="">
            LETS WORK <span class="badge badge-primary ml-2" style="font-size: 0.7rem;">ADMIN PANEL</span>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navAdmin">
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?= FRONT_ROOT ?>AdminCompany/showCompaniesViews">Companías</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                        Job Offers
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>AdminJobOffer/showActiveJobOffers">
                            <i class="fas fa-check-circle text-success"></i> Ofertas Activas 
                        </a>
                        
                        <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>AdminJobOffer/showExpiredJobOffers">
                            <i class="fas fa-times-circle text-danger"></i> Ofertas Expiradas
                        </a>
                        
                        <div class="dropdown-divider"></div>
                        
                        <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>AdminJobOffer/showAddView">
                            <i class="fas fa-plus-square text-primary"></i> Publicar Nuevas Ofertas
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= FRONT_ROOT ?>Admin/showStudentList">Estudiantes</a>
                </li>
                <li class="nav-item ml-lg-3">
                    <a class="btn btn-danger btn-sm px-3" href="<?php echo FRONT_ROOT ?>Home/Logout">Cerrar Cesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>