<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root" style="max-width:100%; padding:2rem 2.5rem;">

  <div class="page-header">
    <div>
      <h1 class="page-title">Postulantes</h1>
      <p class="page-subtitle"><?= htmlspecialchars($jobOffer->getTitle()) ?></p>
    </div>
  </div>

  <?php if (!empty($message)): ?>
    <div class="alert alert-<?= $messageType === 'success' ? 'success' : ($messageType === 'warning' ? 'warning' : 'danger') ?>" role="alert">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endif; ?>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Candidato</th>
          <th>Contacto</th>
          <th style="text-align:center">Fecha</th>
          <th style="text-align:center">Estado</th>
          <th style="text-align:center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($applicantList)):
          foreach ($applicantList as $student):
            $status = trim($student['status']);
        ?>
          <tr>

            <td style="font-weight:500;"><?= htmlspecialchars($student['firstName'] . ' ' . $student['lastName']) ?></td>

            <td>
              <a href="mailto:<?= htmlspecialchars($student['email']) ?>" class="text-muted" style="font-size:13px; text-decoration:none;">
                <?= htmlspecialchars($student['email']) ?>
              </a>
            </td>

            <td style="text-align:center; font-size:12px;" class="text-muted">
              <?= date('d/m/Y', strtotime($student['applicationDate'])) ?>
            </td>

            <td style="text-align:center">
              <?php if ($status === 'active'): ?>
                <span class="badge-pill">Pendiente</span>
              <?php elseif ($status === 'interview'): ?>
                <span class="badge-active">Entrevista</span>
              <?php else: ?>
                <span class="badge-inactive">Declinado</span>
              <?php endif; ?>
            </td>

            <td style="text-align:center">
              <div class="table-actions">
                <?php if ($status === 'active'): ?>

                  <button class="btn-sm btn-sm-success"
                    onclick="document.getElementById('modal-<?= $student['studentId'] ?>').style.display='flex'">
                    Entrevista
                  </button>

                  <a href="<?= FRONT_ROOT ?>CompanyJobOffer/declineApplicant/<?= $student['studentId'] ?>/<?= $jobOffer->getJobOfferId() ?>"
                     class="btn-sm btn-sm-danger"
                     onclick="return confirm('¿Declinar este postulante?')">Declinar</a>

                <?php elseif ($status === 'interview'): ?>
                  <span class="text-muted" style="font-size:12px;">Mail enviado</span>
                <?php else: ?>
                  <span class="text-muted" style="font-size:12px;">—</span>
                <?php endif; ?>
              </div>
            </td>

          </tr>

          <?php if ($status === 'active'): ?>
          <!-- Modal agendar entrevista -->
          <tr style="display:none;">
            <td colspan="5" style="padding:0; border:none;"></td>
          </tr>
          <div id="modal-<?= $student['studentId'] ?>"
               style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.3); z-index:999; align-items:center; justify-content:center;">
            <div class="card" style="max-width:480px; width:90%; position:relative;">
              <p class="page-title" style="font-size:16px; margin-bottom:1.25rem;">Agendar entrevista</p>

              <form action="<?= FRONT_ROOT ?>CompanyJobOffer/setInterviewStatus" method="POST">
                <input type="hidden" name="studentId" value="<?= $student['studentId'] ?>">
                <input type="hidden" name="jobOfferId" value="<?= $jobOffer->getJobOfferId() ?>">

                <div class="form-field">
                  <label>Alumno</label>
                  <input type="text" class="form-control" value="<?= htmlspecialchars($student['firstName'] . ' ' . $student['lastName']) ?>" readonly style="opacity:0.6; cursor:not-allowed;">
                </div>

                <div class="form-field">
                  <label>Fecha y hora</label>
                  <input type="datetime-local" name="date_time" class="form-control"
                    min="<?= date('Y-m-d\TH:i') ?>"
                    value="<?= date('Y-m-d\TH:i') ?>" required>
                </div>

                <div class="form-field" style="margin-bottom:1.5rem;">
                  <label>Link o ubicación</label>
                  <input type="text" name="location" class="form-control" placeholder="https://meet.google.com/..." required>
                </div>

                <div style="display:flex; justify-content:space-between;">
                  <button type="button" class="btn-outline"
                    onclick="document.getElementById('modal-<?= $student['studentId'] ?>').style.display='none'">
                    Cancelar
                  </button>
                  <button type="submit" class="btn-dark-primary">Confirmar y enviar mail</button>
                </div>
              </form>
            </div>
          </div>
          <?php endif; ?>

        <?php endforeach;
        else: ?>
          <tr>
            <td colspan="5" class="table-empty">No hay postulantes registrados aún.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <a href="<?= FRONT_ROOT ?>CompanyJobOffer/listMyOffers" class="page-back">← Volver a mis ofertas</a>

</main>