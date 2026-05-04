<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Seguridad</h1>
      <p class="page-subtitle">Administrá los accesos de administrador al sistema.</p>
    </div>
  </div>

  <?php if (isset($this->viewMessage) && !empty($this->viewMessage)): ?>
    <div class="alert alert-success" role="alert">
      <?php echo $this->viewMessage; ?>
    </div>
  <?php endif; ?>

  <!-- Crear nuevo admin -->
  <div class="card" style="max-width: 700px; margin-bottom: 2rem;">
    <p style="font-size:13px; font-weight:500; color:#1c1b19; margin:0 0 1.25rem;">Crear nuevo administrador</p>
    <form action="<?php echo FRONT_ROOT ?>Admin/addAdmin" method="POST">
      <div class="form-grid">

        <div class="form-field full">
          <label>Email</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="example@admin.com" required>
        </div>

        <div class="form-field">
          <label>Contraseña</label>
          <input type="password" name="password" id="password" class="form-control" minlength="4" required>
        </div>

        <div class="form-field">
          <label>Confirmar contraseña</label>
          <input type="password" id="confirm_password" class="form-control" required>
        </div>

      </div>

      <div id="pass-error" class="alert alert-danger" style="display:none; margin-top:0.75rem;">
        Las contraseñas no coinciden.
      </div>

      <div style="display:flex; justify-content:space-between; margin-top:1.5rem;">
        <a href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard" class="btn-outline">Atrás</a>
        <button type="submit" id="submit-btn" class="btn-dark-primary">Crear administrador</button>
      </div>
    </form>
  </div>

  <!-- Admins activos -->
  <div style="margin-bottom:2rem;">
    <p class="page-title" style="font-size:16px; margin-bottom:1rem;">Administradores activos</p>
    <div class="table-wrap" style="max-width:700px;">
      <table>
        <thead>
          <tr>
            <th>Email</th>
            <th style="text-align:center">Rol</th>
            <th style="text-align:center">Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($adminList)):
            foreach ($adminList as $admin): ?>
            <tr>
              <td style="font-weight:500;"><?php echo htmlspecialchars($admin->getEmail()); ?></td>
              <td style="text-align:center"><span class="badge-pill">Admin</span></td>
              <td style="text-align:center">
                <?php if ($admin->getUserId() != $_SESSION['loggedUser']->getUserId()): ?>
                  <form action="<?php echo FRONT_ROOT ?>Admin/removeAdmin" method="POST" class="m-0"
                        onsubmit="return confirm('¿Desactivar este administrador?')">
                    <input type="hidden" name="userId" value="<?php echo $admin->getUserId(); ?>">
                    <button type="submit" class="btn-sm btn-sm-danger">Eliminar</button>
                  </form>
                <?php else: ?>
                  <span class="badge-active">Sesión actual</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach;
          else: ?>
            <tr><td colspan="3" class="table-empty">No se encontraron administradores activos.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Admins eliminados (colapsable) -->
  <details style="max-width:700px; margin-bottom:2rem;">
    <summary style="cursor:pointer; font-size:13px; color:#9a9790; padding:10px 0; user-select:none;">
      ↓ Administradores eliminados recientemente
    </summary>
    <div class="table-wrap" style="margin-top:0.75rem;">
      <table>
        <thead>
          <tr>
            <th>Email</th>
            <th style="text-align:center">Restaurar</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($inactiveAdmins)):
            foreach ($inactiveAdmins as $inactive): ?>
            <tr>
              <td class="text-muted"><?php echo htmlspecialchars($inactive->getEmail()); ?></td>
              <td style="text-align:center">
                <form action="<?php echo FRONT_ROOT ?>Admin/restoreAdmin" method="POST">
                  <input type="hidden" name="userId" value="<?php echo $inactive->getUserId(); ?>">
                  <button type="submit" class="btn-sm btn-sm-success">Restaurar</button>
                </form>
              </td>
            </tr>
          <?php endforeach;
          else: ?>
            <tr><td colspan="2" class="table-empty">No hay cuentas inactivas.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </details>

  <a href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard" class="page-back">← Volver al dashboard</a>

</main>

<script>
  const pass = document.getElementById('password');
  const confirmInput = document.getElementById('confirm_password');
  const btn = document.getElementById('submit-btn');
  const error = document.getElementById('pass-error');

  function validate() {
    if (pass.value !== confirmInput.value && confirmInput.value !== '') {
      error.style.display = 'block';
      btn.disabled = true;
    } else {
      error.style.display = 'none';
      btn.disabled = false;
    }
  }

  pass.addEventListener('input', validate);
  confirmInput.addEventListener('input', validate);
</script>