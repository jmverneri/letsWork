<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div style="text-align:center; margin-bottom:2.5rem;">
    <h1 class="page-title">Bienvenido a tu panel</h1>
    <p class="page-subtitle">Encontrá el próximo movimiento en tu carrera y gestioná tus preferencias.</p>
  </div>

  <div class="dash-grid" style="max-width:900px; margin:0 auto;">

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
      <p class="dash-card-title">Trabajos</p>
      <p class="dash-card-desc">Buscá ofertas y aplicá a las que se ajusten a tu perfil.</p>
      <a href="<?= FRONT_ROOT ?>StudentJobOffer/showActiveJobOffers" class="btn-dark-primary">Explorar</a>
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
      <p class="dash-card-title">Compañías</p>
      <p class="dash-card-desc">Aprendé más sobre las empresas registradas en nuestra red.</p>
      <a href="<?= FRONT_ROOT ?>StudentCompany/showCompaniesViews" class="btn-outline">Ver directorio</a>
    </div>

    <div class="card card-hover" style="text-align:center; padding:1.75rem 1.25rem;">
      <div class="dash-icon" style="margin:0 auto 0.85rem;">
        <svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="16" cy="10" r="5"/>
          <path d="M6 28c0-5.523 4.477-10 10-10s10 4.477 10 10"/>
        </svg>
      </div>
      <p class="dash-card-title">Mi perfil</p>
      <p class="dash-card-desc">Revisá tu estatus académico y mantené tus datos al día.</p>
      <a href="<?= FRONT_ROOT ?>Student/showStudentProfile" class="btn-outline">Mi info</a>
    </div>

    <div class="card card-hover" style="text-align:center; padding:1.75rem 1.25rem;">
      <div class="dash-icon" style="margin:0 auto 0.85rem;">
        <svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M16 4a7 7 0 0 1 7 7c0 5 2 7 3 8H6c1-1 3-3 3-8a7 7 0 0 1 7-7z"/>
          <path d="M13 19v1a3 3 0 0 0 6 0v-1"/>
        </svg>
      </div>
      <p class="dash-card-title">Alertas</p>
      <p class="dash-card-desc">Configurá tus intereses para recibir avisos personalizados.</p>
      <a href="<?= FRONT_ROOT ?>Student/showPreferencesView" class="btn-outline">Configurar</a>
    </div>

  </div>

</main>