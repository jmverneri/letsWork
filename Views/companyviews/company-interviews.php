<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Agenda de entrevistas</h1>
    </div>
  </div>

  <?php if (!empty($interviewList)): ?>

    <div class="iv-grid">
      <?php foreach ($interviewList as $inter):
        $date   = strtotime($inter['date_time']);
        $isPast = $date < time();
        $status = $inter['interviewStatus'];
        $idInter = $inter['interviewId'] ?? null;

        $statusBadge = match($status) {
          'scheduled' => '<span class="badge-pill">Programada</span>',
          'completed' => '<span class="badge-active">Realizada</span>',
          'cancelled' => '<span class="badge-inactive">Cancelada</span>',
          default     => '<span class="badge-pill">' . htmlspecialchars($status) . '</span>',
        };
      ?>
        <div class="iv-card <?= $isPast ? 'past' : '' ?>">

          <div class="iv-card-header">
            <span class="iv-date"><?= date('d/m/Y — H:i', $date) ?> hs</span>
            <?= $statusBadge ?>
          </div>

          <div class="iv-body">
            <p class="iv-name"><?= htmlspecialchars($inter['firstName'] . ' ' . $inter['lastName']) ?></p>
            <p class="iv-job"><?= htmlspecialchars($inter['jobTitle']) ?></p>
            <a class="iv-email" href="mailto:<?= htmlspecialchars($inter['email']) ?>">
              <?= htmlspecialchars($inter['email']) ?>
            </a>
            <div class="iv-location">
              <a href="<?= htmlspecialchars($inter['location_or_link']) ?>" target="_blank"
                 style="color:#9a9790; text-decoration:none;">
                <?= htmlspecialchars($inter['location_or_link']) ?>
              </a>
            </div>
          </div>

          <div class="iv-footer">
            <?php if ($status === 'scheduled'): ?>
              <div class="table-actions">
                <a href="<?= FRONT_ROOT ?>CompanyJobOffer/changeInterviewStatus/<?= $idInter ?>/completed"
                   class="btn-sm btn-sm-success">Finalizar</a>
                <a href="<?= FRONT_ROOT ?>CompanyJobOffer/changeInterviewStatus/<?= $idInter ?>/cancelled"
                   class="btn-sm btn-sm-danger"
                   onclick="return confirm('¿Cancelar esta entrevista?')">Cancelar</a>
              </div>
            <?php else: ?>
              <span class="text-muted" style="font-size:11px;">
                <?= $status === 'completed' ? 'Realizada el ' . date('d/m', $date) : 'Cita anulada' ?>
              </span>
            <?php endif; ?>
          </div>

        </div>
      <?php endforeach; ?>
    </div>

  <?php else: ?>

    <div class="card" style="text-align:center; padding:3rem; max-width:500px; margin:0 auto;">
      <p class="page-title" style="font-size:16px; margin-bottom:8px;">Sin entrevistas programadas</p>
      <p class="text-muted" style="font-size:13px; margin-bottom:1.5rem;">No tenés entrevistas programadas por el momento.</p>
      <a href="<?= FRONT_ROOT ?>CompanyJobOffer/listMyOffers" class="btn-dark-primary" style="display:inline-block;">Ver mis ofertas</a>
    </div>

  <?php endif; ?>

  <a href="<?= FRONT_ROOT ?>Home/menuCompany" class="page-back">← Volver al dashboard</a>

</main>