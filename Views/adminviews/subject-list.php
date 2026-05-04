<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Listado de asignaturas</h1>
    </div>
    <a href="<?= FRONT_ROOT ?>Admin/showAddSubjectView" class="btn-dark-primary">+ Nueva asignatura</a>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th style="text-align:center">ID</th>
          <th>Asignatura</th>
          <th style="text-align:center">Estado</th>
          <th>Cursado</th>
          <th style="text-align:center">Hs semanales</th>
          <th style="text-align:center">Carga total</th>
          <th style="text-align:center">Créditos</th>
          <th style="text-align:center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($subjectList)):
          foreach ($subjectList as $subject):
            $isActive = $subject->getActive();
        ?>
          <tr style="<?= !$isActive ? 'opacity:0.55;' : '' ?>">

            <td style="text-align:center" class="text-muted"><?= $subject->getSubjectId(); ?></td>

            <td style="font-weight:500"><?= htmlspecialchars($subject->getAsignatura()); ?></td>

            <td style="text-align:center">
              <?php if ($isActive): ?>
                <span class="badge-active">Activa</span>
              <?php else: ?>
                <span class="badge-inactive">Inactiva</span>
              <?php endif; ?>
            </td>

            <td><span class="badge-pill"><?= $subject->getCursado(); ?></span></td>

            <td style="text-align:center" class="text-muted"><?= $subject->getHsSemanales(); ?></td>

            <td style="text-align:center" class="text-muted"><?= $subject->getCargaHorariaTotal(); ?> hs</td>

            <td style="text-align:center">
              <span class="badge-pill"><?= $subject->getCreditos(); ?> pts</span>
            </td>

            <td style="text-align:center">
              <div class="table-actions">
                <a href="<?= FRONT_ROOT ?>Admin/showEditSubjectView/<?= $subject->getSubjectId(); ?>" class="btn-sm">Editar</a>

                <?php if ($isActive): ?>
                  <a href="<?= FRONT_ROOT ?>Admin/removeSubject/<?= $subject->getSubjectId(); ?>"
                     class="btn-sm btn-sm-danger"
                     onclick="return confirm('¿Dar de baja esta asignatura?')">Eliminar</a>
                <?php else: ?>
                  <a href="<?= FRONT_ROOT ?>Admin/restoreSubject/<?= $subject->getSubjectId(); ?>"
                     class="btn-sm btn-sm-success">Restaurar</a>
                <?php endif; ?>
              </div>
            </td>

          </tr>
        <?php endforeach;
        else: ?>
          <tr>
            <td colspan="8" class="table-empty">No hay asignaturas cargadas en el sistema.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <a href="<?= FRONT_ROOT ?>Admin/showDashboard" class="page-back">← Volver al dashboard</a>

</main>