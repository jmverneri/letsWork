<?php
use Utils\Utils;

Utils::checkNav();

/** @var Models\Company $company */
?>

<main class="py-5">
    <section class="container">

        <h2 class="mb-4 text-primary text-center">Perfil de Compañía</h2>

        <?php if (!isset($company)) : ?>
            <div class="alert alert-danger text-center">
                Información de Compañía no encontrada.
            </div>
        <?php return; endif; ?>

        <table class="table table-bordered bg-light-alpha">
            <tbody>

                <tr>
                    <th style="width: 30%">Nombre de Compañía</th>
                    <td><?= htmlspecialchars($company->getName()) ?></td>
                </tr>

                <tr>
                    <th>CUIT</th>
                    <td><?= htmlspecialchars($company->getCuit() ?? '—') ?></td>
                </tr>
                
                <tr>
                    <th>Ciudad</th>
                    <td><?= htmlspecialchars($company->getCity() ?? '—') ?></td>
                </tr>

                <tr>
                    <th>Descripción</th>
                    <td><?= nl2br(htmlspecialchars($company->getDescription() ?? '—')) ?></td>
                </tr>

                <tr>
                    <th>Nûmero de Teléfono</th>
                    <td><?= htmlspecialchars($company->getPhoneNumber() ?? '—') ?></td>
                </tr>

            </tbody>
        </table>

        <div class="text-center mt-4">
            <a class="btn btn-warning"
               href="<?= FRONT_ROOT ?>Company/showEditView">
                Editar Información de Compañía
            </a>

            <a class="btn btn-secondary"
               href="<?= FRONT_ROOT ?>Company/dashboard">
                BVolver al Dashboard
            </a>
        </div>

    </section>
</main>
