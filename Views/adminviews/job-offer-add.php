<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4 text-dark">Add New Job Offer</h2>
               
               <form action="<?php echo FRONT_ROOT . "AdminJobOffer/add" ?>" method="POST" class="bg-light-custom p-5 shadow-sm rounded">
                    <div class="row">                         
                         <div class="col-lg-12">
                              <div class="form-group">
                                   <label for="">Target Company</label>
                                   <input type="text" class="form-control fw-bold" value="<?php echo $company->getName(); ?>" readonly>
                                   <input type="hidden" name="companyId" value="<?php echo $company->getCompanyId(); ?>">
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">Job Title</label>
                                   <input type="text" name="title" class="form-control" placeholder="e.g. Senior Web Developer" required>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">Job Position</label>
                                   <select name="jobPositionId" class="form-control" required>
                                        <option value="" disabled selected>Select a position...</option>
                                        <?php foreach($jobPositions as $position) { ?>
                                             <option value="<?php echo $position->getJobPositionId(); ?>">
                                                  <?php echo $position->getDescription(); ?>
                                             </option>
                                        <?php } ?>
                                   </select>
                              </div>
                         </div>

                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Monthly Salary (Optional)</label>
                                   <input type="number" name="salary" class="form-control" min="0" placeholder="0.00">
                              </div>
                         </div>

                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Start Date</label>
                                   <input type="date" name="startDate" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                              </div>
                         </div>

                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Deadline Date</label>
                                   <input type="date" name="deadline" class="form-control" required>
                              </div>
                         </div>

                         <div class="col-lg-12">
                              <div class="form-group">
                                   <label for="">Description / Requirements</label>
                                   <textarea name="description" class="form-control" rows="4" placeholder="Describe the job responsibilities and requirements..." required></textarea>
                              </div>
                         </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                         <a href="<?php echo FRONT_ROOT . "AdminCompany/showCompaniesViews" ?>" class="btn btn-secondary shadow-sm">
                              <i class="fas fa-arrow-left"></i> Back to Companies
                         </a>
                         <button type="submit" class="btn btn-primary shadow-sm px-5">
                              <i class="fas fa-check"></i> Create Job Offer
                         </button>
                    </div>
               </form>
          </div>
     </section>
</main>