<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo FRONT_ROOT ?>Company/dashboard">
            <img src="<?= IMG_PATH ?>Lets.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
            LETS WORK <span class="badge bg-info text-dark ms-2" style="font-size: 0.7rem;">COMPAÑÍA</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navCompany" aria-controls="navCompany" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navCompany">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?php echo FRONT_ROOT ?>CompanyJobOffer/listMyOffers">
                        <i class="fas fa-list-ul me-1 small"></i> Mis Ofertas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?php echo FRONT_ROOT ?>Company/profile">
                        <i class="fas fa-building me-1 small"></i> Perfil
                    </a>
                </li>
                
                <li class="nav-item ms-lg-3 ps-lg-3 border-start border-secondary">
                    <a class="btn btn-outline-light btn-sm px-3 ms-lg-2" href="<?php echo FRONT_ROOT ?>Home/logout">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>