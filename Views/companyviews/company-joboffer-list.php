<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Mis ofertas laborales</h1>
    </div>
    <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showAddView" class="btn-dark-primary">+ Nueva oferta</a>
  </div>

  <?php if (empty($jobOffers)): ?>
    <div class="alert alert-warning">No creaste ninguna oferta laboral todavía.</div>
  <?php else: ?>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Flyer</th>
            <th>Título</th>
            <th style="text-align:center">Carrera</th>
            <th style="text-align:center">Postulantes</th>
            <th style="text-align:center">Expira</th>
            <th style="text-align:center">Estado</th>
            <th style="text-align:center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($jobOffers as $jobOffer): ?>
            <tr>

              <td>
                <?php if ($jobOffer->getFlyerImagePath()): ?>
                  <img src="<?= str_replace('index.php', '', $_SERVER['PHP_SELF']) . 'uploads/job-offers/' . $jobOffer->getFlyerImagePath(); ?>"
                    alt="Flyer" style="width:48px; height:48px; object-fit:cover; border-radius:6px; border:0.5px solid #e0ddd8;">
                <?php else: ?>
                  <span class="text-muted" style="font-size:11px;">—</span>
                <?php endif; ?>
              </td>

              <td style="font-weight:500;"><?= htmlspecialchars($jobOffer->getTitle()) ?></td>

              <td style="text-align:center">
                <?php
                  $posId = $jobOffer->getJobPositionId();
                  $carId = $positionToCareerMap[$posId] ?? null;
                  echo '<span class="badge-pill">' . htmlspecialchars($careerMap[$carId] ?? 'N/A') . '</span>';
                ?>
              </td>

              <td style="text-align:center">
                <?php $count = $jobOffer->getApplicantCount(); ?>
                <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showApplicants/<?= $jobOffer->getJobOfferId() ?>"
                   class="btn-sm <?= $count > 0 ? 'btn-sm-success' : '' ?>">
                  <?= $count ?> aplicantes
                </a>
              </td>

              <td style="text-align:center; font-size:12px;" class="text-muted">
                <?= date('d/m/Y', strtotime($jobOffer->getDeadline())) ?>
              </td>

              <td style="text-align:center">
                <?= $jobOffer->getActive()
                  ? '<span class="badge-active">Activa</span>'
                  : '<span class="badge-inactive">Cerrada</span>' ?>
              </td>

              <td style="text-align:center">
                <div class="table-actions">
                  <a href="<?= FRONT_ROOT ?>CompanyJobOffer/viewDetails/<?= $jobOffer->getJobOfferId() ?>" class="btn-sm">Ver</a>

                  <?php if ($jobOffer->getActive()): ?>
                    <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showEditForm/<?= $jobOffer->getJobOfferId() ?>" class="btn-sm">Editar</a>
                    <a href="<?= FRONT_ROOT ?>CompanyJobOffer/delete/<?= $jobOffer->getJobOfferId() ?>"
                       class="btn-sm btn-sm-danger"
                       onclick="return confirm('¿Cerrar esta oferta?')">Cerrar</a>
                  <?php else: ?>
                    <a href="<?= FRONT_ROOT ?>CompanyJobOffer/reactive/<?= $jobOffer->getJobOfferId() ?>"
                       class="btn-sm btn-sm-success"
                       onclick="return confirm('¿Reactivar esta oferta?')">Reactivar</a>
                  <?php endif; ?>
                </div>
              </td>

            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  <?php endif; ?>

  <a href="<?= FRONT_ROOT ?>Home/menuCompany" class="page-back">← Volver al dashboard</a>

</main>