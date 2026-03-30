<?php
    use Utils\Utils;
    // Asumimos que $notifications y $cantNotif vienen del Controller para el Nav
    Utils::checkNav(); 
?>

<main class="py-5" style="background-color: #fbfbfa; min-height: 100vh; position: relative;">
    <div class="container">
        
        <div class="row mb-5 text-center text-md-left align-items-center">
            <div class="col-md-8">
                <h1 class="h3 fw-bold text-dark">Plataforma de Administración</h1>
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
                        <h5 class="fw-bold">Compañías</h5>
                        <p class="small text-muted mb-4">Administrá las compañías y sus detalles.</p>
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
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px; border-top: 4px solid #198754;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">📚</div>
                        <h5 class="fw-bold text-success">Gestión Académica</h5>
                        <p class="small text-muted mb-4">Administrá el catálogo de materias por carrera.</p>
                        <a href="<?= FRONT_ROOT ?>Admin/showAddSubjectView" class="btn btn-success btn-sm btn-block shadow-sm fw-bold">
                           + Crear Materia
                        </a>
                        <a href="<?= FRONT_ROOT ?>Admin/showCareerSelection" class="btn btn-outline-success btn-sm btn-block mt-2">
                           Ver Todas
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2"> 
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px; border-top: 4px solid #ffc107;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">⚙️</div>
                        <h5 class="fw-bold">Sincronización</h5>
                        <p class="small text-muted mb-4">Actualizá datos de la carrera desde la API externa.</p>
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
                        <p class="small text-muted mb-4">Estadísticas de plataforma y actividad de ofertas.</p>
                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/ShowAnalytics" class="btn btn-primary btn-sm btn-block shadow-sm fw-bold">
                        Ver Reportes
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px; border-left: 4px solid #6c757d;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">🔐</div>
                        <h5 class="fw-bold text-secondary">Seguridad</h5>
                        <p class="small text-muted mb-4">Administrá cuentas del sistema interno.</p>
                        <a href="<?= FRONT_ROOT ?>Admin/showCreateUserForm" class="btn btn-secondary btn-sm btn-block">Agregar Usuario</a>
                    </div>
                </div>
            </div>
        </div>

        <div style="height: 100px; display: block; clear: both;"></div>

    </div> 
</main>

<style>
    .transition-all {
        transition: transform 0.3s ease, shadow 0.3s ease;
    }
    .transition-all:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .btn-block {
        display: block;
        width: 100%;
    }
</style>