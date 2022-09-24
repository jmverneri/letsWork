<?php
use Utils\Utils;

Utils::checkNav();

?>

<body>
    <header class="text-center">
        <br><br><br>
        <img src="<?php echo IMG_PATH ?>Lets.png" width="400" height="141" alt="" />
    </header>
    <!-- Header-->
    <br><br>

    <header class="d-flex align-items-center justify-content-center height-50">


        <div class="container-menu px-8 px-lg-1 text-center ">
            <!-- <div class="view-container"> -->

            <h1 p class="text-primary" class="mb-1">You are Welcome Recruiter</h1>

            <h5 class="mb-5"><em>Please choose one of the next actions</em></h5>
            <a class="btn btn-success btn-x2" href="<?php echo FRONT_ROOT ?>Company/RedirectAddForm">Add Company</a>
            <!-- <a class="btn btn-success btn-x2" href="<?php echo FRONT_ROOT ?>Company/RedirectDeleteForm">Delete Company</a>  -->
            <a class="btn btn-success btn-x2" href="<?php echo FRONT_ROOT ?>Company/ShowCompaniesViews">Companies List</a>
            <!--<a class="btn btn-primary btn-xl" href="#">Lista de Propuestas</a>-->
            <a class="btn btn-success btn-xl" href="<?php echo FRONT_ROOT ?>Student/ShowListView">Students List</a>
            <a class="btn btn-warning btn-xl" href="<?php echo FRONT_ROOT ?>JobOffer/ShowJobsViews">Job Offers List</a>
            <a class="btn btn-info btn-xl" href="<?php echo FRONT_ROOT ?>Career/showCareerListView">Careers List</a>

        </div>
    </header>
</body>
<br></br><br></br>