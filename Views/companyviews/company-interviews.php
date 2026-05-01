<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <div class="container">
        <h2 class="mb-4"><i class="fas fa-calendar-alt text-primary"></i> Agenda de Entrevistas</h2>

        <?php if (!empty($interviewList)) { ?>
            <div class="row">
                <?php foreach ($interviewList as $inter) { 
                    $date = strtotime($inter['date_time']);
                    $isPast = $date < time();
                ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm h-100 <?php echo $isPast ? 'opacity-75' : 'border-primary'; ?>">
                            <div class="card-header <?php echo $isPast ? 'bg-secondary' : 'bg-primary'; ?> text-white d-flex justify-content-between">
                                <span><i class="far fa-clock"></i> <?php echo date('d/m/Y H:i', $date); ?> hs</span>
                                <?php if($isPast) { ?>
                                    <span class="badge bg-light text-dark">Pasada</span>
                                <?php } ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $inter['firstName'] . " " . $inter['lastName']; ?></h5>
                                <p class="card-text mb-1 text-muted">
                                    <i class="fas fa-briefcase me-1"></i> <?php echo $inter['jobTitle']; ?>
                                </p>
                                <p class="card-text mb-3">
                                    <i class="fas fa-envelope me-1"></i> <a href="mailto:<?php echo $inter['email']; ?>"><?php echo $inter['email']; ?></a>
                                </p>
                                
                                <div class="bg-light p-2 rounded border small">
                                    <strong>Link/Lugar:</strong><br>
                                    <a href="<?php echo $inter['location_or_link']; ?>" target="_blank" class="text-break">
                                        <?php echo $inter['location_or_link']; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                                <?php 
                                    $status = $inter['interviewStatus'];
                                    $badgeClass = match($status) {
                                        'scheduled' => 'bg-info',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                ?>
                                
                                <span class="badge <?php echo $badgeClass; ?> text-uppercase px-3 py-2">
                                    <i class="fas <?php echo ($status === 'completed') ? 'fa-check-double' : (($status === 'cancelled') ? 'fa-ban' : 'fa-clock'); ?> me-1"></i>
                                    <?php echo $status; ?>
                                </span>

                                <?php if($status === 'scheduled') { ?>
                                    <div class="btn-group shadow-sm">
                                        <?php $idInter = $inter['interviewId'] ?? 'ID_FALTANTE'; ?>
                                            <a href="<?php echo FRONT_ROOT ?>CompanyJobOffer/changeInterviewStatus/<?php echo $idInter; ?>/completed" 
                                            class="btn btn-success btn-sm" title="Marcar como realizada">
                                                <i class="fas fa-check"></i> Finalizar
                                            </a>

                                            <a href="<?php echo FRONT_ROOT ?>CompanyJobOffer/changeInterviewStatus/<?php echo $idInter; ?>/cancelled" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="return confirm('¿Seguro que desea cancelar esta entrevista?')">
                                                <i class="fas fa-times"></i> Cancelar
                                            </a>
                                    </div>
                                <?php } else { ?>
                                    <span class="text-muted small italic">
                                        <?php echo ($status === 'completed') ? 'Realizada el ' . date('d/m') : 'Cita anulada'; ?>
                                    </span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-light text-center py-5 shadow-sm">
                <i class="fas fa-calendar-times fa-3x mb-3 text-muted"></i>
                <p class="lead">No tenés entrevistas programadas por el momento.</p>
                <a href="<?php echo FRONT_ROOT ?>CompanyJobOffer/listMyOffers" class="btn btn-primary">Ver mis ofertas</a>
            </div>
        <?php } ?>
    </div>
</main>