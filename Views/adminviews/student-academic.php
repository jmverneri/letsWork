<?php 
    use Utils\Utils; 
    Utils::checkNav(); 
?>

<main class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px; background: linear-gradient(to right, #4e73df, #224abe);">
            <div class="card-body p-4 text-white">
                <div class="d-flex align-items-center">
                    
                    <div class="ms-4">
                        <h3 class="mb-2 fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                            <?= $student->getLastName() . ", " . $student->getFirstName() ?>
                        </h3>
                        
                        <div class="d-flex flex-wrap align-items-center" style="gap: 15px;">
                            <span class="badge bg-white text-primary px-3 py-2" style="border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-id-card me-1 opacity-75"></i> DNI: <?= $student->getDni() ?>
                            </span>
                            
                            <span class="badge bg-white text-primary px-3 py-2" style="border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-file-alt me-1 opacity-75"></i> Legajo: <?= $student->getFileNumber() ?>
                            </span>

                            <span class="badge bg-info text-white px-3 py-2 shadow-sm" style="border-radius: 8px; font-weight: 700; background-color: #36b9cc !important;">
                                <i class="fas fa-university me-1"></i> <?= $careerName ?? 'Carrera no especificada' ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 12px;">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h5 class="mb-0 fw-bold text-dark">Registrar Aprobación</h5>
                        <p class="text-muted small mb-0">Agregá una materia al historial</p>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <form action="<?= FRONT_ROOT ?>Admin/addSubjectToStudent" method="POST">
                            <input type="hidden" name="studentId" value="<?= $student->getStudentId() ?>">
                            <input type="hidden" name="dni" value="<?= $student->getDni() ?>">
                            
                            <div class="mb-4">
                                <label class="form-label small text-muted fw-bold">Seleccionar Asignatura</label>
                                <select name="subjectId" class="form-select border-0 bg-light" style="border-radius: 10px; padding: 12px;" required>
                                    <option value="">Buscar materia...</option>
                                    <?php foreach($availableSubjects as $subject): ?>
                                        <option value="<?= $subject->getSubjectId() ?>">
                                            <?= $subject->getAsignatura() ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm py-2" style="border-radius: 10px;">
                                <i class="fas fa-plus-circle me-1"></i> Cargar al Historial
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 12px;">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">Historia Académica</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-muted small text-uppercase">
                                    <tr>
                                        <th class="ps-4 py-3">Asignatura</th>
                                        <th class="text-center">Cursado</th>
                                        <th class="text-center">Créditos</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($approvedSubjects)): ?>
                                        <?php foreach($approvedSubjects as $appSub): ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="fw-bold text-dark"><?= $appSub->getAsignatura() ?></div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-muted small"><?= $appSub->getCursado() ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge rounded-pill px-3 py-2" style="background-color: #e7f0ff; color: #0d6efd; font-size: 0.8rem;">
                                                        <?= $appSub->getCreditos() ?> pts
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= FRONT_ROOT ?>Admin/removeStudentSubject?studentId=<?= $student->getStudentId() ?>&subjectId=<?= $appSub->getSubjectId() ?>&dni=<?= $student->getDni() ?>" 
                                                       class="btn btn-outline-danger btn-sm border-0" 
                                                       onclick="return confirm('¿Quitar esta materia aprobada?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">
                                                <i class="fas fa-folder-open fa-3x opacity-25 d-block mb-3"></i>
                                                No hay registros locales para este alumno.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="<?= FRONT_ROOT ?>Admin/showStudentList" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                <i class="fas fa-chevron-left me-1"></i> Volver al Listado
            </a>
        </div>
    </div>
</main>