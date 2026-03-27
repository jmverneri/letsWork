<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4 text-white">Editar Oferta Laboral: <?php echo $jobOffer->getTitle(); ?></h2>               
               
               <form action="<?php echo FRONT_ROOT . "AdminJobOffer/modifyJobOffer" ?>" method="POST" class="bg-light-alpha p-5">
                    <div class="row">
                         <input type="hidden" name="jobOfferId" value="<?php echo $jobOffer->getJobOfferId(); ?>" />
                         
                         <div class="col-lg-4">
                              <label for=""><b>Título de la Oferta Laboral</b></label>
                              <input type="text" name="title" class="form-control" required value="<?php echo $jobOffer->getTitle(); ?>" />
                         </div>

                         <div class="col-lg-4">
                              <label for=""><b>Comienzo</b></label>
                              <input type="date" name="startDate" class="form-control" required value="<?php echo $jobOffer->getStartDate(); ?>" />
                         </div>

                         <div class="col-lg-4">
                              <label for=""><b>Fin</b></label>
                              <input type="date" name="deadline" class="form-control" required value="<?php echo $jobOffer->getDeadline(); ?>" />
                         </div>

                         <div class="col-lg-12 mt-3">
                              <label for=""><b>Descripción</b></label>
                              <textarea name="description" class="form-control" rows="3" required><?php echo $jobOffer->getDescription(); ?></textarea>
                         </div>

                         <div class="col-lg-4 mt-3">
                              <label for=""><b>Salario</b></label>
                              <input type="number" min="1" name="salary" class="form-control" required value="<?php echo $jobOffer->getSalary(); ?>" />
                         </div>

                         <div class="col-lg-4 mt-3">
                              <label for=""><b>Status</b></label>
                              <select name="active" class="form-control">
                                   <option value="1" <?php echo ($jobOffer->getActive()) ? "selected" : ""; ?>>Active</option>
                                   <option value="0" <?php echo (!$jobOffer->getActive()) ? "selected" : ""; ?>>Inactive</option>
                              </select>
                         </div>

                         <div class="col-lg-4 mt-3">
                              <label for=""><b>Posición Laboral</b></label>
                              <select name="jobPositionId" class="form-control" required>
                                   <?php foreach ($jobPositionList as $jobPosition) { ?>
                                        <option value="<?php echo $jobPosition->getJobPositionId(); ?>" 
                                             <?php if($jobPosition->getJobPositionId() == $jobOffer->getJobPositionId()) echo "selected"; ?>>
                                             <?php echo $jobPosition->getDescription(); ?>
                                        </option>
                                   <?php } ?>
                              </select>
                         </div>

                         <input type="hidden" name="companyId" value="<?php echo $jobOffer->getCompanyId(); ?>" />

                    </div>

                    <div class="mt-4 text-right">
                         <a href="<?php echo FRONT_ROOT . "AdminJobOffer/showListView/" . $jobOffer->getCompanyId(); ?>" class="btn btn-secondary shadow-sm">Cancel</a>
                         <button type="submit" class="btn btn-primary shadow-sm">Guardar Cambios</button>
                    </div>
               </form>
          </div>
     </section>
</main>