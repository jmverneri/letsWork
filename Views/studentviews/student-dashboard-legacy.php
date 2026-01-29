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
        <h1 class="text-warning mb-2">
            Welcome, <?= htmlspecialchars($student->getFirstName()) ?>
        </h1>
        <p class="mb-5 text-muted">
            <em>What would you like to do today?</em>
        </p>

        <div class="row g-4 justify-content-center">

            <!-- PROFILE -->
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h4 class="card-title">My Profile</h4>
                        <p class="card-text">
                            View your personal and academic information
                        </p>
                        <a href="<?= FRONT_ROOT ?>Student/showStudentProfile"
                           class="btn btn-info">
                            View Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- COMPANIES -->
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h4 class="card-title">Companies</h4>
                        <p class="card-text">
                            Explore companies registered in the platform
                        </p>
                        <a href="<?= FRONT_ROOT ?>StudentCompany/showListView"
                           class="btn btn-warning">
                            See Companies
                        </a>
                    </div>
                </div>
            </div>

            <!-- JOB OFFERS -->
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h4 class="card-title">Job Offers</h4>
                        <p class="card-text">
                            Browse and apply to job opportunities
                        </p>
                        <a href="<?= FRONT_ROOT ?>StudentJobOffer/listJobOffers"
                           class="btn btn-warning">
                            Job Offers List
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
