<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Publicar nueva oferta laboral</h1>
    </div>
  </div>

  <?php if (isset($errorMessage)): ?>
    <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
  <?php endif; ?>

  <div class="card" style="max-width:800px;">
    <form action="<?php echo FRONT_ROOT . 'CompanyJobOffer/add'; ?>" method="POST" enctype="multipart/form-data">

      <div class="form-grid">

        <div class="form-field">
          <label>Título de la vacante</label>
          <input type="text" name="title" class="form-control" placeholder="Ej: Backend Developer PHP" required>
        </div>

        <div class="form-field">
          <label>Posición laboral</label>
          <select name="jobPositionId" class="form-control" required>
            <option value="">Elegir una posición...</option>
            <?php if (!empty($jobPositions)):
              foreach ($jobPositions as $position): ?>
                <option value="<?php echo $position->getJobPositionId(); ?>">
                  <?php echo htmlspecialchars($position->getDescription()); ?>
                </option>
            <?php endforeach; endif; ?>
          </select>
        </div>

        <div class="form-field">
          <label>Salario bruto <span class="text-muted" style="font-size:11px; text-transform:none;">(opcional)</span></label>
          <div style="display:flex; gap:8px; align-items:center;">
            <span class="text-muted" style="font-size:13px;">$</span>
            <input type="number" name="salary" class="form-control" step="0.01" min="0">
          </div>
        </div>

        <div class="form-field">
          <label>Flyer publicitario</label>
          <input type="file" name="flyer" class="form-control" accept="image/jpeg, image/png">
          <span class="form-hint">Formato: JPG o PNG.</span>
        </div>

        <div class="form-field">
          <label>Fecha de inicio</label>
          <input type="date" id="startDate" name="startDate" class="form-control"
            min="<?php echo date('Y-m-d'); ?>" required
            onchange="updateDeadlineMin()">
        </div>

        <div class="form-field">
          <label>Fecha límite de postulación</label>
          <input type="date" id="deadline" name="deadline" class="form-control" required>
          <span class="form-hint">Debe ser igual o posterior a la fecha de inicio.</span>
        </div>

        <div class="form-field full">
          <label>Descripción del puesto</label>
          <textarea name="description" class="form-control" rows="5"
            placeholder="Contanos sobre las responsabilidades y requisitos..." required></textarea>
        </div>

      </div>

      <div style="display:flex; justify-content:space-between; margin-top:1.5rem;">
        <a href="<?php echo FRONT_ROOT . 'CompanyJobOffer/listMyOffers'; ?>" class="btn-outline">Cancelar</a>
        <button type="submit" class="btn-dark-primary">Publicar oferta</button>
      </div>

    </form>
  </div>

  <a href="<?php echo FRONT_ROOT ?>Home/menuCompany" class="page-back">← Volver al dashboard</a>

</main>

<script>
  function updateDeadlineMin() {
    const startValue = document.getElementById('startDate').value;
    const deadlineInput = document.getElementById('deadline');
    if (startValue) {
      deadlineInput.min = startValue;
      deadlineInput.value = startValue;
    }
  }
</script>