<?php use Utils\Utils; Utils::checkNav(); ?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Listado de Asignaturas</h2>
                <a href="<?= FRONT_ROOT ?>Admin/showAddSubjectView" class="btn btn-success btn-sm shadow-sm">
                    <i class="fas fa-plus me-1"></i> Nueva Asignatura
                </a>
            </div>

            <div class="table-responsive shadow-sm" style="border-radius: 10px;">
                <table class="table bg-light-alpha table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Asignatura</th>
                            <th class="text-center">Estado</th> <th>Cursado</th>
                            <th class="text-center">Hs Semanales</th>
                            <th class="text-center">Carga Total</th>
                            <th class="text-center">Créditos</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($subjectList)) { 
                            foreach($subjectList as $subject) { 
                                // Evaluamos el estado para aplicar estilos
                                $isActive = $subject->getActive(); 
                                $rowStyle = !$isActive ? 'style="opacity: 0.6; background-color: #f8f9fa;"' : '';
                            ?>
                            <tr <?= $rowStyle ?>>
                                <td class="text-center text-muted"><?php echo $subject->getSubjectId(); ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($subject->getAsignatura()); ?></strong>
                                </td>
                                <td class="text-center">
                                    <?php if($isActive): ?>
                                        <span class="badge bg-success shadow-sm">Activa</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary shadow-sm">Inactiva</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge badge-light border text-dark"><?php echo $subject->getCursado(); ?></span></td>
                                <td class="text-center"><?php echo $subject->getHsSemanales(); ?></td>
                                <td class="text-center"><?php echo $subject->getCargaHorariaTotal(); ?> hs</td>
                                <td class="text-center">
                                    <span class="badge bg-primary text-white" style="font-size: 0.9em;">
                                        <?php echo $subject->getCreditos(); ?> pts
                                    </span>
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="<?php echo FRONT_ROOT ?>Admin/showEditSubjectView/<?php echo $subject->getSubjectId(); ?>" 
                                        class="btn btn-warning text-white shadow-sm d-inline-flex align-items-center" 
                                        style="padding: 8px 12px; border-radius: 8px; font-weight: 500;"
                                        title="Editar Asignatura">
                                            <i class="fas fa-edit me-1"></i> <span class="d-none d-xl-inline">Editar</span>
                                        </a>

                                        <?php if($isActive): ?>
                                            <a href="<?php echo FRONT_ROOT ?>Admin/removeSubject/<?php echo $subject->getSubjectId(); ?>" 
                                            class="btn btn-danger shadow-sm d-inline-flex align-items-center" 
                                            style="padding: 8px 12px; border-radius: 8px; font-weight: 500;"
                                            onclick="return confirm('¿Estás seguro de dar de baja esta asignatura?')" 
                                            title="Dar de baja">
                                                <i class="fas fa-trash-alt me-1"></i> <span class="d-none d-xl-inline">Eliminar</span>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?php echo FRONT_ROOT ?>Admin/restoreSubject/<?php echo $subject->getSubjectId(); ?>" 
                                            class="btn btn-success shadow-sm d-inline-flex align-items-center" 
                                            style="padding: 8px 12px; border-radius: 8px; font-weight: 500;"
                                            title="Restaurar Asignatura">
                                                <i class="fas fa-undo me-1"></i> <span class="d-none d-xl-inline">Restaurar</span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } 
                        } else { ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No hay asignaturas cargadas en el sistema.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-center">
                <a href="<?php echo FRONT_ROOT ?>Admin/showDashboard" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Volver al Dashboard
                </a>
            </div>
        </div>
    </section>
</main>