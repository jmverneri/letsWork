<?php
    use Utils\Utils;
    Utils::checkNav(); // O la validación de sesión de Admin que uses
?>

<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Add New Company</h2>

               <?php if(isset($this->message) && $this->message != "") { ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <?php echo $this->message; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
               <?php } ?>

               <form action="<?php echo FRONT_ROOT ?>Company/AddCompany" method="POST" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-6">
                              <label for="email"><b>Company Email (Login)</b></label>
                              <input type="email" name="email" id="email" class="form-control" placeholder="admin@company.com" required>
                              <small class="text-muted">Este email se usará para iniciar sesión. La clave será el CUIT.</small>
                         </div>

                         <div class="col-lg-6">
                              <label for="name"><b>Company Name</b></label>
                              <input type="text" name="name" id="name" class="form-control" placeholder="Company Name S.A." required>
                         </div>

                         <div class="col-lg-6 mt-3">
                              <label for="cuit"><b>CUIT</b></label>
                              <input type="text" 
                                     name="cuit" 
                                     id="cuit" 
                                     class="form-control" 
                                     placeholder="30123456789" 
                                     pattern="^(30|33|34)\d{8}\d$" 
                                     title="Debe empezar con 30, 33 o 34 y tener 11 dígitos sin guiones" 
                                     required>
                              <small class="text-muted">11 dígitos sin guiones (ej: 30123456789).</small>
                         </div>

                         <div class="col-lg-6 mt-3">
                              <label for="city"><b>City</b></label>
                              <select name="city" id="city" class="form-control" required>
                                   <option value="" disabled selected>Select a city...</option>
                                   <optgroup label="Buenos Aires">
                                        <option value="Mar del Plata">Mar del Plata</option>
                                        <option value="Bahía Blanca">Bahía Blanca</option>
                                        <option value="La Plata">La Plata</option>
                                        <option value="Tandil">Tandil</option>
                                        <option value="CABA">CABA</option>
                                   </optgroup>
                                   <optgroup label="Interior">
                                        <option value="Córdoba">Córdoba</option>
                                        <option value="Rosario">Rosario</option>
                                        <option value="Mendoza">Mendoza</option>
                                        <option value="Tucumán">Tucumán</option>
                                   </optgroup>
                                   <option value="Other">Other / International</option>
                              </select>
                              </div>

                         <div class="col-lg-6 mt-3">
                              <label for="phoneNumber"><b>Phone Number</b></label>
                              <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" placeholder="2235123456">
                         </div>

                         <div class="col-lg-6 mt-3">
                              <label for="logo"><b>Logo URL</b></label>
                              <input type="text" name="logo" id="logo" class="form-control" placeholder="http://example.com/logo.png">
                         </div>

                         <div class="col-lg-12 mt-3">
                              <label for="description"><b>Description</b></label>
                              <textarea name="description" id="description" class="form-control" rows="3" placeholder="Tell us about the company..."></textarea>
                         </div>
                    </div>

                    <div class="mt-4">
                         <button type="submit" class="btn btn-primary btn-lg px-5">Add Company</button>
                         <a href="<?php echo FRONT_ROOT ?>AdminCompany/showCompaniesViews" class="btn btn-outline-secondary btn-lg px-5 ml-2">Cancel</a>
                    </div>
               </form>
          </div>
     </section>
</main>