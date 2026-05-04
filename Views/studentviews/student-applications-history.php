<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Mis postulaciones</h1>
    </div>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Compañía</th>
          <th>Posición</th>
          <th style="text-align:center">Fecha</th>
          <th style="text-align:center">Estado oferta</th>
          <th style="text-align:center">Mi estado</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($applicationList)):
          foreach ($applicationList as $app):
            $isOfferOpen = ($app['isRealActive'] == 1);
            $status = trim($app['appStatus']);
        ?>
          <tr style="<?= $status === 'declined' ? 'opacity:0.55;' : '' ?>">

            <td>
              <span style="font-size:12px; font-weight:500; text-transform:uppercase; letter-spacing:0.04em;">
                <?= htmlspecialchars($app['companyName']) ?>
              </span>
            </td>

            <td style="font-weight:500; font-size:13px;"><?= htmlspecialchars($app['title']) ?></td>

            <td style="text-align:center; font-size:12px;" class="text-muted">
              <?= date('d/m/Y', strtotime($app['applicationDate'])) ?>
            </td>

            <td style="text-align:center">
              <span class="<?= $isOfferOpen ? 'badge-active' : 'badge-inactive' ?>">
                <?= $isOfferOpen ? 'Abierta' : 'Cerrada' ?>
              </span>
            </td>

            <td style="text-align:center">
              <?php if ($status === 'active'): ?>
                <span class="badge-pill">En revisión</span>

              <?php elseif ($status === 'declined'): ?>
                <span class="badge-inactive">Declinada</span>

              <?php elseif ($status === 'completed'): ?>
                <div>
                  <span class="badge-active">Entrevista realizada</span>
                  <p class="text-muted" style="font-size:10px; margin:2px 0 0;">Esperando resolución</p>
                </div>

              <?php elseif ($status === 'interview'): ?>
                <div>
                  <span class="badge-active" style="margin-bottom:4px; display:inline-block;">¡Entrevista!</span><br>
                  <button class="btn-sm" onclick="document.getElementById('modal-<?= $app['studentId'] ?>_<?= $app['jobOfferId'] ?>').style.display='flex'">
                    Ver detalles
                  </button>
                </div>

                <!-- Modal entrevista -->
                <div id="modal-<?= $app['studentId'] ?>_<?= $app['jobOfferId'] ?>"
                     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.3); z-index:999; align-items:center; justify-content:center;">
                  <div class="card" style="max-width:440px; width:90%; position:relative;">
                    <p class="page-title" style="font-size:16px; margin-bottom:1.25rem;">Detalles de la entrevista</p>

                    <div class="form-field">
                      <label>Empresa</label>
                      <p style="font-size:14px; font-weight:500; margin:0;"><?= htmlspecialchars($app['companyName']) ?></p>
                    </div>

                    <div class="form-field">
                      <label>Fecha y hora</label>
                      <p style="font-size:14px; font-weight:500; margin:0;"><?= date('d/m/Y - H:i', strtotime($app['interviewDate'])) ?> hs</p>
                    </div>

                    <div class="form-field">
                      <label>Lugar o link</label>
                      <p style="font-size:13px; margin:0; word-break:break-all;">
                        <a href="<?= htmlspecialchars($app['interviewLocation']) ?>" target="_blank" style="color:#37352f;">
                          <?= htmlspecialchars($app['interviewLocation']) ?>
                        </a>
                      </p>
                    </div>

                    <div class="alert alert-warning" style="font-size:12px; text-align:center; margin-top:0.75rem;">
                      Por favor, confirmá tu asistencia por mail.
                    </div>

                    <div style="display:flex; justify-content:flex-end; margin-top:1rem;">
                      <button class="btn-outline" onclick="document.getElementById('modal-<?= $app['studentId'] ?>_<?= $app['jobOfferId'] ?>').style.display='none'">
                        Cerrar
                      </button>
                    </div>
                  </div>
                </div>

              <?php else: ?>
                <span class="text-muted" style="font-size:12px;">—</span>
              <?php endif; ?>
            </td>

          </tr>
        <?php endforeach;
        else: ?>
          <tr>
            <td colspan="5" class="table-empty">Aún no te postulaste a ninguna oferta de trabajo.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <a href="<?php echo FRONT_ROOT . 'Home/menuStudent'; ?>" class="page-back">← Volver al dashboard</a>

</main>