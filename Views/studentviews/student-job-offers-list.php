<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Ofertas laborales disponibles</h1>
    </div>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Flyer</th>
          <th>Inicio</th>
          <th>Cierre</th>
          <th>Salario</th>
          <th>Descripción</th>
          <th>Compañía</th>
          <th style="text-align:center">Acción</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($jobOfferList)):
          foreach ($jobOfferList as $jobOffer): ?>
          <tr>

            <td>
              <?php if ($jobOffer->getFlyerImagePath()): ?>
                <img src="<?= str_replace('index.php', '', $_SERVER['PHP_SELF']) . 'uploads/job-offers/' . $jobOffer->getFlyerImagePath(); ?>"
                  alt="Flyer" style="width:48px; height:48px; object-fit:cover; border-radius:6px; border:0.5px solid #e0ddd8;">
              <?php else: ?>
                <span class="text-muted" style="font-size:11px;">—</span>
              <?php endif; ?>
            </td>

            <td class="text-muted" style="font-size:12px;"><?= $jobOffer->getStartDate(); ?></td>
            <td class="text-muted" style="font-size:12px;"><?= $jobOffer->getDeadline(); ?></td>

            <td style="font-size:13px; font-weight:500;">
              $<?= number_format($jobOffer->getSalary(), 2); ?>
            </td>

            <td style="font-size:12px; max-width:200px;">
              <div style="max-height:60px; overflow-y:auto; line-height:1.4;" class="text-muted">
                <?= htmlspecialchars($jobOffer->getDescription()); ?>
              </div>
            </td>

            <td style="font-size:13px; font-weight:500;"><?= htmlspecialchars($jobOffer->getCompanyName()) ?></td>

            <td style="text-align:center">
              <?php if ($this->applicationDAO->isStudentApplied($student->getStudentId(), $jobOffer->getJobOfferId())): ?>
                <span class="badge-pill">Aplicado</span>
              <?php else: ?>
                <a href="<?= FRONT_ROOT ?>StudentJobOffer/apply/<?= $jobOffer->getJobOfferId(); ?>" class="btn-sm btn-sm-success">Aplicar</a>
              <?php endif; ?>
            </td>

          </tr>
        <?php endforeach;
        else: ?>
          <tr>
            <td colspan="7" class="table-empty">No hay ofertas laborales activas disponibles.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <a href="<?php echo FRONT_ROOT . 'Home/menuStudent'; ?>" class="page-back">← Volver al dashboard</a>

</main>