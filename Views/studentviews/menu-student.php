<?php
use Utils\Utils;

Utils::checkNav();
           
?>

<body>
<header class="text-center">
    <br><br><br>
<img src="<?php echo IMG_PATH ?>Lets.png" width="400" height="141" alt=""/>
       </header>
    <!-- Header-->
    <br><br>

    <header class="d-flex align-items-center justify-content-center height-50">


      <div class="container-menu px-8 px-lg-1 text-center ">
            <!-- <div class="view-container"> -->
                   
            <h1 p class="text-warning" class="mb-1">You are Welcome Student</h1>
            <h5 class="mb-5"><em>Please choose one of the next action </em></h5>
            <a class="btn btn-warning btn-xl" href="<?php echo FRONT_ROOT ?>Company/ListCompanies">See Companies</a>
            <a class="btn btn-warning btn-xl" href="<?php echo FRONT_ROOT ?> JobOffer/ShowJobsViews/">Job Offers List</a>      
            <?php //echo "<a class='btn btn-warning btn-xl' href=" . FRONT_ROOT .  'Home/getStudentByMail/' . $student->getEmail();?></a>               
           
    
       </div>
       
    </header>
    <br><br>
</body>
<br><br>
