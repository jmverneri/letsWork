<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Mis alertas de empleo</h1>
      <p class="page-subtitle">Seleccioná las áreas que te interesan. Te notificaremos cuando coincidan con tu perfil.</p>
    </div>
  </div>

  <?php if (!empty($message)): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
  <?php endif; ?>

  <div class="card" style="max-width:700px;">
    <form action="<?= FRONT_ROOT ?>Student/savePreferences" method="POST">

      <?php if (!empty($filteredPositions)): ?>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:1.5rem;">
          <?php foreach ($filteredPositions as $position): ?>
            <label class="pref-item" for="pos-<?= $position->getJobPositionId() ?>">
              <input class="pref-checkbox" type="checkbox"
                name="preferences[]"
                value="<?= $position->getJobPositionId() ?>"
                id="pos-<?= $position->getJobPositionId() ?>">
              <div>
                <p style="font-size:13px; font-weight:500; color:#1c1b19; margin:0 0 2px;"><?= htmlspecialchars($position->getDescription()) ?></p>
                <span class="form-hint" style="margin:0;">Recibirás alertas inmediatas para este puesto.</span>
              </div>
            </label>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="table-empty">No se encontraron posiciones para tu carrera actualmente.</p>
      <?php endif; ?>

      <div style="display:flex; justify-content:space-between;">
        <a href="<?= FRONT_ROOT ?>Student/showStudentProfile" class="btn-outline">Volver al perfil</a>
        <button type="submit" class="btn-dark-primary">Guardar preferencias</button>
      </div>

    </form>
  </div>

  <a href="<?= FRONT_ROOT ?>Home/menuStudent" class="page-back">← Volver al dashboard</a>

</main>