<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">
  <div class="page-header">
    <div>
      <h1 class="page-title">Plataforma de administración</h1>
      <p class="page-subtitle">Supervisá y administrá el ecosistema entero.</p>
    </div>
    <span class="badge-pill">Server: Online</span>
  </div>

  <div class="dash-grid">

    <div class="card card-hover">
      <div class="dash-icon">
        <svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <rect x="4" y="10" width="24" height="18" rx="2"/>
          <path d="M10 10V7a6 6 0 0 1 12 0v3"/>
          <line x1="16" y1="17" x2="16" y2="21"/>
          <circle cx="16" cy="17" r="1" fill="#37352f" stroke="none"/>
        </svg>
      </div>
      <p class="dash-card-title">Compañías</p>
      <p class="dash-card-desc">Administrá las compañías y sus detalles.</p>
      <a href="<?= FRONT_ROOT ?>AdminCompany/showCompaniesViews" class="btn-outline">Ver lista</a>
      <a href="<?= FRONT_ROOT ?>Company/redirectAddForm" class="btn-dark-primary" style="margin-top:6px;">+ Agregar nueva</a>
    </div>

    <div class="card card-hover">
      <div class="dash-icon">
        <svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="13" width="26" height="16" rx="2"/>
          <path d="M10 13v-2a6 6 0 0 1 12 0v2"/>
          <line x1="3" y1="19" x2="29" y2="19"/>
          <line x1="12" y1="19" x2="12" y2="29"/>
          <line x1="20" y1="19" x2="20" y2="29"/>
        </svg>
      </div>
      <p class="dash-card-title">Ofertas laborales</p>
      <p class="dash-card-desc">Controlá todos los puestos y sus expiraciones.</p>
      <a href="<?= FRONT_ROOT ?>AdminJobOffer/showActiveJobOffers" class="btn-outline">Administrar activas</a>
      <a href="<?= FRONT_ROOT ?>AdminJobOffer/showExpiredJobOffers" class="btn-outline" style="margin-top:6px;">Revisar expiradas</a>
    </div>

    <div class="card card-hover">
      <div class="dash-icon">
        <svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="16" cy="10" r="5"/>
          <path d="M6 28c0-5.523 4.477-10 10-10s10 4.477 10 10"/>
        </svg>
      </div>
      <p class="dash-card-title">Estudiantes</p>
      <p class="dash-card-desc">Monitoreá la actividad y registros de estudiantes.</p>
      <a href="<?= FRONT_ROOT ?>Admin/showStudentList" class="btn-outline">Lista de estudiantes</a>
    </div>

    <div class="card card-hover">
      <div class="dash-icon">
        <svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 6h24v4L16 18 4 10V6z"/>
          <path d="M4 10v16h24V10"/>
          <line x1="12" y1="21" x2="20" y2="21"/>
          <line x1="12" y1="25" x2="20" y2="25"/>
        </svg>
      </div>
      <p class="dash-card-title">Gestión académica</p>
      <p class="dash-card-desc">Administrá el catálogo de materias por carrera.</p>
      <a href="<?= FRONT_ROOT ?>Admin/showAddSubjectView" class="btn-dark-primary">+ Crear materia</a>
      <a href="<?= FRONT_ROOT ?>Admin/showCareerSelection" class="btn-outline" style="margin-top:6px;">Ver todas</a>
    </div>

    <div class="card card-hover">
      <div class="dash-icon">
        <svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="16" cy="16" r="3"/>
          <path d="M16 4v3M16 25v3M4 16h3M25 16h3"/>
          <path d="M7.8 7.8l2.1 2.1M22.1 22.1l2.1 2.1M7.8 24.2l2.1-2.1M22.1 9.9l2.1-2.1"/>
        </svg>
      </div>
      <p class="dash-card-title">Sincronización</p>
      <p class="dash-card-desc">Actualizá datos de carrera desde la API externa.</p>
      <a href="<?= FRONT_ROOT ?>Admin/updateCareers" class="btn-outline">Actualizar carreras</a>
    </div>

    <div class="card card-hover">
      <div class="dash-icon">
        <svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="6" y1="28" x2="6" y2="18"/>
          <line x1="13" y1="28" x2="13" y2="12"/>
          <line x1="20" y1="28" x2="20" y2="16"/>
          <line x1="27" y1="28" x2="27" y2="6"/>
          <polyline points="3,18 6,15 9,20 13,12 17,16 20,13 24,8 27,6"/>
        </svg>
      </div>
      <p class="dash-card-title">Analíticas</p>
      <p class="dash-card-desc">Estadísticas de plataforma y actividad de ofertas.</p>
      <a href="<?= FRONT_ROOT ?>AdminJobOffer/ShowAnalytics" class="btn-dark-primary">Ver reportes</a>
    </div>

    <div class="card card-hover">
      <div class="dash-icon">
        <svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <rect x="5" y="11" width="22" height="17" rx="2"/>
          <path d="M11 11V8a5 5 0 0 1 10 0v3"/>
          <circle cx="16" cy="20" r="2"/>
          <line x1="16" y1="22" x2="16" y2="25"/>
        </svg>
      </div>
      <p class="dash-card-title">Seguridad</p>
      <p class="dash-card-desc">Administrá cuentas del sistema interno.</p>
      <a href="<?= FRONT_ROOT ?>Admin/showCreateUserForm" class="btn-outline">Agregar usuario</a>
    </div>

  </div>
</main>