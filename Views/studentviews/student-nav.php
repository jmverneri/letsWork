<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo FRONT_ROOT ?>Home/menuStudent">
            <img src="<?= IMG_PATH ?>Lets.png" width="30" height="30" class="d-inline-block align-top" alt="">
            LETS WORK <span class="badge bg-warning text-dark ms-2" style="font-size: 0.7rem;">ESTUDIANTE</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navStudent" aria-controls="navStudent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navStudent">
            <ul class="navbar-nav ms-auto align-items-center">
                
                <li class="nav-item dropdown">
                    <a class="nav-link position-relative px-3" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span style="font-size: 1.1rem;">🔔</span>
                        <?php 
                        $displayCant = $_SESSION['cantNotif'] ?? 0;
                        if($displayCant > 0) { ?>
                            <span class="position-absolute badge rounded-pill bg-danger" 
                                  style="top: 5px; right: 5px; font-size: 0.65rem; padding: 0.25em 0.5em;">
                                <?php echo $displayCant; ?>
                            </span>
                        <?php } ?>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="notificationDropdown" style="min-width: 280px; border-radius: 10px;">
                        <li><h6 class="dropdown-header fw-bold text-dark">Notificaciones Recientes</h6></li>
                        
                        <?php 
                        // Recuperamos la lista de la sesión
                        $notifList = $_SESSION['unreadNotifications'] ?? [];
                        if(!empty($notifList)) { 
                            foreach($notifList as $notif) { ?>
                                <li>
                                    <a class="dropdown-item border-bottom py-2" 
                                       href="<?php echo FRONT_ROOT ?>StudentJobOffer/showOfferDetails/<?php echo $notif->getJobOfferId(); ?>">
                                        <div class="d-flex flex-column">
                                            <span class="small text-primary fw-bold">Nueva Oferta</span>
                                            <span class="text-wrap small text-dark" style="max-width: 230px; line-height: 1.2;">
                                                <?php echo $notif->getMessage(); ?>
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            <?php } 
                        } else { ?>
                            <li><span class="dropdown-item text-muted text-center py-3">No hay notificaciones nuevas</span></li>
                        <?php } ?>

                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center small text-primary fw-bold" href="<?php echo FRONT_ROOT ?>Notification/showListView">Ver todas</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= FRONT_ROOT ?>StudentJobOffer/showMyApplications">Mis Aplicaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT ?>StudentJobOffer/showActiveJobOffers">Buscar Trabajos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT ?>StudentCompany/showCompaniesViews">Compañías</a>
                </li>

                <li class="nav-item border-start border-secondary ms-lg-3 ps-lg-3">
                    <a class="nav-link fw-bold text-white" href="<?php echo FRONT_ROOT ?>Student/showStudentProfile">
                        Mi Perfil
                    </a>
                </li>
                
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-outline-light btn-sm px-3 ms-lg-2" href="<?php echo FRONT_ROOT ?>Home/logout">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>