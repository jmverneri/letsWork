<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Historial de notificaciones</h1>
    </div>
  </div>

  <?php if (!empty($notificationList)): ?>
    <div style="display:flex; flex-direction:column; gap:8px; max-width:700px;">
      <?php foreach ($notificationList as $notif): ?>
        <a href="<?php echo FRONT_ROOT ?>StudentJobOffer/showOfferDetails/<?php echo $notif->getJobOfferId(); ?>"
           style="text-decoration:none;">
          <div class="card" style="padding:1rem 1.25rem; display:flex; flex-direction:row; align-items:flex-start; gap:12px; opacity:<?= $notif->getIsRead() ? '0.6' : '1' ?>;">
            <div style="flex-shrink:0; margin-top:2px;">
              <?php if ($notif->getIsRead()): ?>
                <span class="badge-pill">Leída</span>
              <?php else: ?>
                <span class="badge-active">Nueva</span>
              <?php endif; ?>
            </div>
            <p style="font-size:13px; color:#37352f; margin:0; line-height:1.5;">
              <?= htmlspecialchars($notif->getMessage()) ?>
            </p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="text-muted" style="font-size:13px;">No tenés notificaciones por el momento.</p>
  <?php endif; ?>

  <a href="<?php echo FRONT_ROOT ?>Home/menuStudent" class="page-back">← Volver al dashboard</a>

</main>