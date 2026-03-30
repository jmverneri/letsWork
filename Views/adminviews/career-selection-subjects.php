<?php use Utils\Utils; Utils::checkNav(); ?>
<main class="py-5">
    <div class="container text-center">
        <h2 class="mb-4 fw-bold">Seleccione una Carrera</h2>
        <p class="text-muted mb-5">Elegí una carrera para gestionar su plan de estudios y asignaturas.</p>

        <div class="row justify-content-center">
            <?php foreach($careerList as $career) { ?>
                <div class="col-md-4 mb-4">
                    <a href="<?= FRONT_ROOT ?>Admin/showSubjectListByCareer/<?= $career->getCareerId() ?>" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 15px; border-bottom: 5px solid #0d6efd;">
                            <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                                <div class="h1 mb-3">🎓</div>
                                <h5 class="fw-bold text-dark mb-0 text-uppercase" style="font-size: 0.9rem;">
                                    <?= htmlspecialchars($career->getDescription()) ?>
                                </h5>
                                <small class="text-primary mt-2">Ver Asignaturas &rarr;</small>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>

        <div class="mt-5">
            <a href="<?= FRONT_ROOT ?>Admin/showDashboard" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver al Dashboard
            </a>
        </div>
    </div>
</main>

<style>
    .transition-all { transition: all 0.3s ease; }
    .transition-all:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>