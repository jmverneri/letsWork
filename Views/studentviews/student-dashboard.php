<?php
use Utils\Utils;
Utils::checkNav();
?>
<main class="py-5" style="background-color: #fbfbfa; min-height: 80vh;">
    <div class="container">
        
        <div class="text-center mb-5">
            <h2 class="fw-bold">Bienvenido a tu Panel</h2>
            <p class="text-muted">Encontrá el próximo movimiento en tu carrera y gestioná tus preferencias.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                    <div class="card-body d-flex flex-column">
                        <div class="display-4 mb-3">🚀</div>
                        <h5 class="card-title fw-bold">Trabajos</h5>
                        <p class="text-muted small flex-grow-1">Busca ofertas y aplicá a las que se ajusten a tu perfil.</p>
                        <a href="<?= FRONT_ROOT ?>StudentJobOffer/showActiveJobOffers" class="btn btn-warning w-100 fw-bold shadow-sm mt-3">
                            Explorar
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                    <div class="card-body d-flex flex-column">
                        <div class="display-4 mb-3">🏢</div>
                        <h5 class="card-title fw-bold">Compañías</h5>
                        <p class="text-muted small flex-grow-1">Aprendé más sobre las empresas registradas en nuestra red.</p>
                        <a href="<?= FRONT_ROOT ?>StudentCompany/showCompaniesViews" class="btn btn-outline-dark w-100 mt-3">
                            Ver Directorio
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                    <div class="card-body d-flex flex-column">
                        <div class="display-4 mb-3">👤</div>
                        <h5 class="card-title fw-bold">Mi Perfil</h5>
                        <p class="text-muted small flex-grow-1">Revisá tu estatus académico y mantené tus datos al día.</p>
                        <a href="<?= FRONT_ROOT ?>Student/showStudentProfile" class="btn btn-outline-secondary w-100 mt-3">
                            Mi Info
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center p-3" style="border-radius: 15px; background: linear-gradient(145deg, #ffffff, #f0f7ff);">
                    <div class="card-body d-flex flex-column">
                        <div class="display-4 mb-3">🔔</div>
                        <h5 class="card-title fw-bold">Alertas</h5>
                        <p class="text-muted small flex-grow-1">Configurá tus intereses para recibir avisos personalizados.</p>
                        <a href="<?= FRONT_ROOT ?>Student/showPreferencesView" class="btn btn-info text-white w-100 fw-bold mt-3">
                            Configurar
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>