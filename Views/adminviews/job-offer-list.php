<?php
use Utils\Utils;
Utils::checkNav();

$companyName = "Compañía";
if (!empty($jobOfferList) && !empty($companiesList)) {
    foreach ($companiesList as $company) {
        if ($company->getCompanyId() == $jobOfferList[0]->getCompanyId()) {
            $companyName = $company->getName();
            break;
        }
    }
}
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Ofertas laborales</h1>
      <p class="page-subtitle"><?= htmlspecialchars($companyName) ?></p>
    </div>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Posición</th>
          <th style="text-align:center">Fechas</th>
          <th style="text-align:center">Salario</th>
          <th>Descripción</th>
          <th style="text-align:center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($jobOfferList)):
          foreach ($jobOfferList as $jobOffer):
            $isActive = $jobOffer->getActive();
        ?>
          <tr style="<?= !$isActive ? 'opacity:0.55;' : '' ?>">

            <td>
              <span style="font-weight:500; font-size:13px; display:block; margin-bottom:4px;">
                <?= htmlspecialchars($jobOffer->getTitle()) ?>
              </span>
              <?= $isActive ? '<span class="badge-active">Activa</span>' : '<span class="badge-inactive">Inactiva</span>' ?>
            </td>

            <td style="text-align:center; font-size:12px;" class="text-muted">
              <?= $jobOffer->getStartDate() ?><br>
              <?= $jobOffer->getDeadline() ?>
            </td>

            <td style="text-align:center; font-size:13px; font-weight:500; color:#2d7a4a;">
              $<?= number_format($jobOffer->getSalary(), 2) ?>
            </td>

            <td style="font-size:12px; max-width:240px;">
              <div style="max-height:70px; overflow-y:auto; line-height:1.4;" class="text-muted">
                <?= nl2br(htmlspecialchars($jobOffer->getDescription())) ?>
              </div>
            </td>

            <td style="text-align:center">
              <div class="table-actions">
                <a href="<?= FRONT_ROOT ?>AdminJobOffer/showModifyJobOfferView/<?= $jobOffer->getJobOfferId() ?>" class="btn-sm">Editar</a>

                <?php if ($isActive): ?>
                  <a href="<?= FRONT_ROOT ?>AdminJobOffer/deleteJobOffer/<?= $jobOffer->getJobOfferId() ?>/<?= $jobOffer->getCompanyId() ?>"
                     class="btn-sm btn-sm-danger"
                     onclick="return confirm('¿Desactivar esta oferta?')">Borrar</a>
                <?php else: ?>
                  <a href="<?= FRONT_ROOT ?>AdminJobOffer/restoreJobOffer/<?= $jobOffer->getJobOfferId() ?>/<?= $jobOffer->getCompanyId() ?>"
                     class="btn-sm btn-sm-success">Restaurar</a>
                <?php endif; ?>
              </div>
            </td>

          </tr>
        <?php endforeach;
        else: ?>
          <tr>
            <td colspan="5" class="table-empty">Sin ofertas encontradas.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <a href="<?= FRONT_ROOT ?>AdminCompany/showCompaniesViews" class="page-back">← Volver a compañías</a>

</main>