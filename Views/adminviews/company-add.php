<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Agregar nueva compañía</h1>
      <p class="page-subtitle">Completá los datos para registrar una nueva compañía.</p>
    </div>
  </div>

  <?php if (isset($this->message) && $this->message != ""): ?>
    <div class="alert alert-warning" role="alert">
      <?php echo $this->message; ?>
    </div>
  <?php endif; ?>

  <div class="card" style="max-width: 800px;">
    <form action="<?php echo FRONT_ROOT ?>Company/AddCompany" method="POST">

      <div class="form-grid">

        <div class="form-field">
          <label for="email">Email de compañía</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="admin@company.com" required>
          <span class="form-hint">Se usará para iniciar sesión. La clave será el CUIT.</span>
        </div>

        <div class="form-field">
          <label for="name">Nombre de compañía</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="Company Name S.A." required>
        </div>

        <div class="form-field">
          <label for="cuit">CUIT</label>
          <input type="text" name="cuit" id="cuit" class="form-control"
            placeholder="30123456789"
            pattern="^(30|33|34)\d{8}\d$"
            title="Debe empezar con 30, 33 o 34 y tener 11 dígitos sin guiones"
            required>
          <span class="form-hint">11 dígitos sin guiones (ej: 30123456789).</span>
        </div>

        <div class="form-field">
          <label for="city">Ciudad</label>
          <select name="city" id="city" class="form-control" required>
            <option value="" disabled selected>Seleccionar una ciudad...</option>
            <optgroup label="Buenos Aires">
              <option value="Mar del Plata">Mar del Plata</option>
              <option value="Bahía Blanca">Bahía Blanca</option>
              <option value="La Plata">La Plata</option>
              <option value="Tandil">Tandil</option>
              <option value="CABA">CABA</option>
            </optgroup>
            <optgroup label="Interior">
              <option value="Córdoba">Córdoba</option>
              <option value="Rosario">Rosario</option>
              <option value="Mendoza">Mendoza</option>
              <option value="Tucumán">Tucumán</option>
            </optgroup>
            <option value="Other">Other / Internacional</option>
          </select>
        </div>

        <div class="form-field">
          <label for="phoneNumber">Teléfono</label>
          <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" placeholder="2235123456">
        </div>

        <div class="form-field">
          <label for="logo">Logo URL</label>
          <input type="text" name="logo" id="logo" class="form-control" placeholder="http://example.com/logo.png">
        </div>

        <div class="form-field full">
          <label for="description">Descripción</label>
          <textarea name="description" id="description" class="form-control" rows="3" placeholder="Contanos sobre la compañía..."></textarea>
        </div>

      </div>

      <div style="display:flex; gap:10px; margin-top:1.5rem;">
        <button type="submit" class="btn-dark-primary">Agregar compañía</button>
        <a href="<?php echo FRONT_ROOT ?>AdminCompany/showCompaniesViews" class="btn-outline">Cancelar</a>
      </div>

    </form>
  </div>

  <a href="<?php echo FRONT_ROOT ?>AdminCompany/showCompaniesViews" class="page-back">← Volver a compañías</a>

</main>