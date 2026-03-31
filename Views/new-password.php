<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container d-flex justify-content-center">
            
            <div class="col-lg-6 col-md-8"> <h2 class="mb-4 text-center">Establecer Nueva Contraseña</h2>
                
                <?php if(isset($message)) { ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>

                <div class="bg-light-alpha p-5 shadow-sm rounded">
                    <form action="<?php echo FRONT_ROOT ?>User/ResetPassword" method="POST">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">

                        <div class="form-group mb-3">
                            <label for="newPassword" class="form-label">Nueva Contraseña</label>
                            <input type="password" name="newPassword" id="newPassword" class="form-control form-control-lg" minlength="4" required placeholder="Mínimo 4 caracteres">
                        </div>

                        <div class="form-group mb-4">
                            <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control form-control-lg" minlength="4" required placeholder="Repite tu contraseña">
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <small class="text-muted">Asegúrate de elegir una clave que no uses en otros sitios.</small>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>