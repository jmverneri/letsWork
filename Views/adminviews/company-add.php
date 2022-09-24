<?php

use Utils\Utils;

Utils::checkNav();

if (isset($this->message)) {
     echo "$this->message";
}
?>
<main class="py-5">

     <section id="listado" class="mb-5">
          <div class="container">

               <h2 class="mb-4">Add Company</h2>

               <form action="<?php echo FRONT_ROOT ?>Company/AddCompany" method="POST" class="bg-light-alpha p-5" enctype="multipart/form-data">
                    <div class="row">
                         <div class="col-lg-4">

                              <label for=""><b>Name</b></label>
                              <input type="text" name="name" value="" class="form-control" required value="">

                         </div>
                         <div class="col-lg-4">

                              <label for=""><b>CUIT</b></label>
                              <br>
                              <input type="number" placeholder="00" min="20" max="27" name="pre" value="" class="form-control-sm" required value="">
                              <input type="number" placeholder="00000000" min="11111111" max="99999999" name="dni" value="" class="form-control-sm" required value="">
                              <input type="number" placeholder="0" min="1" max="9" name="ultimo" value="" class="form-control-sm" required value="">

                         </div>
                         <div class="col-lg-4">

                              <label for=""><b>Year Foundation</b></label>
                              <input type="date" name="yearFoundation" value="" min="1900-01-01" max="<?php echo date("Y-m-d"); ?>" class="form-control" required value="">

                         </div>
                         <div class="col-lg-4">

                              <label for=""><b>City</b></label>
                              <input type="text" name="city" value="" class="form-control" required value="">

                         </div>
                         <div class="col-lg-4">

                              <label for=""><b>Description</b></label>
                              <input type="text" name="description" value="" class="form-control" required value="">

                         </div>
                         <div class="col-lg-4">

                              <label for=""><b>Email</b></label>
                              <input type="mail" name="email" value="" class="form-control" required value="">

                         </div>
                         <div class="col-lg-4">

                              <label for=""><b>Phone Number</b></label>
                              <input type="number" name="phoneNumber" value="" class="form-control" required value="">

                         </div>

                         <!-- <div class="col-lg-4">
                         
                                   <label for="" ><b>Logo</b></label>
                                   <input type="file" name="logo" value="" class="form-control" required value="">
                             
                         </div>-->
                    </div>
                    <button type="submit" name="" class="btn btn-dark ml-auto d-block">Add</button>

               </form>
          </div>
     </section>
</main>
<br><br><br>