<main class="auth-root">
  <div class="auth-shell">

    <div class="auth-brand">
      <img src="<?php echo IMG_PATH ?>Lets.png" alt="LetsWork" class="app-logo">
      <h1 class="page-title">Bienvenido de nuevo</h1>
      <p class="page-subtitle">Ingresá tus credenciales para continuar.</p>
    </div>

    <div class="card">

      <?php if (isset($error) && !empty($error)): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <?php if (isset($messageSuccess) && !empty($messageSuccess)): ?>
        <div class="alert alert-success" role="alert">
          <?php echo htmlspecialchars($messageSuccess); ?>
        </div>
      <?php endif; ?>

      <form action="index.php?url=Home/login" method="post">
        <div class="form-field">
          <label class="form-label" for="email">E-mail</label>
          <input class="form-control" type="email" id="email" name="email"
            placeholder="nombre@universidad.edu" required>
        </div>
        <div class="form-field" style="margin-bottom: 1.4rem;">
          <label class="form-label" for="password">Contraseña</label>
          <input class="form-control" type="password" id="password" name="password"
            autocomplete="current-password" placeholder="••••••••" required>
        </div>
        <button class="btn-dark-primary full" type="submit">Continuar</button>
      </form>

      <div class="divider"></div>

      <a href="<?= FRONT_ROOT ?>User/ShowForgotPasswordView" class="auth-link">
        ¿Olvidaste tu contraseña?
      </a>

    </div>

    <p class="text-muted" style="text-align:center; margin-top:1.5rem; font-size:12px;">
      Portal académico y búsqueda laboral
    </p>

  </div>
</main>