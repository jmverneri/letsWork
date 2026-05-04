<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Editar oferta laboral</h1>
      <p class="page-subtitle"><?php echo htmlspecialchars($jobOffer->getTitle()); ?></p>
    </div>
  </div>

  <div class="card" style="max-width:900px;">
    <form action="<?php echo FRONT_ROOT . 'AdminJobOffer/modifyJobOffer'; ?>" method="POST">

      <input type="hidden" name="jobOfferId" value="<?php echo $jobOffer->getJobOfferId(); ?>">
      <input type="hidden" name="companyId" value="<?php echo $jobOffer->getCompanyId(); ?>">

      <div class="form-grid" style="grid-template-columns: repeat(3, 1fr);">

        <div class="form-field full">
          <label>Título de la oferta</label>
          <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($jobOffer->getTitle()); ?>" required>
        </div>

        <div class="form-field">
          <label>Fecha de inicio</label>
          <input type="date" name="startDate" class="form-control" value="<?php echo $jobOffer->getStartDate(); ?>" required>
        </div>

        <div class="form-field">
          <label>Fecha de cierre</label>
          <input type="date" name="deadline" class="form-control" value="<?php echo $jobOffer->getDeadline(); ?>" required>
        </div>

        <div class="form-field">
          <label>Salario</label>
          <input type="number" name="salary" class="form-control" min="1" value="<?php echo $jobOffer->getSalary(); ?>" required>
        </div>

        <div class="form-field">
          <label>Estado</label>
          <select name="active" class="form-control">
            <option value="1" <?php echo $jobOffer->getActive() ? 'selected' : ''; ?>>Activa</option>
            <option value="0" <?php echo !$jobOffer->getActive() ? 'selected' : ''; ?>>Inactiva</option>
          </select>
        </div>

        <div class="form-field">
          <label>Posición laboral</label>
          <select name="jobPositionId" class="form-control" required>
            <?php foreach ($jobPositionList as $jobPosition): ?>
              <option value="<?php echo $jobPosition->getJobPositionId(); ?>"
                <?php echo ($jobPosition->getJobPositionId() == $jobOffer->getJobPositionId()) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($jobPosition->getDescription()); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-field full">
          <label>Descripción</label>
          <textarea name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($jobOffer->getDescription()); ?></textarea>
        </div>

      </div>

      <div style="display:flex; justify-content:space-between; margin-top:1.5rem;">
        <a href="<?php echo FRONT_ROOT . 'AdminJobOffer/showListView/' . $jobOffer->getCompanyId(); ?>" class="btn-outline">Cancelar</a>
        <button type="submit" class="btn-dark-primary">Guardar cambios</button>
      </div>

    </form>
  </div>

  <a href="<?php echo FRONT_ROOT . 'AdminJobOffer/showListView/' . $jobOffer->getCompanyId(); ?>" class="page-back">← Volver a las ofertas</a>

</main>