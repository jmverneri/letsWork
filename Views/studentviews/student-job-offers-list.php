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
                            <th>Career</th>
                            <th>Company</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (!empty($jobOffers)): ?>
                        <?php foreach ($jobOffers as $jobOffer): ?>
                            <tr>
                                <td><?= $jobOffer->getStartDate(); ?></td>
                                <td><?= $jobOffer->getDeadline(); ?></td>
                                <td><?= $jobOffer->getSalary(); ?></td>
                                <td><?= $jobOffer->getDescription(); ?></td>
                                <td><?= $jobOffer->getCareerName() ?></td>
                                <td><?= $jobOffer->getCompanyName() ?></td>
                                <td>
                                    <a href="<?= FRONT_ROOT ?>StudentJobOffer/addStudentToAJobOffer/<?= $jobOffer->getJobOfferId(); ?>">
                                        <button class="btn btn-success btn-sm">
                                            Apply
                                        </button>
                                    </a>
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
