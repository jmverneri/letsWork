<?php
use Utils\Utils;

Utils::checkNav();
?>

<form action="<?= FRONT_ROOT ?>Company/editCompany" method="POST" class="bg-light p-4 rounded shadow-sm">

    <input type="hidden" name="companyId" value="<?= $company->getCompanyId() ?>">

    <div class="mb-3">
        <label class="font-weight-bold">Nombre de Compañía</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($company->getName()) ?>" required>
    </div>

    <div class="mb-3">
        <label class="font-weight-bold">Contact Email (Usuario)</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
    </div>

    <div class="mb-3">
        <label class="font-weight-bold">CUIT</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($company->getCuit()) ?>" readonly>
        <input type="hidden" name="cuit" value="<?= $company->getCuit() ?>">
    </div>

    <div class="col-lg-6 mt-3">
        <label for="city"><b>Ciudad</b></label>
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

    <div class="mb-3">
        <label class="font-weight-bold">Número de teléfono</label>
        <input type="text" name="phoneNumber" class="form-control" value="<?= htmlspecialchars($company->getPhoneNumber() ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="font-weight-bold">Descripción</label>
        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($company->getDescription() ?? '') ?></textarea>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="<?= FRONT_ROOT ?>Company/profile" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
    </div>
</form>