<?php

use Utils\Utils;

Utils::checkNav();

?>
<main class="py-5">

     <section id="listado" class="mb-5">
          <div class="container">

               <h2 class="mb-4">Students List</h2>

               <div class="container" style="width: 2000px; height: 400px; overflow-y: scroll;">
                    <table class="table bg-light-alpha">
                         <thead class="thead-dark">
                              <th class="header" scope="col" position="sticky">FILE NUMBER</th>
                              <th class="header" scope="col" position="sticky">Name</th>
                              <th class="header" scope="col" position="sticky">SurName</th>
                              <th class="header" scope="col" position="sticky">Gender</th>
                              <th class="header" scope="col" position="sticky">Email</th>
                              <th class="header" scope="col" position="sticky">Carrer</th>
                              <!--  <th class="header" scope="col" position="sticky">Ver</th> -->

                         </thead>


                         <tbody>

                              <?php
                              if (isset($this->studentList)) {
                                   foreach ($this->studentList as $student) {
                                        echo "<tr>";
                                        echo  "<td>" . $student->getFileNumber() . "</td>";
                                        echo  "<td>" . $student->getFirstName() . "</td>";
                                        echo  "<td>" . $student->getLastName() . "</td>";
                                        echo  "<td>" . $student->getGender() . "</td>";
                                        echo  "<td>" . $student->getEmail() . "</td>";


                                        if (isset($this->careerList)) {
                                             foreach ($this->careerList as $career) {
                                                  if ($career->getCareerId() == $student->getCareerId()) {
                                                       echo  "<td>" . $career->getDescription()  . "</td>";
                                                       $careerName = $career->getDescription();
                                                  }
                                             }
                                        }
                                        $studentId = $student->getstudentId();
                                        //$careerName = $career->getDescription();

                                        //echo "<td><a href=" . FRONT_ROOT . "Student/ShowStudent/" . $studentId . ">+ info</a></td>";
                                        echo "</tr>";
                                   }
                              }
                              ?>
                         </tbody>
                    </table>
               </div>
     </section>
     </div>
     <br>
</main>