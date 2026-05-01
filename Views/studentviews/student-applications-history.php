<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <div class="container">
        <h2 class="mb-4" style="color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px;">
            <i class="fas fa-file-signature text-primary"></i> Mis Postulaciones
        </h2>           
    
        <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="vertical-align: middle;">
                    <thead style="background: #2c3e50; color: white;">
                        <tr class="text-center">
                            <th class="text-start ps-4">Compañía</th>
                            <th class="text-start">Posición</th>
                            <th>Fecha Aplicación</th>
                            <th>Estado Oferta</th>
                            <th>Mi Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (!empty($applicationList)) {
                            foreach ($applicationList as $app) { 
                                $isOfferActuallyOpen = ($app['isRealActive'] == 1);
                                $currentAppStatus = trim($app['appStatus']);
                                ?>
                                <tr class="text-center <?php echo ($currentAppStatus == 'declined') ? 'table-light' : ''; ?>">
                                    
                                    <td class="text-start ps-4">
                                        <strong class="text-primary text-uppercase small">
                                            <?php echo $app['companyName']; ?>
                                        </strong>
                                    </td>

                                    <td class="text-start">
                                        <span class="fw-bold"><?php echo $app['title']; ?></span>
                                    </td>

                                    <td>
                                        <span class="text-muted small">
                                            <i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($app['applicationDate'])); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge <?php echo $isOfferActuallyOpen ? 'bg-success' : 'bg-secondary'; ?> shadow-sm">
                                            <?php echo $isOfferActuallyOpen ? 'Abierta' : 'Cerrada'; ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?php 
                                        echo match($currentAppStatus) {
                                            'active' => '
                                                <div class="text-info fw-bold small">
                                                    <i class="fas fa-spinner fa-spin me-1"></i> En Revisión
                                                </div>',
                                                
                                            'declined' => '
                                                <div class="text-danger fw-bold small">
                                                    <i class="fas fa-times-circle me-1"></i> Declinada
                                                </div>',
                                                
                                            'interview' => "
                                                <div class='d-flex flex-column align-items-center'>
                                                    <div class='text-primary fw-bold small mb-1'>
                                                        <i class='fas fa-calendar-check me-1'></i> ¡Entrevista!
                                                    </div>
                                                    <button class='btn btn-primary btn-sm py-0 px-2' 
                                                            style='font-size: 0.65rem;'
                                                            data-bs-toggle='modal' 
                                                            data-bs-target='#detailModal{$app['studentId']}_{$app['jobOfferId']}'>
                                                        Ver Detalles
                                                    </button>
                                                </div>
                                                
                                                <div class='modal fade' id='detailModal{$app['studentId']}_{$app['jobOfferId']}' tabindex='-1' aria-hidden='true'>
                                                    <div class='modal-dialog modal-dialog-centered'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header bg-primary text-white'>
                                                                <h5 class='modal-title'><i class='fas fa-info-circle me-2'></i>Detalles de la Entrevista</h5>
                                                                <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Close'></button>
                                                            </div>
                                                            <div class='modal-body text-start'>
                                                                <div class='mb-3'>
                                                                    <label class='text-muted small d-block'>Empresa:</label>
                                                                    <span class='fw-bold'>{$app['companyName']}</span>
                                                                </div>
                                                                <div class='mb-3'>
                                                                    <label class='text-muted small d-block'>Fecha y Hora:</label>
                                                                    <span class='fw-bold text-dark'><i class='far fa-clock me-1'></i> " . date('d/m/Y - H:i', strtotime($app['interviewDate'])) . " hs</span>
                                                                </div>
                                                                <div class='mb-3'>
                                                                    <label class='text-muted small d-block'>Lugar o Link de Reunión:</label>
                                                                    <div class='p-2 bg-light border rounded' style='word-break: break-all;'>
                                                                        <i class='fas fa-link me-1'></i> <a href='{$app['interviewLocation']}' target='_blank'>{$app['interviewLocation']}</a>
                                                                    </div>
                                                                </div>
                                                                <div class='alert alert-warning py-2 mb-0 mt-3 small text-center'>
                                                                    <i class='fas fa-exclamation-triangle me-1'></i> Por favor, confirmá tu asistencia por mail.
                                                                </div>
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button type='button' class='btn btn-secondary btn-sm' data-bs-dismiss='modal'>Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>",
                                            'completed' => '
                                                <div class="text-success fw-bold small">
                                                    <i class="fas fa-check-double me-1"></i> Entrevista Realizada
                                                </div>
                                                <div class="text-muted" style="font-size: 0.7rem;">Esperando resolución</div>',    
                                            default => '<span class="text-muted small">Estado desconocido</span>'
                                        };
                                        ?>
                                    </td>
                                </tr>
                            <?php } 
                        } else { ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-light"></i>
                                    <p>Aún no te has postulado a ninguna oferta de trabajo.</p>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="<?php echo FRONT_ROOT . "Home/menuStudent" ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
            </a>
        </div>
    </div>
</main>