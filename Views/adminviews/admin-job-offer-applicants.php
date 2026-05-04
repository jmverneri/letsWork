<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Aplicantes</h1>
      <p class="page-subtitle"><?php echo htmlspecialchars($jobOffer->getTitle()); ?></p>
    </div>
    <span class="badge-pill">Total: <?php echo count($applicantList); ?></span>
  </div>

  <div style="margin-bottom:1.25rem;">
    <a href="<?= FRONT_ROOT ?>AdminJobOffer/generateApplicantsPDF/<?= $jobOffer->getJobOfferId() ?>"
       class="btn-dark-primary" target="_blank">Descargar PDF</a>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Nombre completo</th>
          <th>Email</th>
          <th style="text-align:center">Fecha de aplicación</th>
          <th style="text-align:center">Estado</th>
          <th style="text-align:center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($applicantList)):
          foreach ($applicantList as $student):
            $isDeclined = ($student['status'] == 'declined');
        ?>
          <tr style="<?= $isDeclined ? 'opacity:0.55;' : '' ?>">

            <td style="font-weight:500;">
              <?php echo htmlspecialchars($student['firstName'] . ' ' . $student['lastName']); ?>
            </td>

            <td class="text-muted"><?php echo htmlspecialchars($student['email']); ?></td>

            <td style="text-align:center; font-size:12px;" class="text-muted">
              <?php echo date('d/m/Y H:i', strtotime($student['applicationDate'])); ?>
            </td>

            <td style="text-align:center">
              <?php if (!$isDeclined): ?>
                <span class="badge-active">Activa</span>
              <?php else: ?>
                <span class="badge-inactive">Declinada</span>
              <?php endif; ?>
            </td>

            <td style="text-align:center">
              <div class="table-actions">
                <?php if (!$isDeclined): ?>
                  <a href="<?= FRONT_ROOT ?>AdminJobOffer/declineApplicant/<?= $student['studentId']; ?>/<?= $jobOffer->getJobOfferId(); ?>"
                     class="btn-sm btn-sm-danger"
                     onclick="return confirm('¿Declinar esta postulación?')">Declinar</a>
                <?php else: ?>
                  <span class="btn-sm" style="opacity:0.5; cursor:default;">Procesada</span>
                <?php endif; ?>
              </div>
            </td>

          </tr>
        <?php endforeach;
        else: ?>
          <tr>
            <td colspan="5" class="table-empty">No hay estudiantes aplicados para esta posición.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php $lastList = $_SESSION['last_job_offer_list'] ?? 'showActiveJobOffers'; ?>
  <a href="<?php echo FRONT_ROOT . 'AdminJobOffer/' . $lastList; ?>" class="page-back">← Volver a las ofertas</a>

</main>