<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <section class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="color: #333;"><i class="fas fa-briefcase"></i> Mis Ofertas Laborales</h2>

            <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showAddView" class="btn btn-success shadow-sm">
                <i class="fas fa-plus"></i> Nueva Oferta Laboral
            </a>
        </div>

        <?php if (empty($jobOffers)) : ?>
            <div class="alert alert-info text-center shadow-sm">
                <i class="fas fa-info-circle"></i> No creaste ninguna oferta laboral todavía.
            </div>
        <?php else : ?>

            <div class="table-responsive shadow-sm" style="border-radius: 10px; overflow: hidden;">
                <table class="table table-hover bg-light-alpha mb-0">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>Flyer</th>
                            <th class="text-left">Título</th>
                            <th>Carrera</th>
                            <th>Postulantes</th> <th>Expiración</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($jobOffers as $jobOffer) : ?>
                            <tr class="text-center">
                                <td style="vertical-align: middle;">
                                    <?php if ($jobOffer->getFlyerImagePath()): ?>
                                        <img src="<?= str_replace('index.php', '', $_SERVER['PHP_SELF']) . 'uploads/job-offers/' . $jobOffer->getFlyerImagePath(); ?>" 
                                            alt="Flyer" style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">
                                    <?php else: ?>
                                        <i class="fas fa-image text-muted" style="font-size: 1.5rem;"></i>
                                    <?php endif; ?>
                                </td>

                                <td class="text-left" style="vertical-align: middle;">
                                    <strong><?= htmlspecialchars($jobOffer->getTitle()) ?></strong>
                                </td>

                                <td style="vertical-align: middle;">
                                    <span class="badge badge-light border text-dark">
                                        <?php 
                                            $posId = $jobOffer->getJobPositionId();
                                            $carId = $positionToCareerMap[$posId] ?? null;
                                            echo htmlspecialchars($careerMap[$carId] ?? 'N/A');
                                        ?>
                                    </span>
                                </td>

                                <td style="vertical-align: middle;">
                                    <?php $count = $jobOffer->getApplicantCount(); ?>
                                    <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showApplicants/<?= $jobOffer->getJobOfferId() ?>" 
                                       class="btn <?= ($count > 0) ? 'btn-primary' : 'btn-outline-secondary' ?> btn-sm" 
                                       style="border-radius: 20px; padding: 5px 15px; font-weight: bold; text-decoration: none;">
                                        <i class="fas fa-users"></i> <?= $count ?>
                                    </a>
                                </td>

                                <td style="vertical-align: middle;">
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($jobOffer->getDeadline())) ?>
                                    </small>
                                </td>

                                <td style="vertical-align: middle;">
                                    <?php if ($jobOffer->getActive()) : ?>
                                        <span class="badge-status-active">
                                            <i class="fas fa-check"></i> Activa
                                        </span>
                                    <?php else : ?>
                                        <span class="badge-status-closed">
                                            <i class="fas fa-lock"></i> Cerrada
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td style="vertical-align: middle;">
                                    <div class="btn-group" role="group">
                                        <a href="<?= FRONT_ROOT ?>CompanyJobOffer/viewDetails/<?= $jobOffer->getJobOfferId() ?>"
                                           class="btn btn-sm btn-info" title="Ver Detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <?php if ($jobOffer->getActive()) : ?>
                                            <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showEditForm/<?= $jobOffer->getJobOfferId() ?>"
                                               class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= FRONT_ROOT ?>CompanyJobOffer/delete/<?= $jobOffer->getJobOfferId() ?>"
                                               class="btn btn-sm btn-danger" title="Cerrar"
                                               onclick="return confirm('¿Estás seguro de cerrar esta oferta?')">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php else : ?>
                                            <a href="<?= FRONT_ROOT ?>CompanyJobOffer/reactive/<?= $jobOffer->getJobOfferId() ?>"
                                               class="btn btn-sm btn-success" title="Reactivar"
                                               onclick="return confirm('¿Deseas volver a activar esta oferta?')">
                                                <i class="fas fa-redo"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

        <div class="mt-4">
            <a href="<?= FRONT_ROOT ?>Home/menuCompany" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
            </a>
        </div>
    </section>
</main>