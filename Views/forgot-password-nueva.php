<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="auth-root">
  <div class="auth-shell">

    <div class="auth-brand">
      <h1 class="page-title">Recuperar contraseña</h1>
      <p class="page-subtitle">Te enviamos un link para elegir una nueva clave.</p>
    </div>

    <div class="card">

      <?php if (!empty($message)): ?>
        <?php
          $alertClass = 'alert-danger';
          if ($type === 'success') $alertClass = 'alert-success';
          elseif ($type === 'warning') $alertClass = 'alert-warning';
        ?>
        <div class="alert <?php echo $alertClass; ?>" role="alert">
          <?php echo htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>

      <form action="<?php echo FRONT_ROOT ?>User/sendResetPasswordEmail" method="POST">
        <div class="form-field">
          <label class="form-label" for="email">E-mail</label>
          <input
            class="form-control"
            type="email"
            name="email"
            id="email"
            placeholder="nombre@universidad.edu"
            required
          >
          <small class="form-hint">Ingresá el correo asociado a tu cuenta.</small>
        </div>

        <button class="btn-dark-primary full" type="submit" style="margin-top: 1.4rem;">
          Enviar link de recuperación
        </button>
      </form>

      <div class="divider"></div>

      <a href="<?php echo FRONT_ROOT ?>Home/Index" class="auth-link">
        ← Volver al inicio de sesión
      </a>

    </div>

    <p class="text-muted" style="text-align:center; margin-top:1.5rem; font-size:12px;">
      Portal académico y búsqueda laboral
    </p>

  </div>
</main>