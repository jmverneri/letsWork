<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Asignar materia aprobada</h1>
      <p class="page-subtitle"><?= htmlspecialchars($student->getFirstName() . ' ' . $student->getLastName()) ?></p>
    </div>
  </div>

  <div class="card" style="max-width:600px;">
    <form action="<?php echo FRONT_ROOT ?>Admin/addSubjectToStudent" method="POST">

      <input type="hidden" name="studentId" value="<?= $student->getStudentId() ?>">

      <div class="form-field" style="margin-bottom:1.5rem;">
        <label>Seleccionar materia</label>
        <select name="subjectId" class="form-control" required>
          <option value="">Elegí una materia...</option>
          <?php foreach ($subjectList as $subject): ?>
            <option value="<?= $subject->getSubjectId() ?>">
              <?= htmlspecialchars($subject->getName()) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div style="display:flex; gap:10px;">
        <button type="submit" class="btn-dark-primary">Registrar aprobación</button>
        <a href="<?= FRONT_ROOT ?>Admin/showStudentList" class="btn-outline">Cancelar</a>
      </div>

    </form>
  </div>

  <a href="<?= FRONT_ROOT ?>Admin/showStudentList" class="page-back">← Volver al listado</a>

</main>