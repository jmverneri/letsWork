<?php
    use Utils\Utils;
    Utils::checkNav();
?>

<main class="py-5" style="background-color: #fbfbfa; min-height: 100vh; position: relative;">
    <div class="container">
        
        <div class="row mb-5 text-center text-md-left align-items-center">
            <div class="col-md-8">
                <h1 class="h3 fw-bold text-dark">Platform Administration</h1>
                <p class="text-muted mb-0">Overview and management of the entire ecosystem.</p>
            </div>
            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                <span class="badge badge-light border p-2 text-muted">Server Status: Online</span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">🏢</div>
                        <h5 class="fw-bold">Companies</h5>
                        <p class="small text-muted mb-4">Manage corporate partners and details.</p>
                        <a href="<?= FRONT_ROOT ?>AdminCompany/showCompaniesViews" class="btn btn-outline-primary btn-sm btn-block mb-2">View List</a>
                        <a href="<?= FRONT_ROOT ?>Company/RedirectAddForm" class="btn btn-primary btn-sm btn-block">+ Add New</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">💼</div>
                        <h5 class="fw-bold">Job Offers</h5>
                        <p class="small text-muted mb-4">Control all postings and expired ads.</p>
                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/listJobOffers" class="btn btn-outline-primary btn-sm btn-block mb-2">Manage Active</a>
                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/listExpired" class="btn btn-outline-warning btn-sm btn-block">Review Expired</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">🎓</div>
                        <h5 class="fw-bold">Students</h5>
                        <p class="small text-muted mb-4">Monitor student activity and records.</p>
                        <a href="<?= FRONT_ROOT ?>Admin/showStudentList" class="btn btn-outline-info btn-sm btn-block">Students List</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px; background-color: #fdfdfd; border-left: 4px solid #6c757d;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">🔐</div>
                        <h5 class="fw-bold">Security</h5>
                        <p class="small text-muted mb-4">Create and manage internal system accounts.</p>
                        <a href="<?= FRONT_ROOT ?>User/showCreateUserForm" class="btn btn-secondary btn-sm btn-block">Add System User</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4"> 
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm transition-all" style="border-radius: 12px; border-top: 4px solid #ffc107;">
                    <div class="card-body p-4">
                        <div class="h1 mb-3">⚙️</div>
                        <h5 class="fw-bold">System Sync</h5>
                        <p class="small text-muted mb-4">Import and update Career data from external API.</p>
                        <a href="<?= FRONT_ROOT ?>Admin/updateCareers" class="btn btn-warning btn-sm btn-block text-white fw-bold shadow-sm">
                           Update Careers
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div style="height: 150px; display: block; clear: both;"></div>

    </div> 
</main>