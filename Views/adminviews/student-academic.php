<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <!-- Header del estudiante -->
  <div class="card" style="margin-bottom:1.5rem;">
    <div style="display:flex; align-items:flex-start; gap:1rem; flex-wrap:wrap;">
      <div style="flex:1;">
        <h1 class="page-title" style="margin-bottom:8px;">
          <?= htmlspecialchars($student->getLastName() . ', ' . $student->getFirstName()) ?>
        </h1>
        <div style="display:flex; flex-wrap:wrap; gap:8px;">
          <span class="badge-pill">DNI: <?= $student->getDni() ?></span>
          <span class="badge-pill">Legajo: <?= htmlspecialchars($student->getFileNumber()) ?></span>
          <span class="badge-active"><?= htmlspecialchars($careerName ?? 'Carrera no especificada') ?></span>
        </div>
      </div>
    </div>
  </div>

  <div style="display:grid; grid-template-columns:1fr 2fr; gap:14px; align-items:start;">

    <!-- Registrar aprobación -->
    <div class="card">
      <p style="font-size:13px; font-weight:500; color:#1c1b19; margin:0 0 4px;">Registrar aprobación</p>
      <p class="page-subtitle" style="font-size:12px; margin:0 0 1.25rem;">Agregá una materia al historial.</p>

      <form action="<?= FRONT_ROOT ?>Admin/addSubjectToStudent" method="POST">
        <input type="hidden" name="studentId" value="<?= $student->getStudentId() ?>">
        <input type="hidden" name="dni" value="<?= $student->getDni() ?>">

        <div class="form-field" style="margin-bottom:1.25rem;">
          <label>Asignatura</label>
          <select name="subjectId" class="form-control" required>
            <option value="">Buscar materia...</option>
            <?php foreach ($availableSubjects as $subject): ?>
              <option value="<?= $subject->getSubjectId() ?>">
                <?= htmlspecialchars($subject->getAsignatura()) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <button type="submit" class="btn-dark-primary full">+ Cargar al historial</button>
      </form>
    </div>

    <!-- Historia académica -->
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Asignatura</th>
            <th style="text-align:center">Cursado</th>
            <th style="text-align:center">Créditos</th>
            <th style="text-align:center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($approvedSubjects)):
            foreach ($approvedSubjects as $appSub): ?>
            <tr>
              <td style="font-weight:500;"><?= htmlspecialchars($appSub->getAsignatura()) ?></td>
              <td style="text-align:center" class="text-muted"><?= htmlspecialchars($appSub->getCursado()) ?></td>
              <td style="text-align:center">
                <span class="badge-pill"><?= $appSub->getCreditos() ?> pts</span>
              </td>
              <td style="text-align:center">
                <a href="<?= FRONT_ROOT ?>Admin/removeStudentSubject&studentId=<?= $student->getStudentId() ?>&subjectId=<?= $appSub->getSubjectId() ?>&dni=<?= $student->getDni() ?>"
                   class="btn-sm btn-sm-danger"
                   onclick="return confirm('¿Quitar esta materia aprobada?')">Quitar</a>
              </td>
            </tr>
          <?php endforeach;
          else: ?>
            <tr>
              <td colspan="4" class="table-empty">No hay registros para este alumno.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

  <a href="<?= FRONT_ROOT ?>Admin/showStudentList" class="page-back">← Volver al listado</a>

</main>