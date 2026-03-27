<?php
use Utils\Utils;

Utils::checkNav();
?>

<form action="<?= FRONT_ROOT ?>CompanyJobOffer/edit" method="POST" class="bg-white p-4 shadow-sm rounded">
    <input type="hidden" name="jobOfferId" value="<?= $jobOffer->getJobOfferId() ?>">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Título</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($jobOffer->getTitle()) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Posición Laboral</label>
            <select name="jobPositionId" class="form-control" required>
                <?php foreach($jobPositions as $pos) { ?>
                    <option value="<?= $pos->getJobPositionId() ?>" <?= ($pos->getJobPositionId() == $jobOffer->getJobPositionId()) ? 'selected' : '' ?>>
                        <?= $pos->getDescription() ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Salario</label>
            <input type="number" name="salary" class="form-control" step="0.01" value="<?= $jobOffer->getSalary() ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label>Fecha de Comienzo</label>
            <input type="date" name="startDate" class="form-control" value="<?= $jobOffer->getStartDate() ?>" required>
        </div>
        <div class="col-md-4 mb-3">
            <label>Fin</label>
            <input type="date" name="deadline" class="form-control" value="<?= $jobOffer->getDeadline() ?>" required>
        </div>
    </div>

    <div class="mb-4">
        <label>Descripción</label>
        <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($jobOffer->getDescription()) ?></textarea>
    </div>

    <div class="d-flex justify-content-end">
        <a href="<?= FRONT_ROOT ?>CompanyJobOffer/listMyOffers" class="btn btn-secondary mr-2">Cancel</a>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </div>
</form>