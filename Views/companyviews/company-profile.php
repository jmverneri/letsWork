<?php
use Utils\Utils;
Utils::checkNav();
/** @var Models\Company $company */
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Perfil de compañía</h1>
    </div>
  </div>

  <?php if (!isset($company)): ?>
    <div class="alert alert-danger">Información de compañía no encontrada.</div>
    <?php return; ?>
  <?php endif; ?>

  <div class="card" style="max-width:700px;">

    <div style="display:grid; grid-template-columns:1fr 2fr; gap:0.75rem 1rem;">

      <span class="app-label" style="align-self:center;">Nombre</span>
      <span style="font-size:13px; font-weight:500;"><?= htmlspecialchars($company->getName()) ?></span>

      <span class="app-label" style="align-self:center;">CUIT</span>
      <span style="font-size:13px; font-family:monospace;"><?= htmlspecialchars($company->getCuit() ?? '—') ?></span>

      <span class="app-label" style="align-self:center;">Ciudad</span>
      <span style="font-size:13px;"><?= htmlspecialchars($company->getCity() ?? '—') ?></span>

      <span class="app-label" style="align-self:center;">Teléfono</span>
      <span style="font-size:13px;"><?= htmlspecialchars($company->getPhoneNumber() ?? '—') ?></span>

      <span class="app-label" style="align-self:flex-start; padding-top:2px;">Descripción</span>
      <span style="font-size:13px; line-height:1.6;"><?= nl2br(htmlspecialchars($company->getDescription() ?? '—')) ?></span>

    </div>

    <div style="display:flex; gap:10px; margin-top:1.75rem;">
      <a href="<?= FRONT_ROOT ?>Company/showEditView" class="btn-dark-primary">Editar información</a>
      <a href="<?= FRONT_ROOT ?>Company/dashboard" class="btn-outline">Volver al dashboard</a>
    </div>

  </div>

</main>