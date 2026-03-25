
<?php
    use Utils\Utils;
    Utils::checkNav();
?>
<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-2">Mis Alertas de Empleo 🔔</h2>
                        <p class="text-muted mb-4">Seleccioná las áreas que te interesan. Te notificaremos cada vez que una empresa publique una oferta que coincida con tu perfil.</p>

                        <?php if($message) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= $message ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>

                        <form action="<?= FRONT_ROOT ?>Student/savePreferences" method="POST">
                            <div class="row g-3">
                                <?php if(!empty($filteredPositions)) { 
                                    foreach($filteredPositions as $position) { ?>
                                    <div class="col-md-6">
                                        <div class="form-check p-3 border rounded shadow-sm hover-shadow transition-all">
                                            <input class="form-check-input ms-1" type="checkbox" 
                                                   name="preferences[]" 
                                                   value="<?= $position->getJobPositionId() ?>" 
                                                   id="pos-<?= $position->getJobPositionId() ?>">
                                            
                                            <label class="form-check-label ms-3 fw-bold" for="pos-<?= $position->getJobPositionId() ?>">
                                                <?= $position->getDescription() ?>
                                            </label>
                                            <div class="small text-muted ms-3">Recibirás alertas inmediatas para este puesto.</div>
                                        </div>
                                    </div>
                                <?php } 
                                } else { ?>
                                    <div class="col-12 text-center py-4">
                                        <p class="text-muted">No se encontraron posiciones específicas para tu carrera actualmente.</p>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="mt-5 d-flex justify-content-between">
                                <a href="<?= FRONT_ROOT ?>Student/showStudentProfile" class="btn btn-outline-secondary px-4">Volver al Perfil</a>
                                <button type="submit" class="btn btn-primary px-5 fw-bold" style="border-radius: 8px;">
                                    Guardar Preferencias
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<style>
    .hover-shadow:hover {
        border-color: #0d6efd !important;
        background-color: #f8faff;
        cursor: pointer;
    }
    .transition-all { transition: all 0.3s ease; }
</style>