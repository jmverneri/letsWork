<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Editar asignatura</h1>
      <p class="page-subtitle">Modificá los campos necesarios y presioná "Actualizar" para guardar los cambios.</p>
    </div>
  </div>

  <div class="card" style="max-width:800px;">
    <form action="<?php echo FRONT_ROOT ?>Admin/editSubject" method="POST">

      <input type="hidden" name="subjectId" value="<?= $subject->getSubjectId() ?>">

      <div class="form-field">
        <label>Carrera / Plan de estudios</label>
        <select name="careerId" class="form-control" required>
          <?php foreach ($careerList as $career): ?>
            <option value="<?= $career->getCareerId() ?>"
              <?= ($career->getCareerId() == $subject->getCareerId()) ? 'selected' : '' ?>>
              <?= htmlspecialchars($career->getDescription()) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="divider"></div>

      <div class="form-grid">

        <div class="form-field">
          <label>Nombre de la asignatura</label>
          <input type="text" name="asignatura" class="form-control"
            value="<?= htmlspecialchars($subject->getAsignatura()) ?>" required>
        </div>

        <div class="form-field">
          <label>Régimen de cursado</label>
          <select name="cursado" class="form-control" required>
            <option value="Cuatrimestral" <?= ($subject->getCursado() == 'Cuatrimestral') ? 'selected' : '' ?>>Cuatrimestral</option>
            <option value="Anual" <?= ($subject->getCursado() == 'Anual') ? 'selected' : '' ?>>Anual</option>
          </select>
        </div>

        <div class="form-field">
          <label>Horas semanales</label>
          <input type="text" name="hsSemanales" class="form-control"
            value="<?= htmlspecialchars($subject->getHsSemanales()) ?>" required>
        </div>

        <div class="form-field">
          <label>Carga horaria total</label>
          <div style="display:flex; gap:8px; align-items:center;">
            <input type="number" name="cargaHorariaTotal" class="form-control"
              value="<?= $subject->getCargaHorariaTotal() ?>" min="1" required>
            <span class="text-muted" style="white-space:nowrap; font-size:13px;">hs</span>
          </div>
        </div>

        <div class="form-field">
          <label>Créditos académicos</label>
          <div style="display:flex; gap:8px; align-items:center;">
            <input type="number" name="creditos" class="form-control"
              value="<?= $subject->getCreditos() ?>" min="1" required>
            <span class="text-muted" style="white-space:nowrap; font-size:13px;">pts</span>
          </div>
        </div>

      </div>

      <div style="display:flex; justify-content:space-between; margin-top:1.5rem;">
        <a href="<?= FRONT_ROOT ?>Admin/showSubjectList" class="btn-outline">← Volver al listado</a>
        <button type="submit" class="btn-dark-primary">Actualizar asignatura</button>
      </div>

    </form>
  </div>

</main>