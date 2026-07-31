<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

<div class="page-header">
    <div>
        <h1 class="page-title">Editar puesto de trabajo</h1>
    </div>
</div>

<?php if (!$jobPosition): ?>
    <div class="card">
        <p style="margin:0; font-size:13px;">No se encontró el puesto de trabajo solicitado.</p>
    </div>
<?php else: ?>
    <div class="card" style="max-width:480px;">
        <form action="<?= FRONT_ROOT ?>JobPosition/updateJobPosition" method="POST">
            <input type="hidden" name="jobPositionId" value="<?= $jobPosition->getJobPositionId() ?>">

            <div class="form-field" style="margin-bottom:1rem;">
                <label>Carrera</label>
                <select name="careerId" class="form-control" required>
                    <?php foreach ($careerList as $career): ?>
                        <option value="<?= $career->getCareerId() ?>"
                            <?= ($career->getCareerId() == $jobPosition->getCareerId()) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($career->getDescription()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-field" style="margin-bottom:1.25rem;">
                <label>Descripción del puesto</label>
                <input type="text" name="description" class="form-control"
                       value="<?= htmlspecialchars($jobPosition->getDescription()) ?>" required>
            </div>

            <button type="submit" class="btn-dark-primary full">Guardar cambios</button>
        </form>
    </div>
<?php endif; ?>

<a href="<?= FRONT_ROOT ?>JobPosition/showJobPositionAddView" class="page-back">← Volver al listado</a>

</main>