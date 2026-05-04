<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Directorio de estudiantes</h1>
    </div>
    <div class="search-wrap">
      <span class="search-icon">&#9906;</span>
      <input type="text" id="searchInput" placeholder="Buscar por apellido...">
    </div>
  </div>

  <?php if (isset($message) && !empty($message)):
    $alertType = (strpos(strtolower($message), 'correctamente') !== false || strpos(strtolower($message), 'éxito') !== false)
      ? 'alert-success' : 'alert-danger';
  ?>
    <div class="alert <?= $alertType ?>" role="alert">
      <?php echo $message; ?>
    </div>
  <?php endif; ?>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Nombre completo</th>
          <th>Matrícula</th>
          <th>DNI</th>
          <th style="text-align:center">Estado</th>
          <th style="text-align:center">Acciones</th>
        </tr>
      </thead>
      <tbody id="studentTableBody">
        <?php if (!empty($studentList)):
          foreach ($studentList as $student): ?>
          <tr class="student-row">

            <td class="last-name-cell" style="font-weight:500;">
              <?php echo htmlspecialchars($student['lastName'] . ', ' . $student['firstName']); ?>
            </td>

            <td>
              <span class="badge-pill" style="font-family:monospace;">
                <?php echo $student['fileNumber']; ?>
              </span>
            </td>

            <td class="text-muted"><?php echo $student['dni']; ?></td>

            <td style="text-align:center">
              <?php if ($student['isRegistered']): ?>
                <span class="badge-active">Registrado</span>
              <?php else: ?>
                <span class="badge-inactive">Pendiente</span>
              <?php endif; ?>
            </td>

            <td style="text-align:center">
              <div class="table-actions">
                <a href="<?= FRONT_ROOT ?>Admin/showStudentAcademicView/<?= $student['dni']; ?>" class="btn-sm">Académico</a>
              </div>
            </td>

          </tr>
        <?php endforeach;
        else: ?>
          <tr>
            <td colspan="5" class="table-empty">No se encontraron estudiantes.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <a href="<?php echo FRONT_ROOT ?>Admin/ShowDashboard" class="page-back">← Volver al dashboard</a>

</main>

<script>
  document.getElementById('searchInput').addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    document.querySelectorAll('.student-row').forEach(row => {
      const name = row.querySelector('.last-name-cell').textContent.trim().toLowerCase();
      row.style.display = name.includes(filter) ? '' : 'none';
    });
  });
</script>