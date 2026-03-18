<main class="d-flex align-items-center justify-content-center" style="min-height: 90vh; background-color: #fbfbfa;">
    <section class="w-100" style="max-width: 400px; padding: 20px;">
        
        <div class="text-center mb-5">
            <h1 class="h3 mb-3 fw-bold" style="color: #37352f;">Recuperar cuenta</h1>
            <p class="text-muted">Ingresa tu e-mail para recibir tu contraseña.</p>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-<?= $type ?> py-2 text-center" role="alert" style="font-size: 0.9rem;">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm p-4" style="border-radius: 12px;">
            <form action="<?= FRONT_ROOT ?>User/SendResetPasswordEmail" method="POST">
                
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">E-mail registrado</label>
                    <input type="email" name="email" class="form-control py-2" 
                           placeholder="nombre@ejemplo.com" required style="border-radius: 8px;">
                </div>
                
                <button class="btn btn-dark w-100 fw-bold py-2 mb-3" type="submit" 
                        style="background-color: #37352f; border: none; border-radius: 8px;">
                    Enviar Contraseña
                </button>

                <div class="text-center">
                    <a href="<?= FRONT_ROOT ?>Home/Index" class="text-decoration-none text-muted small">
                        Volver al inicio de sesión
                    </a>
                </div>
            </form>
        </div>
    </section>
</main>