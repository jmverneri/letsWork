<nav class="navbar-app">
  <a class="navbar-brand-app" href="<?php echo FRONT_ROOT ?>Home/menuStudent">
    <img src="<?= IMG_PATH ?>Lets.png" alt="LetsWork">
    <span class="badge-pill">Estudiante</span>
  </a>

  <button class="navbar-toggler-app" onclick="document.getElementById('navStudent').classList.toggle('open')">
    &#9776;
  </button>

  <div class="navbar-links" id="navStudent">

    <a class="navbar-link" href="<?= FRONT_ROOT ?>StudentJobOffer/showMyApplications">Mis aplicaciones</a>
    <a class="navbar-link" href="<?php echo FRONT_ROOT ?>StudentJobOffer/showActiveJobOffers">Buscar trabajos</a>
    <a class="navbar-link" href="<?php echo FRONT_ROOT ?>StudentCompany/showCompaniesViews">Compañías</a>
    <a class="navbar-link" href="<?php echo FRONT_ROOT ?>Student/showStudentProfile">Mi perfil</a>

    <!-- Notificaciones -->
    <div class="notif-dropdown">
      <button class="notif-btn">
        <svg viewBox="0 0 32 32" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M16 4a7 7 0 0 1 7 7c0 5 2 7 3 8H6c1-1 3-3 3-8a7 7 0 0 1 7-7z"/>
          <path d="M13 19v1a3 3 0 0 0 6 0v-1"/>
        </svg>
        <?php $displayCant = $_SESSION['cantNotif'] ?? 0; ?>
        <?php if ($displayCant > 0): ?>
          <span class="notif-count"><?php echo $displayCant; ?></span>
        <?php endif; ?>
      </button>

      <div class="notif-menu">
        <p class="notif-header">Notificaciones</p>

        <?php $notifList = $_SESSION['unreadNotifications'] ?? []; ?>
        <?php if (!empty($notifList)): ?>
          <?php foreach ($notifList as $notif): ?>
            <a class="notif-item" href="<?php echo FRONT_ROOT ?>StudentJobOffer/showOfferDetails/<?php echo $notif->getJobOfferId(); ?>">
              <span class="notif-item-label">Nueva oferta</span>
              <span class="notif-item-text"><?php echo htmlspecialchars($notif->getMessage()); ?></span>
            </a>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="notif-empty">No hay notificaciones nuevas.</p>
        <?php endif; ?>

        <a class="notif-footer" href="<?php echo FRONT_ROOT ?>Notification/showListView">Ver todas →</a>
      </div>
    </div>

    <a class="navbar-logout" href="<?php echo FRONT_ROOT ?>Home/logout">Cerrar sesión</a>

  </div>
</nav>