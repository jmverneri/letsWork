<?php
    use Utils\Utils;
    Utils::checkNav();
?>

<main class="py-5" style="background-color: #fbfbfa; min-height: 100vh; position: relative;">
    <div class="container">
        
        <div class="row mb-5 text-center text-md-left align-items-center">
            <div class="col-md-8">
                <h1 class="h3 fw-bold text-dark">Platforma de  Administración</h1>
                <p class="text-muted mb-0">Supervisá y administrá el ecosistema entero.</p>
            </div>
            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                <span class="badge badge-light border p-2 text-muted">Server Status: Online</span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">🏢</div>   
                        <h5 class="fw-bold">Companías</h5>
                        <p class="small text-muted mb-4">Administra las compañías y sus detalles.</p>
                        <a href="<?= FRONT_ROOT ?>AdminCompany/showCompaniesViews" class="btn btn-outline-primary btn-sm btn-block mb-2">Ver Lista</a>
                        <a href="<?= FRONT_ROOT ?>Company/redirectAddForm" class="btn btn-primary btn-sm btn-block">+ Agregar Nueva</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">💼</div>
                        <h5 class="fw-bold">Ofertas Laborales</h5>
                        <p class="small text-muted mb-4">Controlá todos los puestos y sus expiraciones.</p>
                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/showActiveJobOffers" class="btn btn-outline-primary btn-sm btn-block mb-2">Administrar Activas</a>
                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/showExpiredJobOffers" class="btn btn-outline-warning btn-sm btn-block">Revisar Expiradas</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">🎓</div>
                        <h5 class="fw-bold">Estudiantes</h5>
                        <p class="small text-muted mb-4">Monitoreá la actividad de los estudiantes y sus registros.</p>
                        <a href="<?= FRONT_ROOT ?>Admin/showStudentList" class="btn btn-outline-info btn-sm btn-block">Lista de Estudiantes</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px; background-color: #fdfdfd; border-left: 4px solid #6c757d;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">🔐</div>
                        <h5 class="fw-bold">Security</h5>
                        <p class="small text-muted mb-4">Creá y administrá cuentas del sistema interno.</p>
                        <a href="<?= FRONT_ROOT ?>Admin/showCreateUserForm" class="btn btn-secondary btn-sm btn-block">Agregar Usario de Sistema</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4"> 
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px; border-top: 4px solid #ffc107;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">⚙️</div>
                        <h5 class="fw-bold">Sincronización del Sistema</h5>
                        <p class="small text-muted mb-4">Importá y actualizá datos de la carrera desde la API externa.</p>
                        <a href="<?= FRONT_ROOT ?>Admin/updateCareers" class="btn btn-warning btn-sm btn-block text-white fw-bold shadow-sm">
                           Actualizar Carreras
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px; border-top: 4px solid #0d6efd; background-color: #f8faff;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">📊</div>
                        <h5 class="fw-bold text-primary">Analíticas</h5>
                        <p class="small text-muted mb-4">Ver las estadísticas de la platforma, actividad de las ofertas y el top de las posiciones.</p>
                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/ShowAnalytics" class="btn btn-primary btn-sm btn-block shadow-sm fw-bold">
                        Analíticas Abiertas
                        </a>
                    </div>
                </div>
    </div>
</div>
        </div>

        <div style="height: 150px; display: block; clear: both;"></div>

    </div> 
</main>