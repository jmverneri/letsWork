<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4 text-dark">Agregar Nueva Oferta Lanoral</h2>
               
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
                                        
                                        <label class="text-primary font-weight-bold">Elegir Companía</label>
                                        <select name="companyId" class="form-control" required>
                                             <option value="" disabled selected>Elegí la compañía empleadora...</option>
                                             <?php foreach($companiesList as $comp) { ?>
                                                  <option value="<?php echo $comp->getCompanyId(); ?>">
                                                       <?php echo $comp->getName(); ?>
                                                  </option>
                                             <?php } ?>
                                        </select>

                                   <?php } else { ?>
                                        <div class="alert alert-danger">Error: No se encontraron companíass para asignar a esta oferta.</div>
                                   <?php } ?>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label>Título del Trabajo</label>
                                   <input type="text" name="title" class="form-control" placeholder="e.g. Senior Web Developer" required>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label>Posición de Trabajo</label>
                                   <select name="jobPositionId" class="form-control" required>
                                        <option value="" disabled selected>Elegí una posición...</option>
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
                                   <label>Salario Mensual</label>
                                   <input type="number" name="salary" class="form-control" min="0" placeholder="0.00">
                              </div>
                         </div>

                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label>Comienzo</label>
                                   <input type="date" name="startDate" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                              </div>
                         </div>

                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label>Finalización</label>
                                   <input type="date" name="deadline" class="form-control" required>
                              </div>
                         </div>

                         <div class="col-lg-12">
                              <div class="form-group">
                                   <label>Descripción / Requerimientos</label>
                                   <textarea name="description" class="form-control" rows="4" required></textarea>
                              </div>
                         </div>
                         <div class="form-group mt-3">
                              <label for="flyer"><strong>Flyer de la Oferta (Imágen):</strong></label>
                              <input type="file" name="flyer" class="form-control-file" accept="image/png, image/jpeg">
                              <small class="form-text text-muted">Sólo .jpg or .png imágenes permitidas.</small>
                         </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                         <button type="button" onclick="window.history.back();" class="btn btn-secondary shadow-sm">
                              <i class="fas fa-arrow-left"></i> Cancel
                         </button>
                         <button type="submit" class="btn btn-primary shadow-sm px-5">
                              <i class="fas fa-check"></i> Creaar Oferta Laboral
                         </button>
                    </div>
               </form>
          </div>
     </section>
</main>