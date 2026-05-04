<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="auth-root">
  <div class="auth-shell">

    <div class="auth-brand">
      <h1 class="auth-title">Recuperar contraseña</h1>
      <p class="auth-subtitle">Te enviamos un link para elegir una nueva clave.</p>
    </div>

    <div class="app-card">

      <?php if (!empty($message)): ?>
        <?php
          $alertClass = 'app-alert-error';
          if ($type === 'success') $alertClass = 'app-alert-success';
          elseif ($type === 'warning') $alertClass = 'app-alert-warning';
        ?>
        <div class="app-alert <?php echo $alertClass; ?>" role="alert">
          <?php echo htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>

      <form action="<?php echo FRONT_ROOT ?>User/sendResetPasswordEmail" method="POST">

        <div class="auth-field">
          <label class="app-label" for="email">E-mail</label>
          <input
            class="app-input"
            type="email"
            name="email"
            id="email"
            placeholder="nombre@universidad.edu"
            required
          >
          <small class="app-hint">Ingresá el correo asociado a tu cuenta.</small>
        </div>

        <button class="app-btn-primary" type="submit" style="margin-top: 1.4rem;">
          Enviar link de recuperación
        </button>

      </form>

      <div class="app-divider"></div>

      <a href="<?php echo FRONT_ROOT ?>Home/Index" class="auth-link">
        ← Volver al inicio de sesión
      </a>

    </div>

    <p class="app-footer-note">Portal académico y búsqueda laboral</p>

  </div>
</main>