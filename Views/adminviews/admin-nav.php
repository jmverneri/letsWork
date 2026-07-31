<nav class="navbar-app">
  <a class="navbar-brand-app" href="<?php echo FRONT_ROOT ?>Home/menuAdmin">
    <img src="<?= IMG_PATH ?>Lets.png" alt="LetsWork">
    <span class="badge-pill">Admin</span>
  </a>

  <button class="navbar-toggler-app" onclick="document.getElementById('navLinks').classList.toggle('open')">
    &#9776;
  </button>

  <div class="navbar-links" id="navLinks">

    <a class="navbar-link" href="<?= FRONT_ROOT ?>AdminCompany/showCompaniesViews">Compañías</a>

    <div class="navbar-dropdown">
      <a class="navbar-link" href="#">Ofertas ↓</a>
      <div class="navbar-dropdown-menu">
        <a class="navbar-dropdown-item" href="<?php echo FRONT_ROOT ?>AdminJobOffer/showActiveJobOffers">Ofertas activas</a>
        <a class="navbar-dropdown-item" href="<?php echo FRONT_ROOT ?>AdminJobOffer/showExpiredJobOffers">Ofertas expiradas</a>
        <div class="navbar-dropdown-divider"></div>
        <a class="navbar-dropdown-item" href="<?php echo FRONT_ROOT ?>AdminJobOffer/showAddView">+ Publicar nueva oferta</a>
      </div>
    </div>

    <a class="navbar-link" href="<?= FRONT_ROOT ?>Admin/showStudentList">Estudiantes</a>

    <a class="navbar-link" href="<?= FRONT_ROOT ?>JobPosition/showJobPositionAddView">Puestos de trabajo</a>

    <a class="navbar-logout" href="<?php echo FRONT_ROOT ?>Home/Logout">Cerrar sesión</a>

  </div>
</nav>