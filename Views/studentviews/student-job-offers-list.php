<?php
use Utils\Utils;

Utils::checkNav();

?>

<main class="py-5">
    <section class="mb-5">
        <div class="container">
            <h2 class="mb-4">Available Job Offers</h2>

            <div class="container" style="max-height: 400px; overflow-y: auto;">

                <table class="table bg-light-alpha">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>Deadline</th>
                            <th>Salary</th>
                            <th>Description</th>
                            <th>Company</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($jobOfferList)): ?>
                        <?php foreach ($jobOfferList as $jobOffer): ?>
                            <tr>
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
                                        <span class="badge badge-info">Already Applied</span>
                                    <?php else: ?>
                                        <a href="<?= FRONT_ROOT ?>StudentJobOffer/apply/<?= $jobOffer->getJobOfferId(); ?>">
                                            <button class="btn btn-success btn-sm">
                                                Apply
                                            </button>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No active job offers available.</td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
