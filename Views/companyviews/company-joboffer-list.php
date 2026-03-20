<?php
use Utils\Utils;

Utils::checkNav();
?>

<main class="py-5">
    <section class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>My Job Offers</h2>

            <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showAddView"
               class="btn btn-success">
                + New Job Offer
            </a>
        </div>

        <?php if (empty($jobOffers)) : ?>
            <div class="alert alert-info text-center">
                You have not created any Job Offers yet.
            </div>
        <?php else : ?>

            <table class="table table-hover bg-light-alpha">
                <thead class="thead-dark">
                    <tr>
                        <th>Flyer</th>
                        <th>Title</th>
                        <th>Career</th>
                        <th>Expiration</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($jobOffers as $jobOffer) : ?>
                        <tr>
                            <td style="vertical-align: middle;">
                                    <?php if ($jobOffer->getFlyerImagePath()): ?>
                                        <img src="<?= str_replace('index.php', '', $_SERVER['PHP_SELF']) . 'uploads/job-offers/' . $jobOffer->getFlyerImagePath(); ?>" 
                                            alt="Flyer" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    <?php else: ?>
                                        <span class="text-muted" style="font-size: 0.7rem;">N/A</span>
                                    <?php endif; ?>
                                </td>
                            <td>
                                <?= htmlspecialchars($jobOffer->getTitle()) ?>
                            </td>

                            <td>
                            <?php 
                                // 1. Obtenemos el ID del puesto de la oferta
                                $posId = $jobOffer->getJobPositionId();
                                // 2. Buscamos qué carrera le corresponde a ese puesto
                                $carId = $positionToCareerMap[$posId] ?? null;
                                // 3. Mostramos el nombre de la carrera
                                echo htmlspecialchars($careerMap[$carId] ?? 'N/A');
                            ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($jobOffer->getDeadline()) ?>
                            </td>

                            <td>
                                <?php if ($jobOffer->getActive()) : ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary">Closed</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">

                                <a href="<?= FRONT_ROOT ?>CompanyJobOffer/viewDetails/<?= $jobOffer->getJobOfferId() ?>"
                                class="btn btn-sm btn-info">
                                    View
                                </a>

                                <?php if ($jobOffer->getActive()) : ?>
                                    <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showEditForm/<?= $jobOffer->getJobOfferId() ?>"
                                    class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= FRONT_ROOT ?>CompanyJobOffer/delete/<?= $jobOffer->getJobOfferId() ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Estás seguro de cerrar esta oferta?')">
                                        <i class="fas fa-times"></i> Close
                                    </a>
                                <?php else : ?>
                                    <a href="<?= FRONT_ROOT ?>CompanyJobOffer/reactive/<?= $jobOffer->getJobOfferId() ?>"
                                    class="btn btn-sm btn-success"
                                    onclick="return confirm('¿Deseas volver a activar esta oferta?')">
                                        <i class="fas fa-redo"></i> Reactivate
                                    </a>
                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>
        <div class="mt-4">
                <a href="<?php echo FRONT_ROOT . "Home/menuCompany" ?>" class="btn btn-secondary" style="padding: 8px 15px; border-radius: 4px; text-decoration: none; color: white; background: #6c757d; display: inline-block;">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
    </section>
</main>
