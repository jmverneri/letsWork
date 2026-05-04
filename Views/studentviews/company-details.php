<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title"><?= htmlspecialchars($company->getName()) ?></h1>
      <p class="page-subtitle">Detalles de la compañía</p>
    </div>
    <a href="<?= FRONT_ROOT ?>StudentCompany/showCompaniesViews" class="btn-outline">← Volver a la lista</a>
  </div>

  <div class="card" style="max-width:700px;">

    <div style="display:grid; grid-template-columns:1fr 2fr; gap:0.75rem 1rem; margin-bottom:1.25rem;">

      <span class="app-label" style="align-self:center;">CUIT</span>
      <span style="font-size:13px; font-family:monospace;"><?= htmlspecialchars($company->getCuit()) ?></span>

      <span class="app-label" style="align-self:center;">Ciudad</span>
      <span style="font-size:13px;"><?= htmlspecialchars($company->getCity() ?? 'N/A') ?></span>

      <span class="app-label" style="align-self:center;">Teléfono</span>
      <span style="font-size:13px;"><?= htmlspecialchars($company->getPhoneNumber() ?? 'N/A') ?></span>

      <span class="app-label" style="align-self:center;">Estado</span>
      <span><?= $company->isActive() ? '<span class="badge-active">Activa</span>' : '<span class="badge-inactive">Inactiva</span>' ?></span>

    </div>

    <div class="divider"></div>

    <label class="app-label" style="margin-bottom:6px; display:block;">Descripción</label>
    <p style="font-size:13px; color:#37352f; line-height:1.7; background:#f7f6f3; border:0.5px solid #e0ddd8; border-radius:8px; padding:12px 14px; margin:0;">
      <?= nl2br(htmlspecialchars($company->getDescription() ?? 'Sin descripción disponible.')) ?>
    </p>

    <div style="display:flex; justify-content:flex-end; margin-top:1.5rem;">
      <a href="<?= FRONT_ROOT ?>StudentJobOffer/showOffersByCompany/<?= $company->getCompanyId(); ?>" class="btn-dark-primary">
        Ver ofertas laborales
      </a>
    </div>

  </div>

  <a href="<?= FRONT_ROOT ?>StudentCompany/showCompaniesViews" class="page-back">← Volver a compañías</a>

</main>