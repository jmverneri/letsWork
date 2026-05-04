<?php
use Utils\Utils;
Utils::checkNav();

// Mapa de íconos SVG por carrera (se matchea por palabras clave en la descripción)
function getCareerIcon(string $description): string {
  $desc = strtolower($description);

  if (str_contains($desc, 'naval')) {
    return '<svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M4 22l2-8h20l2 8"/>
      <path d="M4 22c3 3 7 3 12 0s9-3 12 0"/>
      <line x1="16" y1="14" x2="16" y2="6"/>
      <path d="M16 6l5 4H16"/>
    </svg>';
  }

  if (str_contains($desc, 'pesquera') || str_contains($desc, 'pesca')) {
    return '<svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M4 16c4-6 10-8 16-4 3 2 5 4 5 4s-2 2-5 4c-6 4-12 2-16-4z"/>
      <circle cx="22" cy="16" r="1.5" fill="#37352f" stroke="none"/>
      <path d="M4 16c-1-2-1-4 0-6M4 16c-1 2-1 4 0 6"/>
    </svg>';
  }

  if (str_contains($desc, 'interior')) {
    return '<svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <rect x="3" y="6" width="26" height="20" rx="2"/>
      <line x1="3" y1="14" x2="14" y2="14"/>
      <line x1="14" y1="6" x2="14" y2="26"/>
      <rect x="17" y="18" width="7" height="8" rx="1"/>
      <line x1="6" y1="18" x2="11" y2="18"/>
      <line x1="6" y1="21" x2="11" y2="21"/>
    </svg>';
  }

  if (str_contains($desc, 'administraci')) {
    return '<svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <rect x="4" y="4" width="24" height="28" rx="2"/>
      <line x1="9" y1="11" x2="23" y2="11"/>
      <line x1="9" y1="16" x2="23" y2="16"/>
      <line x1="9" y1="21" x2="17" y2="21"/>
    </svg>';
  }

  if (str_contains($desc, 'ambiental') || str_contains($desc, 'ambiente')) {
    return '<svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M16 28V16"/>
      <path d="M16 16c0 0-8-2-8-10 0 0 8 2 8 10z"/>
      <path d="M16 20c0 0 6-4 10-10 0 0-8 0-10 10z"/>
      <path d="M8 28h16"/>
    </svg>';
  }

  if (str_contains($desc, 'textil') || str_contains($desc, 'producci')) {
    return '<svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M6 4c0 6 4 8 4 8s4-2 4-8"/>
      <path d="M18 4c0 6 4 8 4 8s4-2 4-8"/>
      <path d="M10 12v16M22 12v16"/>
      <line x1="10" y1="20" x2="22" y2="20"/>
      <line x1="6" y1="28" x2="26" y2="28"/>
    </svg>';
  }

  if (str_contains($desc, 'programaci') || str_contains($desc, 'sistemas') || str_contains($desc, 'software')) {
    return '<svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <rect x="3" y="6" width="26" height="20" rx="2"/>
      <polyline points="10,13 7,16 10,19"/>
      <polyline points="22,13 25,16 22,19"/>
      <line x1="15" y1="11" x2="17" y2="21"/>
    </svg>';
  }

  // Ícono genérico
  return '<svg viewBox="0 0 32 32" fill="none" stroke="#37352f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M4 6h24v4L16 18 4 10V6z"/>
    <path d="M4 10v16h24V10"/>
    <line x1="12" y1="21" x2="20" y2="21"/>
    <line x1="12" y1="25" x2="20" y2="25"/>
  </svg>';
}
?>

<main class="page-root">

  <div style="text-align:center; margin-bottom:2.5rem;">
    <h1 class="page-title">Seleccioná una carrera</h1>
    <p class="page-subtitle">Elegí una carrera para gestionar su plan de estudios y asignaturas.</p>
  </div>

  <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:14px; max-width:960px; margin:0 auto;">
    <?php foreach ($careerList as $career): ?>
      <a href="<?= FRONT_ROOT ?>Admin/showSubjectListByCareer/<?= $career->getCareerId() ?>"
         style="text-decoration:none;">
        <div class="card card-hover" style="text-align:center; padding:1.75rem 1.25rem;">
          <div class="dash-icon" style="margin:0 auto 0.85rem;">
            <?= getCareerIcon($career->getDescription()) ?>
          </div>
          <p style="font-size:11px; font-weight:500; color:#1c1b19; text-transform:uppercase; letter-spacing:0.04em; margin:0 0 6px; line-height:1.4;">
            <?= htmlspecialchars($career->getDescription()) ?>
          </p>
          <span style="font-size:11px; color:#9a9790;">Ver asignaturas →</span>
        </div>
      </a>
    <?php endforeach; ?>
  </div>

  <div style="text-align:center; margin-top:2rem;">
    <a href="<?= FRONT_ROOT ?>Admin/showDashboard" class="page-back" style="display:inline-flex;">← Volver al dashboard</a>
  </div>

</main>