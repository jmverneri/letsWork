<?php
use Utils\Utils;

Utils::checkNav();
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <form action="<?php echo FRONT_ROOT . "Company/ModifyCompany/" ?>" method="POST" enctype="multipart/form-data">
               <div class="container">
                    <h3 class="mb-3">Ver Empresa</h3>

                    <span>&nbsp;</span>
                    <div>
                         <input type="number" name="companyId" class="form-control form-control-ml" hidden value="<?php  if(isset($company)){echo $company->getCompanyId(); }; ?>">
                         <div class="row">
                              <div class="col-lg-4">
                                   <label for="">Nombre</label>
                                   <input type="text" name="name" class="form-control form-control-ml" value="<?php  if(isset($company)){echo $company->getName(); };  ?>">
                              </div>

                              <div class="col-lg-4">
                                   <label for="">Año de Fundacion</label>
                                   <input type="number" min="1900" max="2021" step="1" name="yearFoundation" class="form-control form-control-ml" value="<?php if(isset($company)){echo $company->getYearFoundantion();}; ?>">
                              </div>

                              <div class="col-lg-4">
                                   <label for="">Ciudad</label>
                                   <input type="text" name="city" class="form-control form-control-ml" value="<?php if(isset($company)){echo $company->getCity();}; ?>">
                              </div>

                              <div class="col-lg-4">
                                   <label for="">Descripcion</label>
                                   <textarea type="text" name="description" class="form-control form-control-ml" value=""><?php if(isset($company)){echo $company->getDescription();}; ?></textarea>
                              </div>

                              <div class="col-lg-4">
                                   <label for="">Email</label>
                                   <input type="email" name="email" class="form-control form-control-ml" value="<?php if(isset($company)){echo $company->getEmail();}; ?>">
                              </div>

                              <div class="col-lg-4">
                                   <label for="">Telefono</label>
                                   <input type="number" name="phoneNumber" class="form-control form-control-ml" value="<?php if(isset($company)){echo $company->getPhoneNumber();}; ?>">
                              </div>

                         </div>
                         <div class="row">
                              <div class="button-conteiner">
                                   <button type="submit" name="modify-company-button" class="btn btn-primary ml-auto d-block">Guardar</button>


                                   <a class="btn btn-primary btn-xl" href="<?php if(isset($company)){echo FRONT_ROOT . "Company/DeleteCompany/" . $company->getIdCompany();}; ?>">Delete Company</a>

                              </div>
                              <div class="button-conteiner">
                                   <button type="submit" name="modify-company-button" class="btn btn-primary ml-auto d-block">Guardar</button>


                                   <a class="btn btn-primary btn-xl" href="<?php if(isset($company)){echo FRONT_ROOT . "Company/UpdateCompany/" . $company->getIdCompany();}; ?>">Modify Company</a>

                              </div>

                         </div>
                    </div>
               </div>
          </form>
     </section>
</main>

