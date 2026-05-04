<?php
use Utils\Utils;
Utils::checkNav();
$user = $_SESSION['loggedUser'];
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Perfil del estudiante</h1>
    </div>
  </div>

  <?php if (isset($message) && !empty($message)): ?>
    <div class="alert alert-success" role="alert"><?php echo $message; ?></div>
  <?php endif; ?>

  <?php if (isset($errorMessage) && !empty($errorMessage)): ?>
    <div class="alert alert-danger" role="alert"><?php echo $errorMessage; ?></div>
  <?php endif; ?>

  <!-- Datos personales -->
  <div class="table-wrap" style="margin-bottom:2rem;">
    <table>
      <thead>
        <tr>
          <th>Matrícula</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>DNI</th>
          <th>Fecha de nacimiento</th>
          <th>Email</th>
          <th>Teléfono</th>
        </tr>
      </thead>
      <tbody>
        <?php if (isset($student)): ?>
          <tr>
            <td><span class="badge-pill" style="font-family:monospace;"><?= htmlspecialchars($student->getFileNumber() ?? '') ?></span></td>
            <td style="font-weight:500;"><?= htmlspecialchars($student->getFirstName()) ?></td>
            <td style="font-weight:500;"><?= htmlspecialchars($student->getLastName()) ?></td>
            <td class="text-muted"><?= htmlspecialchars($student->getDni()) ?></td>
            <td class="text-muted"><?= htmlspecialchars($student->getBirthDate() ?? '') ?></td>
            <td class="text-muted"><?= htmlspecialchars($user->getEmail()) ?></td>
            <td class="text-muted"><?= htmlspecialchars($student->getPhoneNumber() ?? '') ?></td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Carrera -->
  <p class="page-title" style="font-size:18px; margin-bottom:1rem;">Estado académico</p>
  <div class="table-wrap" style="margin-bottom:2rem;">
    <table>
      <thead>
        <tr>
          <th>Carrera</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?= $career ? htmlspecialchars($career->getDescription()) : '<span class="text-muted">Sin carrera asignada</span>' ?></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Materias aprobadas -->
  <p class="page-title" style="font-size:18px; margin-bottom:1rem;">Materias aprobadas</p>
  <div class="table-wrap" style="margin-bottom:2rem;">
    <table>
      <thead>
        <tr>
          <th>Materia</th>
          <th>Cursado</th>
          <th style="text-align:center">Estado</th>
        </tr>
      </thead>
      <tbody>
        <?php if (isset($approvedSubjects) && !empty($approvedSubjects)):
          foreach ($approvedSubjects as $subject): ?>
          <tr>
            <td style="font-weight:500;"><?= htmlspecialchars($subject->getAsignatura()) ?></td>
            <td class="text-muted"><?= htmlspecialchars($subject->getCursado() ?? '-') ?></td>
            <td style="text-align:center"><span class="badge-active">Aprobada</span></td>
          </tr>
        <?php endforeach;
        else: ?>
          <tr>
            <td colspan="3" class="table-empty">No se registran materias aprobadas para este perfil.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <a href="<?php echo FRONT_ROOT . 'Home/menuStudent'; ?>" class="page-back">← Volver al dashboard</a>

</main>