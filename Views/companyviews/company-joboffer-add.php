<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="mb-4 text-dark"><i class="fas fa-plus-circle text-primary me-2"></i>Publicar Nueva Oferta Laboral</h2>
                
                <?php if (isset($errorMessage)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> <?php echo $errorMessage; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <div class="card shadow-sm p-4 border-0" style="border-radius: 15px;">
                    <form action="<?php echo FRONT_ROOT . "CompanyJobOffer/add" ?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Título de la vacante</label>
                                <input type="text" name="title" class="form-control" placeholder="Ej: Backend Developer PHP" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Posición Laboral</label>
                                <select name="jobPositionId" class="form-select" required>
                                    <option value="">Elegir una posición...</option>
                                    <?php if (!empty($jobPositions)) {
                                        foreach($jobPositions as $position) { ?>
                                            <option value="<?php echo $position->getJobPositionId(); ?>">
                                                <?php echo $position->getDescription(); ?>
                                            </option>
                                        <?php } 
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Salario Bruto (Opcional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="salary" class="form-control" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Flyer Publicitario</label>
                                <input type="file" name="flyer" class="form-control" accept="image/jpeg, image/png">
                                <small class="text-muted">Formato: JPG o PNG</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Fecha de Inicio</label>
                                <input type="date" id="startDate" name="startDate" class="form-control" 
                                       min="<?php echo date('Y-m-d'); ?>" required 
                                       onchange="updateDeadlineMin()">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Fecha Límite de Postulación</label>
                                <input type="date" id="deadline" name="deadline" class="form-control" required>
                                <small class="text-primary"><i class="fas fa-info-circle"></i> Debe ser igual o posterior a la fecha de inicio.</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Descripción del Puesto</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Contanos sobre las responsabilidades y requisitos..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo FRONT_ROOT . "CompanyJobOffer/listMyOffers" ?>" class="btn btn-outline-secondary px-4">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Publicar Oferta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Lógica para que el calendario de Deadline se bloquee según el StartDate
    function updateDeadlineMin() {
        const startValue = document.getElementById('startDate').value;
        const deadlineInput = document.getElementById('deadline');
        
        if(startValue) {
            deadlineInput.min = startValue; 
                deadlineInput.value = startValue; // Si ya había una fecha, la resetea
            }
        }
    }
</script>