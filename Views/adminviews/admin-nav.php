<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm" style="border-bottom: 3px solid #007bff;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo FRONT_ROOT ?>Home/menuAdmin">
            <img src="<?= IMG_PATH ?>Lets.png" width="30" height="30" class="d-inline-block align-top" alt="">
            LETS WORK <span class="badge bg-primary ms-2" style="font-size: 0.7rem;">ADMIN PANEL</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navAdmin">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?= FRONT_ROOT ?>AdminCompany/showCompaniesViews">Companías</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Job Offers
                    </a>
                    <div class="dropdown-menu dropdown-menu-end"> <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>AdminJobOffer/showActiveJobOffers">
                            <i class="fas fa-check-circle text-success me-2"></i> Ofertas Activas 
                        </a>
                        
                        <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>AdminJobOffer/showExpiredJobOffers">
                            <i class="fas fa-times-circle text-danger me-2"></i> Ofertas Expiradas
                        </a>
                        
                        <div class="dropdown-divider"></div>
                        
                        <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>AdminJobOffer/showAddView">
                            <i class="fas fa-plus-square text-primary me-2"></i> Publicar Nuevas Ofertas
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= FRONT_ROOT ?>Admin/showStudentList">Estudiantes</a>
                </li>
                
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-danger btn-sm px-3 text-white" href="<?php echo FRONT_ROOT ?>Home/Logout">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>