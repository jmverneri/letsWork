<?php
use Utils\Utils;
Utils::checkNav();

if (isset($this->message)) {
     echo "$this->message";
}


?>
<main class="py-5">
     <section id="listado" class="mb-7">
          <div class="container">
               <h2 class="mb-4">Company Details</h2>
               <form action="<?php echo FRONT_ROOT . "Company/updateCompany" ?>" method="POST" class="bg-light-alpha p-5">
                    <div class="row">
                         <input type="hidden" name="companyId" value="<?php echo $this->company->getCompanyId(); ?>" />
                         <div class="col-lg-4">
                              <label for="name"><b>Name</b></label>
                              <input type="text" name="name" class="form-control" id="name" required value="<?php echo $this->company->getName(); ?>" />

                         </div>
                         <div class="col-lg-4">

                              <label for="yearfoundation"><b>Year Fundation</b></label>
                              <input type="date" name="yearFoundation" id="yearfoundation" min="1900-01-01" max="<?php echo date("Y-m-d"); ?>" class="form-control" required value="<?php echo $this->company->getYearFoundation(); ?>" />

                         </div>

                         <div class="col-lg-4">

                              <label for="city"><b>City</b></label>
                              <input type="text" name="city" id="city" class="form-control" required value="<?php echo $this->company->getCity(); ?>" />

                         </div>
                         <div class="col-lg-4">

                              <label for="description"><b>Description</b></label>
                              <textarea type="text" name="description" id="description" class="form-control" required value=""><?php echo $this->company->getDescription(); ?></textarea>

                         </div>
                         <div class="col-lg-4">

                              <label for="email"><b>Email</b></label>
                              <input type="email" name="email" id="email" class="form-control" required value="<?php echo $this->company->getEmail(); ?>" />

                         </div>
                         <div class="col-lg-4">

                              <label for="phonenumber"><b>Phone Number</b></label>
                              <input type="number" name="phoneNumber" id="phonenumber" class="form-control" required value="<?php echo $this->company->getPhoneNumber(); ?>" />

                         </div>

                         <div class="col-lg-4">

                              <label for=""><b>CUIT</b></label>
                              <br>
                              <input type="number" placeholder="00" min="20" max="27" name="pre" value="" class="form-control-sm" required value="">
                              <input type="number" placeholder="00000000" min="11111111" max="99999999" name="dni" value="" class="form-control-sm" required value="">
                              <input type="number" placeholder="0" min="1" max="9" name="ultimo" value="" class="form-control-sm" required value="">

                         </div>
                     
                        <!-- <div class="col-lg-4">

                              <label for="">Logo</label>
                              <input type="file" name="logo" class="form-control" value="null">

                         </div> -->
                    </div>
                    <button type="submit" name="" class="btn btn-info ml-auto d-block">Save</button>
               </form>
               <br>
          </div>
          <br><br><br>
     </section>
     <br><br> <br>
</main>