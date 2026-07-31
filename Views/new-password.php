<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="auth-root">
  <div class="auth-shell">

    <div class="auth-brand">
      <h1 class="page-title">Establecer nueva contraseña</h1>
      <p class="page-subtitle">Elegí una clave segura para tu cuenta.</p>
    </div>

    <div class="card">

      <?php if (isset($message)): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>

      <form action="<?php echo FRONT_ROOT ?>User/ResetPassword" method="POST">

        <input type="hidden" name="token" value="<?php echo $token; ?>">

        <div class="form-field">
          <label class="form-label" for="newPassword">Nueva contraseña</label>
          <input type="password" name="newPassword" id="newPassword" class="form-control"
            minlength="6" required placeholder="Mínimo 6 caracteres">
        </div>

        <div class="form-field" style="margin-bottom: 1.4rem;">
          <label class="form-label" for="confirmPassword">Confirmar contraseña</label>
          <input type="password" name="confirmPassword" id="confirmPassword" class="form-control"
            minlength="4" required placeholder="Repetí tu contraseña">
        </div>

        <button class="btn-dark-primary full" type="submit">Guardar cambios</button>

      </form>

      <div class="divider"></div>

      <p class="text-muted" style="text-align:center; font-size:12px; margin:0;">
        Asegurate de elegir una clave que no uses en otros sitios.
      </p>

    </div>

    <p class="text-muted" style="text-align:center; margin-top:1.5rem; font-size:12px;">
      Portal académico y búsqueda laboral
    </p>

  </div>
</main>