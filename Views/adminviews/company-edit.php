<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Editar compañía</h1>
      <p class="page-subtitle"><?php echo htmlspecialchars($company->getName()); ?></p>
    </div>
  </div>

  <div class="card" style="max-width: 900px;">
    <form action="<?php echo FRONT_ROOT . 'AdminCompany/update'; ?>" method="POST">

      <input type="hidden" name="companyId" value="<?php echo $company->getCompanyId(); ?>">

      <div class="form-grid" style="grid-template-columns: repeat(3, 1fr);">

        <div class="form-field">
          <label>Nombre</label>
          <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($company->getName()); ?>" required>
        </div>

        <div class="form-field">
          <label>CUIT <span class="text-muted" style="font-size:11px; text-transform:none;">(no editable)</span></label>
          <input type="text" name="cuit" class="form-control" value="<?php echo $company->getCuit(); ?>" readonly style="opacity:0.6; cursor:not-allowed;">
        </div>

        <div class="form-field">
          <label>Email</label>
          <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <div class="form-field">
          <label>Ciudad</label>
          <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($company->getCity()); ?>">
        </div>

        <div class="form-field">
          <label>Teléfono</label>
          <input type="text" name="phoneNumber" class="form-control" value="<?php echo htmlspecialchars($company->getPhoneNumber()); ?>">
        </div>

        <div class="form-field">
          <label>Estado</label>
          <select name="active" class="form-control">
            <option value="1" <?php echo $company->isActive() ? 'selected' : ''; ?>>Activa</option>
            <option value="0" <?php echo !$company->isActive() ? 'selected' : ''; ?>>Inactiva</option>
          </select>
        </div>

        <div class="form-field full">
          <label>Descripción</label>
          <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($company->getDescription()); ?></textarea>
        </div>

      </div>

      <div style="display:flex; justify-content:flex-end; margin-top:1.5rem;">
        <button type="submit" class="btn-dark-primary">Guardar cambios</button>
      </div>

    </form>
  </div>

  <a href="<?php echo FRONT_ROOT ?>AdminCompany/showCompaniesViews" class="page-back">← Volver a compañías</a>

</main>