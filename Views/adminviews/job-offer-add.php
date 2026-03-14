<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4 text-dark">Add New Job Offer</h2>
               
               <form action="<?php echo FRONT_ROOT . "AdminJobOffer/add" ?>" method="POST" enctype="multipart/form-data" class="bg-light-custom p-5 shadow-sm rounded">
                    <div class="row">                         
                         
                         <div class="col-lg-12">
                              <div class="form-group">
                                   <?php 
                                   // SI EXISTE EL OBJETO EMPRESA (Viene de una empresa específica)
                                   if (isset($company) && $company != null) { ?>
                                        
                                        <label>Target Company</label>
                                        <input type="text" class="form-control fw-bold" style="background-color: #e9ecef;" 
                                               value="<?php echo $company->getName(); ?>" readonly>
                                        <input type="hidden" name="companyId" value="<?php echo $company->getCompanyId(); ?>">
                                   
                                   <?php 
                                   // SI NO EXISTE EMPRESA PERO SÍ LA LISTA (Viene del Nav Global)
                                   } else if (isset($companiesList) && !empty($companiesList)) { ?>
                                        
                                        <label class="text-primary font-weight-bold">Select Company</label>
                                        <select name="companyId" class="form-control" required>
                                             <option value="" disabled selected>Choose the employer company...</option>
                                             <?php foreach($companiesList as $comp) { ?>
                                                  <option value="<?php echo $comp->getCompanyId(); ?>">
                                                       <?php echo $comp->getName(); ?>
                                                  </option>
                                             <?php } ?>
                                        </select>

                                   <?php } else { ?>
                                        <div class="alert alert-danger">Error: No companies found to assign this offer.</div>
                                   <?php } ?>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label>Job Title</label>
                                   <input type="text" name="title" class="form-control" placeholder="e.g. Senior Web Developer" required>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label>Job Position</label>
                                   <select name="jobPositionId" class="form-control" required>
                                        <option value="" disabled selected>Select a position...</option>
                                        <?php if(isset($jobPositions)) { 
                                             foreach($jobPositions as $position) { ?>
                                                  <option value="<?php echo $position->getJobPositionId(); ?>">
                                                       <?php echo $position->getDescription(); ?>
                                                  </option>
                                        <?php } } ?>
                                   </select>
                              </div>
                         </div>

                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label>Monthly Salary</label>
                                   <input type="number" name="salary" class="form-control" min="0" placeholder="0.00">
                              </div>
                         </div>

                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label>Start Date</label>
                                   <input type="date" name="startDate" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                              </div>
                         </div>

                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label>Deadline Date</label>
                                   <input type="date" name="deadline" class="form-control" required>
                              </div>
                         </div>

                         <div class="col-lg-12">
                              <div class="form-group">
                                   <label>Description / Requirements</label>
                                   <textarea name="description" class="form-control" rows="4" required></textarea>
                              </div>
                         </div>
                         <div class="form-group mt-3">
                              <label for="flyer"><strong>Offer Flyer (Image):</strong></label>
                              <input type="file" name="flyer" class="form-control-file" accept="image/png, image/jpeg">
                              <small class="form-text text-muted">Only .jpg or .png images allowed.</small>
                         </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                         <button type="button" onclick="window.history.back();" class="btn btn-secondary shadow-sm">
                              <i class="fas fa-arrow-left"></i> Cancel
                         </button>
                         <button type="submit" class="btn btn-primary shadow-sm px-5">
                              <i class="fas fa-check"></i> Create Job Offer
                         </button>
                    </div>
               </form>
          </div>
     </section>
</main>