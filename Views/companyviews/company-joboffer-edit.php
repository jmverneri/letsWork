<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Editar oferta laboral</h1>
      <p class="page-subtitle"><?= htmlspecialchars($jobOffer->getTitle()) ?></p>
    </div>
  </div>

  <div class="card" style="max-width:800px;">
    <form action="<?= FRONT_ROOT ?>CompanyJobOffer/edit" method="POST">

      <input type="hidden" name="jobOfferId" value="<?= $jobOffer->getJobOfferId() ?>">

      <div class="form-grid">

        <div class="form-field">
          <label>Título</label>
          <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($jobOffer->getTitle()) ?>" required>
        </div>

        <div class="form-field">
          <label>Posición laboral</label>
          <select name="jobPositionId" class="form-control" required>
            <?php foreach ($jobPositions as $pos): ?>
              <option value="<?= $pos->getJobPositionId() ?>"
                <?= ($pos->getJobPositionId() == $jobOffer->getJobPositionId()) ? 'selected' : '' ?>>
                <?= htmlspecialchars($pos->getDescription()) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-field">
          <label>Salario</label>
          <input type="number" name="salary" class="form-control" step="0.01" value="<?= $jobOffer->getSalary() ?>">
        </div>

        <div class="form-field">
          <label>Fecha de inicio</label>
          <input type="date" name="startDate" class="form-control" value="<?= $jobOffer->getStartDate() ?>" required>
        </div>

        <div class="form-field">
          <label>Fecha de cierre</label>
          <input type="date" name="deadline" class="form-control" value="<?= $jobOffer->getDeadline() ?>" required>
        </div>

        <div class="form-field full">
          <label>Descripción</label>
          <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($jobOffer->getDescription()) ?></textarea>
        </div>

      </div>

      <div style="display:flex; justify-content:space-between; margin-top:1.5rem;">
        <a href="<?= FRONT_ROOT ?>CompanyJobOffer/listMyOffers" class="btn-outline">Cancelar</a>
        <button type="submit" class="btn-dark-primary">Guardar cambios</button>
      </div>

    </form>
  </div>

  <a href="<?= FRONT_ROOT ?>CompanyJobOffer/listMyOffers" class="page-back">← Volver a mis ofertas</a>

</main>