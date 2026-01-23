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
            
            <?php
                $student = $_SESSION['student'] ?? null;

                if ($student === null) {
                    echo "Student not found";
                    exit;
                }
            ?>
            <h1 p class="text-warning" class="mb-1">You are Welcome <?php echo $student->getFirstName();?></h1>
            <h5 class="mb-5"><em>Please choose one of the next action </em></h5>
            <!--a class="btn btn-warning btn-xl" href="<?php echo BASE_FOLDER ?>/Student/ShowStudentProfile/" >Profile</a-->    
            <?php 
            echo "<td><a href=" . FRONT_ROOT . "Student/ShowStudentProfile/" . $student->getEmail() . ">
            <button type='button' class= 'btn btn-info' >Profile</button></a></td>";
            ?>
            <a class="btn btn-warning btn-xl" href="<?php echo FRONT_ROOT ?>/Company/showCompaniesViews">See Companies</a>
            <a class="btn btn-warning btn-xl" href="<?php echo FRONT_ROOT ?>/StudentJobOffer/listJobOffers/">Job Offers List</a>  
            <?php //echo "<a class='btn btn-warning btn-xl' href=" . FRONT_ROOT .  'Home/getStudentByMail/' . $this->student->getEmail();?></a>               
           
    
       </div>
       
    </header>
    <br><br>
</body>
<br><br>
