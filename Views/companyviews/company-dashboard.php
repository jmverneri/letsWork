<?php
    use Utils\Utils;
    Utils::checkNav();
?>

<main class="py-5">
    <div class="container text-center">
        <h2 class="mb-4">Welcome, <?= htmlspecialchars($company->getName()) ?></h2>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-primary">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Job Offers</h4>
                        <p class="text-muted small">List, edit or close your active publications.</p>
                        <a href="<?= FRONT_ROOT ?>CompanyJobOffer/listMyOffers" class="btn btn-primary btn-block">View My Offers</a>
                        <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showAddView" class="btn btn-outline-primary btn-block">Post New Offer</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Company Settings</h4>
                        <p class="text-muted small">Update your location, description and contact data.</p>
                        <a href="<?= FRONT_ROOT ?>Company/profile" class="btn btn-secondary btn-block">View Profile</a>
                        <a href="<?= FRONT_ROOT ?>Company/showEditView" class="btn btn-outline-secondary btn-block">Edit Information</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>