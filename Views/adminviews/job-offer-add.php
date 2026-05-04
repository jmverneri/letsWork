<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Agregar nueva oferta laboral</h1>
      <p class="page-subtitle">Completá los datos para publicar una nueva oferta.</p>
    </div>
  </div>

  <div class="card" style="max-width: 800px;">
    <form action="<?php echo FRONT_ROOT . 'AdminJobOffer/add'; ?>" method="POST" enctype="multipart/form-data">

      <div class="form-field">
        <?php if (isset($company) && $company != null): ?>
          <label>Compañía</label>
          <input type="text" class="form-control" value="<?php echo htmlspecialchars($company->getName()); ?>" readonly style="opacity:0.6; cursor:not-allowed;">
          <input type="hidden" name="companyId" value="<?php echo $company->getCompanyId(); ?>">

        <?php elseif (isset($companiesList) && !empty($companiesList)): ?>
          <label>Elegir compañía</label>
          <select name="companyId" class="form-control" required>
            <option value="" disabled selected>Elegí la compañía empleadora...</option>
            <?php foreach ($companiesList as $comp): ?>
              <option value="<?php echo $comp->getCompanyId(); ?>">
                <?php echo htmlspecialchars($comp->getName()); ?>
              </option>
            <?php endforeach; ?>
          </select>

        <?php else: ?>
          <div class="alert alert-danger">Error: No se encontraron compañías para asignar a esta oferta.</div>
        <?php endif; ?>
      </div>

      <div class="divider"></div>

      <div class="form-grid">

        <div class="form-field">
          <label>Título del trabajo</label>
          <input type="text" name="title" class="form-control" placeholder="Ej: Senior Web Developer" required>
        </div>

        <div class="form-field">
          <label>Posición</label>
          <select name="jobPositionId" class="form-control" required>
            <option value="" disabled selected>Elegí una posición...</option>
            <?php if (isset($jobPositions)):
              foreach ($jobPositions as $position): ?>
                <option value="<?php echo $position->getJobPositionId(); ?>">
                  <?php echo htmlspecialchars($position->getDescription()); ?>
                </option>
            <?php endforeach; endif; ?>
          </select>
        </div>

        <div class="form-field">
          <label>Salario mensual</label>
          <input type="number" name="salary" class="form-control" min="0" placeholder="0.00">
        </div>

        <div class="form-field">
          <label>Fecha de inicio</label>
          <input type="date" name="startDate" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <div class="form-field">
          <label>Fecha de cierre</label>
          <input type="date" name="deadline" class="form-control" required>
        </div>

        <div class="form-field full">
          <label>Descripción / Requerimientos</label>
          <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-field full">
          <label>Flyer de la oferta</label>
          <input type="file" name="flyer" class="form-control" accept="image/png, image/jpeg">
          <span class="form-hint">Solo imágenes .jpg o .png permitidas.</span>
        </div>

      </div>

      <div style="display:flex; justify-content:space-between; margin-top:1.5rem;">
        <button type="button" onclick="window.history.back();" class="btn-outline">Cancelar</button>
        <button type="submit" class="btn-dark-primary">Crear oferta laboral</button>
      </div>

    </form>
  </div>

  <a href="<?php echo FRONT_ROOT ?>Admin/showDashboard" class="page-back">← Volver al dashboard</a>

</main>