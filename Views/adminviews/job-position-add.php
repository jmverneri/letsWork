<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

<div class="page-header">
    <div>
        <h1 class="page-title">Gestión de puestos de trabajo</h1>
        <p class="page-subtitle">Crear, modificar y eliminar puestos asociados a una carrera.</p>
    </div>
</div>

<?php if (!empty($message)): ?>
    <div class="card" style="margin-bottom:1.5rem;">
        <p style="margin:0; font-size:13px;"><?= htmlspecialchars($message) ?></p>
    </div>
<?php endif; ?>

<div style="display:grid; grid-template-columns:1fr 2fr; gap:14px; align-items:start;">

    <!-- Alta de puesto -->
    <div class="card">
        <p style="font-size:13px; font-weight:500; color:#1c1b19; margin:0 0 4px;">Nuevo puesto</p>
        <p class="page-subtitle" style="font-size:12px; margin:0 0 1.25rem;">Asignalo a una carrera existente.</p>

        <form action="<?= FRONT_ROOT ?>JobPosition/addJobPosition" method="POST">
            <div class="form-field" style="margin-bottom:1rem;">
                <label>Carrera</label>
                <select name="careerId" class="form-control" required>
                    <option value="">Seleccionar carrera...</option>
                    <?php foreach ($careerList as $career): ?>
                        <option value="<?= $career->getCareerId() ?>">
                            <?= htmlspecialchars($career->getDescription()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-field" style="margin-bottom:1.25rem;">
                <label>Descripción del puesto</label>
                <input type="text" name="description" class="form-control" placeholder="Ej: Desarrollador Backend Jr." required>
            </div>

            <button type="submit" class="btn-dark-primary full">+ Crear puesto</button>
        </form>
    </div>

    <!-- Listado -->
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Carrera</th>
                    <th style="text-align:center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($jobsList)):
                    foreach ($jobsList as $jobPosition):
                        $career = null;
                        foreach ($careerList as $c) {
                            if ($c->getCareerId() == $jobPosition->getCareerId()) {
                                $career = $c;
                                break;
                            }
                        }
                ?>
                    <tr>
                        <td style="font-weight:500;"><?= htmlspecialchars($jobPosition->getDescription()) ?></td>
                        <td class="text-muted"><?= htmlspecialchars($career?->getDescription() ?? '—') ?></td>
                        <td style="text-align:center">
                            <a href="<?= FRONT_ROOT ?>JobPosition/showJobPositionViewById/<?= $jobPosition->getJobPositionId() ?>" class="btn-sm">Editar</a>
                            <a href="<?= FRONT_ROOT ?>JobPosition/deleteJobPosition/<?= $jobPosition->getJobPositionId() ?>"
                               class="btn-sm btn-sm-danger"
                               onclick="return confirm('¿Eliminar este puesto de trabajo?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach;
                else: ?>
                    <tr>
                        <td colspan="3" class="table-empty">No hay puestos de trabajo cargados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<a href="<?= FRONT_ROOT ?>Home/menuAdmin" class="page-back">← Volver al dashboard</a>

</main>