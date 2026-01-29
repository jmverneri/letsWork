<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm" style="border-bottom: 3px solid #007bff;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo FRONT_ROOT ?>Home/menuAdmin">
            <img src="<?= IMG_PATH ?>Lets.png" width="30" height="30" class="d-inline-block align-top" alt="">
            LETS WORK <span class="badge badge-primary ml-2" style="font-size: 0.7rem;">ADMIN PANEL</span>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navAdmin">
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?= FRONT_ROOT ?>AdminCompany/showCompaniesViews">Companies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= FRONT_ROOT ?>AdminJobOffer/listJobOffers">Job Offers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= FRONT_ROOT ?>Admin/showStudentList">Students</a>
                </li>
                <li class="nav-item ml-lg-3">
                    <a class="btn btn-danger btn-sm px-3" href="<?php echo FRONT_ROOT ?>Home/Logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>