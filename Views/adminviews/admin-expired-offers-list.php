<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Ofertas expiradas o inactivas</h1>
    </div>
    <div class="search-wrap">
      <span class="search-icon">&#9906;</span>
      <input type="text" id="positionSearch" placeholder="Buscar por posición...">
    </div>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Compañía</th>
          <th>Posición</th>
          <th style="text-align:center">Expiró</th>
          <th>Descripción</th>
          <th style="text-align:center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($jobOfferList)):
          foreach ($jobOfferList as $jobOffer):
            $compName = "N/A";
            foreach ($companiesList as $company) {
              if ($company->getCompanyId() == $jobOffer->getCompanyId()) {
                $compName = $company->getName();
                break;
              }
            }
        ?>
          <tr class="offer-row">

            <td>
              <span style="font-weight:500; font-size:12px; text-transform:uppercase; letter-spacing:0.04em;" class="text-muted">
                <?php echo htmlspecialchars($compName); ?>
              </span>
            </td>

            <td class="position-cell">
              <?php if ($jobOffer->getFlyerImagePath()): ?>
                <img src="<?= str_replace('index.php', '', $_SERVER['PHP_SELF']) . 'uploads/job-offers/' . $jobOffer->getFlyerImagePath(); ?>"
                  alt="Flyer" style="width:48px; height:48px; object-fit:cover; border-radius:6px; border:0.5px solid #e0ddd8; margin-bottom:6px; display:block;">
              <?php endif; ?>
              <strong style="font-size:13px;"><?php echo htmlspecialchars($jobOffer->getTitle()); ?></strong><br>
              <span class="badge-inactive" style="font-size:10px;">Cerrada</span>
            </td>

            <td style="text-align:center; font-size:12px;" class="text-muted">
              <?php echo $jobOffer->getDeadline(); ?>
            </td>

            <td style="font-size:12px; max-width:220px;">
              <div style="max-height:60px; overflow-y:auto; line-height:1.4;" class="text-muted">
                <?php echo nl2br(htmlspecialchars($jobOffer->getDescription())); ?>
              </div>
            </td>

            <td style="text-align:center">
              <div class="table-actions">
                <a href="<?= FRONT_ROOT ?>AdminJobOffer/showApplicants/<?= $jobOffer->getJobOfferId(); ?>" class="btn-sm">Aplicantes</a>
                <a href="<?= FRONT_ROOT ?>AdminJobOffer/restoreJobOffer/<?= $jobOffer->getJobOfferId(); ?>/<?= $jobOffer->getCompanyId(); ?>" class="btn-sm btn-sm-success">Reactivar</a>
              </div>
            </td>

          </tr>
        <?php endforeach;
        else: ?>
          <tr>
            <td colspan="5" class="table-empty">No se encontraron ofertas expiradas o inactivas.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <a href="<?= FRONT_ROOT ?>Admin/showDashboard" class="page-back">← Volver al dashboard</a>

</main>

<script>
  document.getElementById('positionSearch').addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    document.querySelectorAll('.offer-row').forEach(row => {
      const text = row.querySelector('.position-cell strong').textContent.toLowerCase();
      row.style.display = text.startsWith(filter) ? '' : 'none';
    });
  });
</script>