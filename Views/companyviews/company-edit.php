<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Editar información</h1>
      <p class="page-subtitle">Actualizá los datos de tu compañía.</p>
    </div>
  </div>

  <div class="card" style="max-width:700px;">
    <form action="<?= FRONT_ROOT ?>Company/editCompany" method="POST">

      <input type="hidden" name="companyId" value="<?= $company->getCompanyId() ?>">
      <input type="hidden" name="cuit" value="<?= $company->getCuit() ?>">

      <div class="form-grid">

        <div class="form-field">
          <label>Nombre de compañía</label>
          <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($company->getName()) ?>" required>
        </div>

        <div class="form-field">
          <label>Email de contacto</label>
          <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
        </div>

        <div class="form-field">
          <label>CUIT <span class="text-muted" style="font-size:11px; text-transform:none;">(no editable)</span></label>
          <input type="text" class="form-control" value="<?= htmlspecialchars($company->getCuit()) ?>" readonly style="opacity:0.6; cursor:not-allowed;">
        </div>

        <div class="form-field">
          <label>Ciudad</label>
          <select name="city" id="city" class="form-control" required>
            <option value="" disabled selected>Seleccionar una ciudad...</option>
            <optgroup label="Buenos Aires">
              <option value="Mar del Plata" <?= $company->getCity() === 'Mar del Plata' ? 'selected' : '' ?>>Mar del Plata</option>
              <option value="Bahía Blanca" <?= $company->getCity() === 'Bahía Blanca' ? 'selected' : '' ?>>Bahía Blanca</option>
              <option value="La Plata" <?= $company->getCity() === 'La Plata' ? 'selected' : '' ?>>La Plata</option>
              <option value="Tandil" <?= $company->getCity() === 'Tandil' ? 'selected' : '' ?>>Tandil</option>
              <option value="CABA" <?= $company->getCity() === 'CABA' ? 'selected' : '' ?>>CABA</option>
            </optgroup>
            <optgroup label="Interior">
              <option value="Córdoba" <?= $company->getCity() === 'Córdoba' ? 'selected' : '' ?>>Córdoba</option>
              <option value="Rosario" <?= $company->getCity() === 'Rosario' ? 'selected' : '' ?>>Rosario</option>
              <option value="Mendoza" <?= $company->getCity() === 'Mendoza' ? 'selected' : '' ?>>Mendoza</option>
              <option value="Tucumán" <?= $company->getCity() === 'Tucumán' ? 'selected' : '' ?>>Tucumán</option>
            </optgroup>
            <option value="Other" <?= $company->getCity() === 'Other' ? 'selected' : '' ?>>Other / Internacional</option>
          </select>
        </div>

        <div class="form-field">
          <label>Teléfono</label>
          <input type="text" name="phoneNumber" class="form-control" value="<?= htmlspecialchars($company->getPhoneNumber() ?? '') ?>">
        </div>

        <div class="form-field full">
          <label>Descripción</label>
          <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($company->getDescription() ?? '') ?></textarea>
        </div>

      </div>

      <div style="display:flex; justify-content:space-between; margin-top:1.5rem;">
        <a href="<?= FRONT_ROOT ?>Company/profile" class="btn-outline">Cancelar</a>
        <button type="submit" class="btn-dark-primary">Actualizar perfil</button>
      </div>

    </form>
  </div>

  <a href="<?= FRONT_ROOT ?>Company/profile" class="page-back">← Volver al perfil</a>

</main>