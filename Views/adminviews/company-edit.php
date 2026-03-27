<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
          <h2 class="mb-4 text-dark">
               Editar Companía: <span class="text-primary"><?php echo $company->getName(); ?></span>
          </h2>
            
            <form action="<?php echo FRONT_ROOT . "AdminCompany/update" ?>" method="POST" class="bg-light-alpha p-5 shadow">
                <div class="row">                         
                    <input type="hidden" name="companyId" value="<?php echo $company->getCompanyId(); ?>">

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" value="<?php echo $company->getName(); ?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                         <div class="form-group">
                              <label for="">CUIT (No editable)</label>
                              <input type="text" name="cuit" value="<?php echo $company->getCuit(); ?>" class="form-control" style="background-color: #e9ecef;" readonly>
                         </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Email (Usuario)</label>
                            <input type="email" name="email" value="<?php echo $email; ?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Ciudad</label>
                            <input type="text" name="city" value="<?php echo $company->getCity(); ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Número de teléfono</label>
                            <input type="text" name="phoneNumber" value="<?php echo $company->getPhoneNumber(); ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="active" class="form-control">
                                <option value="1" <?php echo ($company->isActive()) ? 'selected' : ''; ?>>Active</option>
                                <option value="0" <?php echo (!$company->isActive()) ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Descripciónn</label>
                            <textarea name="description" class="form-control" rows="3"><?php echo $company->getDescription(); ?></textarea>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary ml-auto d-block">Guardar Cambios</button>
            </form>
        </div>
    </section>
</main>