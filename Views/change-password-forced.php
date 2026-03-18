<?php

use Utils\Utils;

Utils::checkNav();
?>

<main class="d-flex align-items-center justify-content-center" style="min-height: 90vh; background-color: #fbfbfa;">
    <section class="w-100" style="max-width: 400px; padding: 20px;">
        
        <div class="text-center mb-5">
            <img src="<?php echo IMG_PATH ?>Lets.png" width="180" class="mb-4" alt="Logo" />
            <h1 class="h3 mb-3 fw-bold" style="color: #37352f;">Actualizar contraseña</h1>
            <p class="text-muted">Por seguridad, debes elegir una nueva clave personal para continuar.</p>
        </div>

        <?php if (isset($message) && !empty($message)): ?>
            <div class="alert alert-danger py-2 text-center" role="alert" style="font-size: 0.9rem;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm p-4" style="border-radius: 12px;">
            <form id="changePasswordForm" action="<?= FRONT_ROOT ?>User/UpdatePasswordFromForce" method="POST">
                
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Nueva contraseña</label>
                    <input type="password" name="newPassword" class="form-control py-2" 
                           placeholder="Mínimo 6 caracteres" required style="border-radius: 8px;">
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Confirmar contraseña</label>
                    <input type="password" name="confirmPassword" class="form-control py-2" 
                           placeholder="Repite tu contraseña" required style="border-radius: 8px;">
                </div>
                
                <button class="btn btn-dark w-100 fw-bold py-2" type="submit" 
                        style="background-color: #37352f; border: none; border-radius: 8px;">
                    Guardar y continuar
                </button>
            </form>
        </div>
    </section>
</main>

<script>
document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
    const pass = document.getElementsByName('newPassword')[0].value;
    const confirm = document.getElementsByName('confirmPassword')[0].value;
    const errorDiv = document.getElementById('js-error');

    // Limpiamos errores previos
    errorDiv.classList.add('d-none');

    // Validación 1: Que no sean iguales es el error más común
    if (pass !== confirm) {
        event.preventDefault(); // <--- ESTO frena el envío del formulario
        errorDiv.innerText = "Las contraseñas no coinciden.";
        errorDiv.classList.remove('d-none');
        return;
    }

    // Validación 2: Largo mínimo (opcional pero recomendado)
    if (pass.length < 6) {
        event.preventDefault();
        errorDiv.innerText = "La contraseña debe tener al menos 6 caracteres.";
        errorDiv.classList.remove('d-none');
        return;
    }
});
</script>