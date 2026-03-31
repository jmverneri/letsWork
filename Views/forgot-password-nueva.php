<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container d-flex justify-content-center">
            
            <div class="col-lg-6 col-md-8"> <h2 class="mb-4 text-center">Recuperar Contraseña</h2>
                
                <?php if(isset($message)) { ?>
                    <div class="alert alert-<?php echo $type; ?> text-center">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>

                <div class="bg-light-alpha p-5 shadow-sm rounded"> <form action="<?php echo FRONT_ROOT ?>User/sendResetPasswordEmail" method="POST">
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Ingresa tu correo electrónico</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="ejemplo@correo.com" required>
                            <small class="text-muted">Te enviaremos un link para que puedas elegir una nueva clave.</small>
                        </div>
                        
                        <div class="d-grid"> <button type="submit" class="btn btn-dark btn-block btn-lg">Enviar Link de Recuperación</button>
                        </div>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <a href="<?php echo FRONT_ROOT ?>Home/Index" class="text-decoration-none">
                            <i class="fas fa-arrow-left"></i> Volver al Login
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>