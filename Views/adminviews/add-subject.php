<?php
    use Utils\Utils;
    Utils::checkNav(); 
?>
<main class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-10 mx-auto">
                <h2 class="fw-bold">Crear Nueva Asignatura</h2>
                <p class="text-muted">Completá los datos académicos para registrar la asignatura en el sistema.</p>
            </div>
        </div>
        
        <div class="col-lg-10 mx-auto">
            <form action="<?php echo FRONT_ROOT ?>Admin/addSubject" method="POST" class="bg-light-alpha p-5 shadow-sm" style="border-radius: 15px;">
                <div class="row">
                    <div class="col-12 mb-4">
                        <label class="fw-bold text-primary"><i class="fas fa-university me-1"></i> Carrera / Plan de Estudios</label>
                        <select name="careerId" class="form-control form-control-lg" style="border-left: 5px solid #0d6efd;" required>
                            <option value="">-- Seleccioná la carrera a la que pertenece esta asignatura --</option>
                            <?php foreach($careerList as $career): ?>
                                <option value="<?= $career->getCareerId() ?>">
                                    <?= htmlspecialchars($career->getDescription()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <hr class="mb-4">

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Nombre de la Asignatura</label>
                        <input type="text" name="asignatura" class="form-control" placeholder="Ej: Metodología de Sistemas I" required>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="fw-bold">Régimen de Cursado</label>
                        <select name="cursado" class="form-control" required>
                            <option value="Cuatrimestral">Cuatrimestral</option>
                            <option value="Anual">Anual</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="fw-bold">Horas Semanales</label>
                        <input type="text" name="hsSemanales" class="form-control" placeholder="Ej: 4 horas" required>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="fw-bold">Carga Horaria Total (Reloj)</label>
                        <div class="input-group">
                            <input type="number" name="cargaHorariaTotal" class="form-control" min="1" placeholder="Ej: 64" required>
                            <span class="input-group-text">hs</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="fw-bold">Créditos Académicos (Puntaje)</label>
                        <div class="input-group">
                            <input type="number" name="creditos" class="form-control" min="1" placeholder="Ej: 6" required>
                            <span class="input-group-text">pts</span>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-3">
                    <a href="<?= FRONT_ROOT ?>Admin/showDashboard" class="btn btn-outline-secondary px-4 shadow-sm">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </a>
                    
                    <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">
                        <i class="fas fa-save me-1"></i> Guardar Asignatura
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>