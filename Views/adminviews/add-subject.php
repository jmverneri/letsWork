<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Crear nueva asignatura</h1>
      <p class="page-subtitle">Completá los datos académicos para registrar la asignatura en el sistema.</p>
    </div>
  </div>

  <div class="card" style="max-width: 800px;">
    <form action="<?php echo FRONT_ROOT ?>Admin/addSubject" method="POST">

      <div class="form-field">
        <label>Carrera / Plan de estudios</label>
        <select name="careerId" class="form-control" required>
          <option value="">Seleccioná la carrera a la que pertenece esta asignatura</option>
          <?php foreach ($careerList as $career): ?>
            <option value="<?= $career->getCareerId() ?>">
              <?= htmlspecialchars($career->getDescription()) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="divider"></div>

      <div class="form-grid">

        <div class="form-field">
          <label>Nombre de la asignatura</label>
          <input type="text" name="asignatura" class="form-control" placeholder="Ej: Metodología de Sistemas I" required>
        </div>

        <div class="form-field">
          <label>Régimen de cursado</label>
          <select name="cursado" class="form-control" required>
            <option value="Cuatrimestral">Cuatrimestral</option>
            <option value="Anual">Anual</option>
          </select>
        </div>

        <div class="form-field">
          <label>Horas semanales</label>
          <input type="text" name="hsSemanales" class="form-control" placeholder="Ej: 4 horas" required>
        </div>

        <div class="form-field">
          <label>Carga horaria total</label>
          <div style="display:flex; gap:8px; align-items:center;">
            <input type="number" name="cargaHorariaTotal" class="form-control" min="1" placeholder="Ej: 64" required>
            <span class="text-muted" style="white-space:nowrap; font-size:13px;">hs</span>
          </div>
        </div>

        <div class="form-field">
          <label>Créditos académicos</label>
          <div style="display:flex; gap:8px; align-items:center;">
            <input type="number" name="creditos" class="form-control" min="1" placeholder="Ej: 6" required>
            <span class="text-muted" style="white-space:nowrap; font-size:13px;">pts</span>
          </div>
        </div>

      </div>

      <div style="display:flex; justify-content:space-between; margin-top:1.5rem;">
        <a href="<?= FRONT_ROOT ?>Admin/showDashboard" class="btn-outline">Cancelar</a>
        <button type="submit" class="btn-dark-primary">Guardar asignatura</button>
      </div>

    </form>
  </div>

  <a href="<?= FRONT_ROOT ?>Admin/showDashboard" class="page-back">← Volver al dashboard</a>

</main>