<?php
    use Utils\Utils;
    Utils::checkNav();
?>

<main class="py-5">
    <div class="container text-center">
        <h2 class="mb-4">Bienvenido, <?= htmlspecialchars($company->getName()) ?></h2>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-primary">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Ofertas Laborales</h4>
                        <p class="text-muted small">Listar, editar o cerrar tus publicaciones activas.</p>
                        <a href="<?= FRONT_ROOT ?>CompanyJobOffer/listMyOffers" class="btn btn-primary btn-block">Ver Mis Ofertas</a>
                        <a href="<?= FRONT_ROOT ?>CompanyJobOffer/showAddView" class="btn btn-outline-primary btn-block">Publicar Nueva Oferta</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Configuración de Compañía</h4>
                        <p class="text-muted small">Actualizá tu locaciónn, descripción y datos de contacto.</p>
                        <a href="<?= FRONT_ROOT ?>Company/profile" class="btn btn-secondary btn-block">Ver Perfil</a>
                        <a href="<?= FRONT_ROOT ?>Company/showEditView" class="btn btn-outline-secondary btn-block">Editar Información</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>