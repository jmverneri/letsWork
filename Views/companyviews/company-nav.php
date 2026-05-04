<nav class="navbar-app">
  <a class="navbar-brand-app" href="<?php echo FRONT_ROOT ?>Company/dashboard">
    <img src="<?= IMG_PATH ?>Lets.png" alt="LetsWork">
    <span class="navbar-brand-name">LetsWork</span>
    <span class="badge-pill">Compañía</span>
  </a>

  <button class="navbar-toggler-app" onclick="document.getElementById('navCompany').classList.toggle('open')">
    &#9776;
  </button>

  <div class="navbar-links" id="navCompany">
    <a class="navbar-link" href="<?php echo FRONT_ROOT ?>CompanyJobOffer/listMyOffers">Mis ofertas</a>
    <a class="navbar-link" href="<?php echo FRONT_ROOT ?>CompanyJobOffer/showInterviews">Mis entrevistas</a>
    <a class="navbar-link" href="<?php echo FRONT_ROOT ?>Company/profile">Perfil</a>
    <a class="navbar-logout" href="<?php echo FRONT_ROOT ?>Home/logout">Cerrar sesión</a>
  </div>
</nav>