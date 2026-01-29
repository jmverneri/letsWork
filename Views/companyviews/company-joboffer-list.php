<?php
use Utils\Utils;

Utils::checkNav();
?>

<main class="py-5">
    <section class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>My Job Offers</h2>

            <a href="<?= FRONT_ROOT ?>JobOffer/showAddForm"
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
                            <td>
                                <?= htmlspecialchars($jobOffer->getTitle()) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($careerMap[$jobOffer->getCareerId()] ?? 'No career') ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($jobOffer->getDeadline()) ?>
                            </td>

                            <td>
                                <?php if ($jobOffer->getStatus()) : ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary">Closed</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">

                                <a href="<?= FRONT_ROOT ?>JobOffer/show/<?= $jobOffer->getJobOfferId() ?>"
                                   class="btn btn-sm btn-info">
                                    View
                                </a>

                                <a href="<?= FRONT_ROOT ?>JobOffer/showEditForm/<?= $jobOffer->getJobOfferId() ?>"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <?php if ($jobOffer->getStatus()) : ?>
                                    <a href="<?= FRONT_ROOT ?>JobOffer/close/<?= $jobOffer->getJobOfferId() ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Close this Job Offer?')">
                                        Close
                                    </a>
                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>

    </section>
</main>
