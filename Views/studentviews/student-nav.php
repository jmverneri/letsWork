<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo FRONT_ROOT ?>Home/menuStudent">
            <img src="<?= IMG_PATH ?>Lets.png" width="30" height="30" class="d-inline-block align-top" alt="">
            LETS WORK <span class="badge badge-warning ml-2" style="font-size: 0.7rem;">ESTUDIANTE</span>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navStudent" aria-controls="navStudent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navStudent">
            <ul class="navbar-nav ml-auto align-items-center">
                
                <li class="nav-item dropdown">
                    <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span style="font-size: 1.1rem;">🔔</span>
                        <?php if($cantNotif > 0) { ?>
                            <span class="position-absolute badge rounded-pill bg-danger" 
                                  style="top: 2px; right: -5px; font-size: 0.65rem; padding: 0.2em 0.45em;">
                                <?php echo $cantNotif; ?>
                            </span>
                        <?php } ?>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationDropdown" style="min-width: 280px;">
                        <li><h6 class="dropdown-header">Notificaciones Recientes</h6></li>
                        
                        <?php if(!empty($notifications)) { ?>
                            <?php foreach($notifications as $notif) { ?>
                                <li>
                                    <a class="dropdown-item border-bottom <?php echo $notif->getIsRead() ? '' : 'bg-light'; ?>" 
                                       href="<?php echo FRONT_ROOT ?>StudentJobOffer/showOfferDetails/<?php echo $notif->getJobOfferId(); ?>">
                                        <div class="d-flex flex-column">
                                            <span class="small text-primary"><strong>Nueva Oferta</strong></span>
                                            <span class="text-wrap small text-dark" style="max-width: 230px;">
                                                <?php echo $notif->getMessage(); ?>
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } else { ?>
                            <li><span class="dropdown-item text-muted text-center py-3">No hay notificaciones nuevas</span></li>
                        <?php } ?>

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
                    <a class="nav-link" href="<?php echo FRONT_ROOT ?>StudentCompany/showCompaniesViews">Companías</a>
                </li>
                <li class="nav-item border-left ml-lg-3 pl-lg-3">
                    <a class="nav-link font-weight-bold text-white" href="<?php echo FRONT_ROOT ?>Student/showStudentProfile">
                        Mi Perfil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light btn-sm ml-lg-3 px-3" href="<?php echo FRONT_ROOT ?>Home/logout">Cerrar cesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>