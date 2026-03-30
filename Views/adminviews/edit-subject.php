<?php
    use Utils\Utils;
    Utils::checkNav(); 
?>
<main class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-10 mx-auto">
                <h2 class="fw-bold text-warning">Editar Asignatura</h2>
                <p class="text-muted">Modificá los campos necesarios y presioná "Actualizar" para guardar los cambios.</p>
            </div>
        </div>
        
        <div class="col-lg-10 mx-auto">
            <form action="<?php echo FRONT_ROOT ?>Admin/editSubject" method="POST" class="bg-light-alpha p-5 shadow-sm" style="border-radius: 15px; border-top: 5px solid #ffc107;">
                
                <input type="hidden" name="subjectId" value="<?= $subject->getSubjectId() ?>">

                <div class="row">
                    <div class="col-12 mb-4">
                        <label class="fw-bold text-dark"><i class="fas fa-university me-1"></i> Carrera / Plan de Estudios</label>
                        <select name="careerId" class="form-control form-control-lg" required>
                            <?php foreach($careerList as $career): ?>
                                <option value="<?= $career->getCareerId() ?>" 
                                    <?= ($career->getCareerId() == $subject->getCareerId()) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($career->getDescription()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <hr class="mb-4">

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Nombre de la Asignatura</label>
                        <input type="text" name="asignatura" class="form-control" 
                               value="<?= htmlspecialchars($subject->getAsignatura()) ?>" required>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="fw-bold">Régimen de Cursado</label>
                        <select name="cursado" class="form-control" required>
                            <option value="Cuatrimestral" <?= ($subject->getCursado() == "Cuatrimestral") ? 'selected' : '' ?>>Cuatrimestral</option>
                            <option value="Anual" <?= ($subject->getCursado() == "Anual") ? 'selected' : '' ?>>Anual</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="fw-bold">Horas Semanales</label>
                        <input type="text" name="hsSemanales" class="form-control" 
                               value="<?= htmlspecialchars($subject->getHsSemanales()) ?>" required>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="fw-bold">Carga Horaria Total (Reloj)</label>
                        <div class="input-group">
                            <input type="number" name="cargaHorariaTotal" class="form-control" 
                                   value="<?= $subject->getCargaHorariaTotal() ?>" min="1" required>
                            <span class="input-group-text">hs</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="fw-bold">Créditos Académicos (Puntaje)</label>
                        <div class="input-group">
                            <input type="number" name="creditos" class="form-control" 
                                   value="<?= $subject->getCreditos() ?>" min="1" required>
                            <span class="input-group-text">pts</span>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-3">
                    <a href="<?= FRONT_ROOT ?>Admin/showSubjectList" class="btn btn-outline-secondary px-4 shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Volver al Listado
                    </a>
                    
                    <button type="submit" class="btn btn-warning px-5 fw-bold shadow-sm text-white">
                        <i class="fas fa-sync-alt me-1"></i> Actualizar Asignatura
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>