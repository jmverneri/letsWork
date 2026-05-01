<?php
    use Utils\Utils;
    Utils::checkNav();
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 style="color: #333;">
                    <i class="fas fa-users text-primary"></i> Postulantes
                </h2>
                <h5 class="text-muted">Oferta: <span class="badge bg-dark text-white"><?php echo htmlspecialchars($jobOffer->getTitle()); ?></span></h5>
            </div>

            <?php if ($message) { ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-info-circle"></i> <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <div class="card shadow-sm border-0">
                <div class="table-responsive" style="border-radius: 10px;">
                    <table class="table table-hover mb-0" style="text-align: center; vertical-align: middle;">
                        <thead style="background-color: #2c3e50; color: white;">
                            <tr>
                                <th>Nombre Candidato</th>
                                <th>Contacto</th>
                                <th>Fecha Postulación</th>
                                <th>Estado de Proceso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($applicantList)) {
                                foreach ($applicantList as $student) { 
                                    $status = trim($student['status']); // Limpiamos espacios
                                    ?>
                                    <tr>
                                        <td class="align-middle text-start">
                                            <span class="fw-bold text-dark ms-3"><?php echo $student['firstName'] . " " . $student['lastName']; ?></span>
                                        </td>
                                        
                                        <td class="align-middle">
                                            <a href="mailto:<?php echo $student['email']; ?>" class="text-decoration-none"><?php echo $student['email']; ?></a>
                                        </td>
                                        
                                        <td class="align-middle text-muted small">
                                            <i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($student['applicationDate'])); ?>
                                        </td>
                                        
                                        <td class="align-middle">
                                            <?php 
                                                $badgeClass = ($status == 'active') ? 'badge-active' : (($status == 'interview') ? 'badge-interview' : 'badge-declined');
                                                $labelText = ($status == 'active') ? 'Pendiente' : (($status == 'interview') ? 'Entrevista' : 'Declinado');
                                            ?>
                                            <span class="status-badge <?php echo $badgeClass; ?>">
                                                <?php echo $labelText; ?>
                                            </span>
                                        </td>

                                        <td class="align-middle">
                                            <?php if ($status == 'active') { ?>
                                                
                                                <button type="button" class="btn btn-outline-success btn-sm" 
                                                        data-bs-toggle="modal" data-bs-target="#interviewModal<?php echo $student['studentId']; ?>">
                                                    <i class="fas fa-calendar-plus"></i> Entrevista
                                                </button>

                                                <a href="<?php echo FRONT_ROOT; ?>Company/declineApplicant/<?php echo $student['studentId']; ?>/<?php echo $jobOffer->getJobOfferId(); ?>" 
                                                   class="btn btn-outline-danger btn-sm" 
                                                   onclick="return confirm('¿Seguro que desea declinar este alumno?')">
                                                   <i class="fas fa-user-slash"></i>
                                                </a>

                                                <div class="modal fade" id="interviewModal<?php echo $student['studentId']; ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content text-start">
                                                            <form action="<?php echo FRONT_ROOT; ?>CompanyJobOffer/setInterviewStatus" method="POST">
                                                                <div class="modal-header bg-success text-white">
                                                                    <h5 class="modal-title">Agendar Entrevista</h5>
                                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="studentId" value="<?php echo $student['studentId']; ?>">
                                                                    <input type="hidden" name="jobOfferId" value="<?php echo $jobOffer->getJobOfferId(); ?>">
                                                                    
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Alumno:</label>
                                                                        <input type="text" class="form-control bg-light" value="<?php echo $student['firstName'] . ' ' . $student['lastName']; ?>" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Fecha y Hora:</label>
                                                                        <input type="datetime-local" 
                                                                            name="date_time" 
                                                                            class="form-control" 
                                                                            min="<?= date('Y-m-d\TH:i') ?>" 
                                                                            value="<?= date('Y-m-d\TH:i') ?>" 
                                                                            required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Link (Meet/Zoom) o Ubicación:</label>
                                                                        <input type="text" name="location" class="form-control" placeholder="https://meet.google.com/..." required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                    <button type="submit" class="btn btn-success">Confirmar y Enviar Mail</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } elseif ($status == 'interview') { ?>
                                                <span class="text-info small fw-bold">
                                                    <i class="fas fa-check-circle"></i> Mail Enviado
                                                </span>
                                            <?php } else { ?>
                                                <span class="text-muted small italic">Sin acciones</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } 
                            } else { ?>
                                <tr>
                                    <td colspan="5" class="py-5 text-center text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                                        <p>No hay postulantes registrados aún.</p>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4 text-center">
                <a href="<?php echo FRONT_ROOT; ?>CompanyJobOffer/listMyOffers" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i> Volver a mis ofertas
                </a>
            </div>
        </div>
    </section>
</main>