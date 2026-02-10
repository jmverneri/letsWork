<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo FRONT_ROOT ?>Home/menuStudent">
            <img src="<?= IMG_PATH ?>Lets.png" width="30" height="30" class="d-inline-block align-top" alt="">
            LETS WORK <span class="badge badge-warning ml-2" style="font-size: 0.7rem;">STUDENT</span>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navStudent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navStudent">
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT ?>StudentJobOffer/showActiveJobOffers">Browse Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo FRONT_ROOT ?>StudentCompany/showCompaniesViews">Companies</a>
                </li>
                <li class="nav-item border-left ml-lg-3 pl-lg-3">
                    <a class="nav-link font-weight-bold" href="<?php echo FRONT_ROOT ?>Student/showStudentProfile">
                        My Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light btn-sm ml-lg-3" href="<?php echo FRONT_ROOT ?>Home/logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>