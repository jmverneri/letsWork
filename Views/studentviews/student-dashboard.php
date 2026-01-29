<?php
    use Utils\Utils;
    Utils::checkNav();
?>

<main class="py-5" style="background-color: #fbfbfa; min-height: 80vh;">
    <div class="container">
        
        <div class="text-center mb-5">
            <p class="text-muted">Find your next career move today.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="display-4 mb-3">🚀</div>
                        <h4 class="card-title fw-bold">Job Offers</h4>
                        <p class="text-muted small">Browse all available positions and apply to the ones that fit your profile.</p>
                        <a href="<?= FRONT_ROOT ?>StudentJobOffer/listJobOffers" class="btn btn-warning btn-block font-weight-bold shadow-sm">
                            Explore Opportunities
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="display-4 mb-3">🏢</div>
                        <h4 class="card-title fw-bold">Companies</h4>
                        <p class="text-muted small">Learn more about the companies registered in our network.</p>
                        <a href="<?= FRONT_ROOT ?>StudentCompany/showListView" class="btn btn-outline-dark btn-block">
                            View Directory
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="display-4 mb-3">👤</div>
                        <h4 class="card-title fw-bold">My Profile</h4>
                        <p class="text-muted small">Review your academic status and keep your contact info updated.</p>
                        <a href="<?= FRONT_ROOT ?>Student/showStudentProfile" class="btn btn-outline-secondary btn-block">
                            Check My Data
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>