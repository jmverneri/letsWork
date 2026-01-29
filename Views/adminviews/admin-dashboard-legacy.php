<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <div class="container text-center">

        <h1 class="text-primary mb-3">Admin Dashboard</h1>
        <p class="mb-5"><em>Manage the entire platform</em></p>

        <div class="row g-4">

            <!-- EMPRESAS -->
            <div class="col-md-6">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h4 class="card-title">Companies</h4>
                        <p class="card-text">Create, update and manage companies</p>

                        <a href="<?= FRONT_ROOT ?>Company/RedirectAddForm" class="btn btn-success mb-2">
                            Add Company
                        </a>

                        <a href="<?= FRONT_ROOT ?>Company/showCompaniesViews" class="btn btn-primary mb-2">
                            Companies List
                        </a>
                    </div>
                </div>
            </div>

            <!-- JOB OFFERS -->
            <div class="col-md-6">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h4 class="card-title">Job Offers</h4>
                        <p class="card-text">Manage job offers and applicants</p>

                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/listJobOffers" class="btn btn-primary mb-2">
                            Job Offers List
                        </a>

                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/listExpired" class="btn btn-warning mb-2">
                            Expired Job Offers
                        </a>
                    </div>
                </div>
            </div>

            <!-- ALUMNOS -->
            <div class="col-md-6">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h4 class="card-title">Students</h4>
                        <p class="card-text">View students and their applications</p>

                        <a href="<?= FRONT_ROOT ?>Admin/showStudentList" class="btn btn-info mb-2">
                            Students List
                        </a>
                    </div>
                </div>
            </div>

            <!-- USUARIOS -->
            <div class="col-md-6">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <h4 class="card-title">Users</h4>
                        <p class="card-text">Create and manage system users</p>

                        <a href="<?= FRONT_ROOT ?>User/showCreateUserForm" class="btn btn-secondary mb-2">
                            Create User
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
