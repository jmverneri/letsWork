<?php
use Utils\Utils;

Utils::checkNav();
?>
<main class="py-5">
     
     <section id="listado" class="mb-5">
          <div class="container">
               
               <h2 class="mb-4">Student Profile</h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <th>Name</th>
                         <th>Last Name</th>
                         <th>DNI</th>
                         <th>Gender</th>
                         <th>Birthday</th>
                         <th>Id</th>
                         <th>Career</th>
                         <th>Email</th>
                         <th>Phone Number</th>
                    </thead>
                    <tbody>

                         <?php
                         if (isset($student)) {
                              echo  "<td>" . $student->getFirstName() . "</td>";
                              echo  "<td>" . $student->getLastName() . "</td>";
                              echo  "<td>" . $student->getDni() . "</td>";
                              echo  "<td>" . $student->getGender() . "</td>";
                              echo  "<td>" . $student->getBirthDate() . "</td>";
                              echo  "<td>" . $student->getFileNumber() . "</td>";
                              echo  "<td>" . $student->getCareerId() . "</td>";
                              echo  "<td>" . $student->getEmail() . "</td>";
                              echo  "<td>" . $student->getPhoneNumber() . "</tdv>";
                         }
                         ?>
                    </tbody>
                   
          </div>
          <div class="container-menu px-8 px-lg-1 text-center ">
               <!-- <div class="view-container"> -->
               <h1 p class="text-warning" class="mb-1">You are Welcome Student</h1>
               <h5 class="mb-5"><em>Please choose one of the next action </em></h5>
               <a class="btn btn-warning btn-xl" href="<?php echo FRONT_ROOT ?>Company/ListCompanies">See Companies</a>
               <a class="btn btn-warning btn-xl" href="#">See Jobs</a>
               <br><br>
               <a class="btn btn-warning btn-xl" href="<?php echo FRONT_ROOT .  "Student/getStudentByMail/" . $student->getStudentByMail() ?>"> Perfil</a>

          </div>
     </section>
</main>