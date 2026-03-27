<?php
    use Utils\Utils;
    Utils::checkNav($notifications, $cantNotif);
?>

<main class="py-5" style="background-color: #fbfbfa; min-height: 80vh;">
    <div class="container">
        
        <div class="text-center mb-5">
            <p class="text-muted">Encontrá el próximo movimiento en tu carrera.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="display-4 mb-3">🚀</div>
                        <h4 class="card-title fw-bold">Ofertas de trabajo</h4>
                        <p class="text-muted small">Busca todas las ofertas y aplicá a las que se ajusten a tu perfil.</p>
                        <a href="<?= FRONT_ROOT ?>StudentJobOffer/showActiveJobOffers" class="btn btn-warning btn-block font-weight-bold shadow-sm">
                            Explorá Oportunidades
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="display-4 mb-3">🏢</div>
                        <h4 class="card-title fw-bold">Companías</h4>
                        <p class="text-muted small">Aprendé más sobre las compańas registradas en nuestra red.</p>
                        <a href="<?= FRONT_ROOT ?>StudentCompany/showCompaniesViews" class="btn btn-outline-dark btn-block">
                            Ver Directorio
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="display-4 mb-3">👤</div>
                        <h4 class="card-title fw-bold">Mi Perfil</h4>
                        <p class="text-muted small">Revisá tu estatus académico y mantené actualizada tu información de contacto.</p>
                        <a href="<?= FRONT_ROOT ?>Student/showStudentProfile" class="btn btn-outline-secondary btn-block">
                            Chequear Mi Información
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="<?= FRONT_ROOT ?>Student/showPreferencesView" class="btn btn-info text-white">
                    <i class="bi bi-bell-fill me-2"></i> Configurar Alertas de Empleo
                </a>
            </div>
        </div>

    </div>
</main>