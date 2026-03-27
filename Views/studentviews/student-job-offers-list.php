<?php
use Utils\Utils;

Utils::checkNav();

?>

<main class="py-5">
    <section class="mb-5">
        <div class="container">
            <h2 class="mb-4">Ofertas laborales disponibles</h2>

            <div class="container" style="max-height: 400px; overflow-y: auto;">

                <table class="table bg-light-alpha">
                    <thead>
                        <tr>
                            <th>Flyer</th>
                            <th>Comienzo</th>
                            <th>Fin</th>
                            <th>Salario</th>
                            <th>Descripción</th>
                            <th>Companía</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($jobOfferList)): ?>
                        <?php foreach ($jobOfferList as $jobOffer): ?>
                            <tr>
                                <td style="vertical-align: middle;">
                                    <?php if ($jobOffer->getFlyerImagePath()): ?>
                                        <img src="<?= str_replace('index.php', '', $_SERVER['PHP_SELF']) . 'uploads/job-offers/' . $jobOffer->getFlyerImagePath(); ?>" 
                                            alt="Flyer" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    <?php else: ?>
                                        <span class="text-muted" style="font-size: 0.7rem;">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $jobOffer->getStartDate(); ?></td>
                                <td><?= $jobOffer->getDeadline(); ?></td>
                                <td><?= $jobOffer->getSalary(); ?></td>
                                <td><?= $jobOffer->getDescription(); ?></td>
                                <td><?= $jobOffer->getCompanyName() ?></td>
                                <td>
                                    <?php 
                                    // 1. Verificamos si el estudiante ya aplicó a ESTA oferta específica
                                    // Nota: $student viene de tu Controller (el que tiene el getStudentId())
                                    if($this->applicationDAO->isStudentApplied($student->getStudentId(), $jobOffer->getJobOfferId())): 
                                    ?>
                                        <span class="badge badge-info">Aplicado</span>
                                    <?php else: ?>
                                        <a href="<?= FRONT_ROOT ?>StudentJobOffer/apply/<?= $jobOffer->getJobOfferId(); ?>">
                                            <button class="btn btn-success btn-sm">
                                                Aplicar
                                            </button>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No hay ofertas laborales activas disponibles.</td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <a href="<?php echo FRONT_ROOT . "Home/menuStudent" ?>" class="btn btn-secondary" style="padding: 8px 15px; border-radius: 4px; text-decoration: none; color: white; background: #6c757d; display: inline-block;">
                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                </a>
            </div>
        </div>
    </section>
</main>
