<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div style="text-align:center; margin-bottom:2.5rem;">
    <h1 class="page-title">Bienvenido, <?= htmlspecialchars($company->getName()) ?></h1>
    <p class="page-subtitle">Gestioná tus ofertas y la información de tu compañía.</p>
  </div>

  <div class="dash-grid" style="max-width:700px; margin:0 auto; grid-template-columns:repeat(2,1fr);">

    <div class="card card-hover" style="text-align:center; padding:1.75rem 1.25rem;">
      <div class="dash-icon" style="margin:0 auto 0.85rem;">
        <svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="13" width="26" height="16" rx="2"/>
          <path d="M10 13v-2a6 6 0 0 1 12 0v2"/>
          <line x1="3" y1="19" x2="29" y2="19"/>
          <line x1="12" y1="19" x2="12" y2="29"/>
          <line x1="20" y1="19" x2="20" y2="29"/>
        </svg>
      </div>
      <p class="dash-card-title">Ofertas laborales</p>
      <p class="dash-card-desc">Listarlas, editarlas o cerrar tus publicaciones activas.</p>
      <a href="<?= FRONT_ROOT ?>CompanyJobOffer/listMyOffers" class="btn-dark-primary">Ver mis ofertas</a>
      <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showAddView" class="btn-outline" style="margin-top:6px;">+ Publicar nueva oferta</a>
    </div>

    <div class="card card-hover" style="text-align:center; padding:1.75rem 1.25rem;">
      <div class="dash-icon" style="margin:0 auto 0.85rem;">
        <svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <rect x="4" y="10" width="24" height="18" rx="2"/>
          <path d="M10 10V7a6 6 0 0 1 12 0v3"/>
          <line x1="16" y1="17" x2="16" y2="21"/>
          <circle cx="16" cy="17" r="1" fill="#37352f" stroke="none"/>
        </svg>
      </div>
      <p class="dash-card-title">Configuración de compañía</p>
      <p class="dash-card-desc">Actualizá tu ubicación, descripción y datos de contacto.</p>
      <a href="<?= FRONT_ROOT ?>Company/profile" class="btn-outline">Ver perfil</a>
      <a href="<?= FRONT_ROOT ?>Company/showEditView" class="btn-outline" style="margin-top:6px;">Editar información</a>
    </div>

  </div>

</main>