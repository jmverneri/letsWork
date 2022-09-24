<?php
require_once(USERCOMPANY_VIEWS."nav-usercompany.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Recruiter Profile</h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <th>Name</th>
                         <th>Last Name</th>
                         <th>DNI</th>
                         <th>Email</th>
                         <th>Phone Number</th>
                    </thead>
                    <tbody>

                         <?php
                         if (isset($this->userCompany)) {
                              echo  "<td>" . $this->userCompany->getFirstName() . "</td>";
                              echo  "<td>" . $this->userCompany->getLastName() . "</td>";
                              echo  "<td>" . $this->userCompany->getDni() . "</td>";
                              echo  "<td>" . $this->userCompany->getEmail() . "</td>";
                              echo  "<td>" . $this->userCompany->getPhoneNumber() . "</tdv>";
                         }
                         ?>
                    </tbody>
                    <br><br><br>
               </table>
               <br><br><br>
          </div>
          <br><br><br>
     </section>
     <br><br><br><br>
</main>
