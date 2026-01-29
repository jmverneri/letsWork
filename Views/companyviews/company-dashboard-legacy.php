<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <div class="container text-center">

        <!-- Logo -->
        <div class="mb-4">
            <img src="<?= IMG_PATH ?>Lets.png" width="400" height="141" alt="Lets Work" class="img-fluid">
        </div>

        <!-- Welcome -->
        <h1 class="text-primary mb-2">
            Welcome, <?= htmlspecialchars($company->getName()) ?>
        </h1>

        <p class="mb-5 text-muted">
            <em>Manage your company and job offers</em>
        </p>

        <div class="row g-4 justify-content-center">

            <!-- COMPANY PROFILE -->
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h4 class="card-title">Company Profile</h4>
                        <p class="card-text">
                            View your company information
                        </p>
                        <a href="<?= FRONT_ROOT ?>Company/profile"
                           class="btn btn-info">
                            View Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- EDIT COMPANY -->
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h4 class="card-title">Edit Company</h4>
                        <p class="card-text">
                            Update company data and contact information
                        </p>
                        <a href="<?= FRONT_ROOT ?>Company/edit"
                           class="btn btn-warning">
                            Edit Company
                        </a>
                    </div>
                </div>
            </div>

            <!-- JOB OFFERS -->
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h4 class="card-title">My Job Offers</h4>
                        <p class="card-text">
                            Manage your published job offers
                        </p>
                        <a href="<?= FRONT_ROOT ?>CompanyJobOffer/listMyOffers"
                           class="btn btn-success">
                            View Job Offers
                        </a>
                    </div>
                </div>
            </div>

            <!-- CREATE JOB OFFER -->
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h4 class="card-title">Create Job Offer</h4>
                        <p class="card-text">
                            Publish a new job opportunity
                        </p>
                        <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showAddView"
                           class="btn btn-primary">
                            New Job Offer
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
