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
                    <th>File Number</th>
                         <th>Name</th>
                         <th>Last Name</th>
                         <th>DNI</th>
                         <th>Birthday</th>
                      
                        
                         <th>Email</th>
                         <th>Phone Number</th>
                    </thead>
                    <tbody>

                         <?php
                         if (isset($this->student)) {
                              echo  "<td>" . $this->student->getFileNumber() . "</td>";
                              echo  "<td>" . $this->student->getFirstName() . "</td>";
                              echo  "<td>" . $this->student->getLastName() . "</td>";
                              echo  "<td>" . $this->student->getDni() . "</td>";
                              echo  "<td>" . $this->student->getBirthDate() . "</td>";
                              echo  "<td>" . $this->student->getEmail() . "</td>";
                              echo  "<td>" . $this->student->getPhoneNumber() . "</tdv>";
                         }
                         ?>
                    </tbody>
               </table>
               <table class="table bg-light-alpha">
               <tbody>
                    <thead>
                         <h3 class="mb-4">Academic Status</h3>
                         <th>Career Id</th>
                         <th>description</th>
                    </thead>
               <tbody>
                    <?php if ($this->career != null) {
                        
                         echo  "<td>" . $this->career->getCareerId() . "</td>";
                         echo  "<td>" . $this->career->getDescription() . "</td>";
                    } ?>
               </tbody>
               </tbody>
               </table>

          </div>

     </section>
</main>