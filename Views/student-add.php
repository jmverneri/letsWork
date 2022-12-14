<?php
use Utils\Utils;

Utils::checkNav();
 
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Add Student</h2>
               <form action="<?php echo FRONT_ROOT ?>Student/Add" method="post" class="bg-light-alpha p-5">
                    <div class="row">                         
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="file">File</label>
                                   <input type="text" name="recordId" value="" class="form-control" id="file">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="firstname">Name</label>
                                   <input type="text" name="firstName" value="" class="form-control" id="firstname">
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="lastname">SurName</label>
                                   <input type="text" name="lastName" value="" class="form-control" id="lastname">
                              </div>
                         </div>
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Add</button>
               </form>
          </div>
     </section>
</main>