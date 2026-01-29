<main class="d-flex align-items-center justify-content-center" style="min-height: 90vh; background-color: #fbfbfa;">
    <section class="w-100" style="max-width: 400px; padding: 20px;">
        
        <div class="text-center mb-5">
            <img src="<?php echo IMG_PATH ?>Lets.png" width="180" class="mb-4" alt="Logo" />
            <h1 class="h3 mb-3 fw-bold" style="color: #37352f;">Iniciar sesión</h1>
            <p class="text-muted">Ingresa tus credenciales para continuar.</p>
        </div>

        <?php if (isset($error) && !empty($error)): ?>
            <div class="alert alert-danger py-2 text-center" role="alert" style="font-size: 0.9rem;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm p-4" style="border-radius: 12px;">
            <form action='index.php?url=Home/login' method="post">
                
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">E-mail</label>
                    <input type="email" name="email" class="form-control py-2" 
                           placeholder="nombre@ejemplo.com" required style="border-radius: 8px;">
                </div>
                
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Contraseña</label>
                    <input type="password" name="password" id="password" autocomplete="on" 
                           class="form-control py-2" placeholder="••••••••" required style="border-radius: 8px;">
                </div>
                
                <button class="btn btn-dark w-100 fw-bold py-2 mb-3" type="submit" 
                        style="background-color: #37352f; border: none; border-radius: 8px;">
                    Continuar
                </button>
            </form>

            <hr class="my-4" style="opacity: 0.1;">

            <form action="index.php?url=UserCompany/ShowUserCompanyRegistrationView" method="get">
                <button class="btn btn-link w-100 text-decoration-none text-muted small" type="submit">
                    ¿Olvidaste la contraseña?
                </button>
            </form>
        </div>
    </section>
</main>