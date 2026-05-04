<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title"><?= htmlspecialchars($jobOffer->getTitle()) ?></h1>
    </div>
    <?= $jobOffer->getActive() ? '<span class="badge-active">Activa</span>' : '<span class="badge-inactive">Cerrada</span>' ?>
  </div>

  <div class="card" style="max-width:800px;">

    <div class="form-grid" style="margin-bottom:1.25rem;">

      <div>
        <label class="app-label">Carrera</label>
        <p style="font-size:13px; margin:0;"><?= htmlspecialchars($careerMap[$positionToCareerMap[$jobOffer->getJobPositionId()]] ?? 'N/A') ?></p>
      </div>

      <div>
        <label class="app-label">Posición</label>
        <p style="font-size:13px; margin:0;"><?= htmlspecialchars($positionMap[$jobOffer->getJobPositionId()] ?? 'N/A') ?></p>
      </div>

      <div>
        <label class="app-label">Fecha de inicio</label>
        <p style="font-size:13px; margin:0;"><?= $jobOffer->getStartDate() ?></p>
      </div>

      <div>
        <label class="app-label">Fecha de cierre</label>
        <p style="font-size:13px; margin:0;"><?= $jobOffer->getDeadline() ?></p>
      </div>

      <div>
        <label class="app-label">Salario</label>
        <p style="font-size:13px; font-weight:500; margin:0;">$<?= number_format($jobOffer->getSalary(), 2) ?></p>
      </div>

    </div>

    <div class="divider"></div>

    <label class="app-label" style="margin-bottom:6px; display:block;">Descripción</label>
    <p style="font-size:13px; color:#37352f; line-height:1.7; white-space:pre-line; margin:0;">
      <?= htmlspecialchars($jobOffer->getDescription()) ?>
    </p>

    <div style="display:flex; gap:10px; margin-top:1.75rem;">
      <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showEditForm/<?= $jobOffer->getJobOfferId() ?>" class="btn-dark-primary">Editar oferta</a>
      <a href="<?= FRONT_ROOT ?>CompanyJobOffer/listMyOffers" class="btn-outline">← Volver a la lista</a>
    </div>

  </div>

</main>