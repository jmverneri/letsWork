<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title"><?php echo htmlspecialchars($jobPosition->getDescription()); ?></h1>
      <p class="page-subtitle"><?php echo htmlspecialchars($company->getName()); ?></p>
    </div>
  </div>

  <div style="display:grid; grid-template-columns: 2fr 1fr; gap:14px; max-width:900px; align-items:start;">

    <!-- Detalle -->
    <div class="card">
      <p class="text-muted" style="font-size:12px; margin:0 0 1rem;">
        Publicada el <?php echo $jobOffer->getStartDate(); ?>
      </p>
      <div class="divider"></div>
      <label style="font-size:12px; font-weight:500; color:#9a9790; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px; display:block;">
        Descripción del puesto
      </label>
      <p style="font-size:13px; color:#37352f; line-height:1.7; margin:0;">
        <?php echo nl2br(htmlspecialchars($jobOffer->getDescription())); ?>
      </p>
    </div>

    <!-- Acciones -->
    <div class="card" style="display:flex; flex-direction:column; gap:8px;">
      <?php if (!$alreadyApplied): ?>
        <a href="<?php echo FRONT_ROOT ?>StudentJobOffer/apply/<?php echo $jobOffer->getJobOfferId(); ?>"
           class="btn-dark-primary" style="text-align:center;">Postularme ahora</a>
      <?php else: ?>
        <button class="btn-outline" disabled style="opacity:0.5; cursor:not-allowed; text-align:center;">Ya postulado</button>
      <?php endif; ?>
      <a href="<?php echo FRONT_ROOT ?>StudentJobOffer/showActiveJobOffers" class="btn-outline" style="text-align:center;">
        ← Volver al listado
      </a>
    </div>

  </div>

  <a href="<?php echo FRONT_ROOT ?>Home/menuStudent" class="page-back">← Volver al dashboard</a>

</main>