<?php use Utils\Utils; Utils::checkNav(); ?>

<main class="py-5">
    <section class="container">
        <div class="card shadow">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><?= htmlspecialchars($jobOffer->getTitle()) ?></h3>
                <span class="badge <?= $jobOffer->getActive() ? 'badge-success' : 'badge-secondary' ?>">
                    <?= $jobOffer->getActive() ? 'Active' : 'Closed' ?>
                </span>
            </div>
            
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-graduation-cap"></i> Career:</strong> 
                            <?= $careerMap[$positionToCareerMap[$jobOffer->getJobPositionId()]] ?? 'N/A' ?>
                        </p>
                        <p><strong><i class="fas fa-briefcase"></i> Position:</strong> 
                            <?= $positionMap[$jobOffer->getJobPositionId()] ?? 'N/A' ?>
                        </p>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <p><strong><i class="fas fa-calendar-alt"></i> Start Date:</strong> <?= $jobOffer->getStartDate() ?></p>
                        <p><strong><i class="fas fa-hourglass-end"></i> Deadline:</strong> <?= $jobOffer->getDeadline() ?></p>
                        <p><strong><i class="fas fa-money-bill-wave"></i> Salary:</strong> $<?= number_format($jobOffer->getSalary(), 2) ?></p>
                    </div>
                </div>

                <hr>

                <h5>Description</h5>
                <p class="text-justify" style="white-space: pre-line;">
                    <?= htmlspecialchars($jobOffer->getDescription()) ?>
                </p>
            </div>

            <div class="card-footer text-muted">
                <a href="<?= FRONT_ROOT ?>CompanyJobOffer/listMyOffers" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showEditForm/<?= $jobOffer->getJobOfferId() ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Offer
                </a>
            </div>
        </div>
    </section>
</main>