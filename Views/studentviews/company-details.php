<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-building"></i> Detalles de Companía</h4>
                        <a href="<?= FRONT_ROOT ?>StudentCompany/showCompaniesViews" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver a la Lista
                        </a>
                    </div>
                    
                    <div class="card-body">
                        <h2 class="card-title text-primary"><?= htmlspecialchars($company->getName()) ?></h2>
                        <hr>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">CUIT:</div>
                            <div class="col-sm-8"><?= htmlspecialchars($company->getCuit()) ?></div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">Ciudad:</div>
                            <div class="col-sm-8"><?= htmlspecialchars($company->getCity() ?? 'N/A') ?></div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">Teléfono:</div>
                            <div class="col-sm-8"><?= htmlspecialchars($company->getPhoneNumber() ?? 'N/A') ?></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4 font-weight-bold">Status:</div>
                            <div class="col-sm-8">
                                <?php if($company->isActive()): ?>
                                    <span class="badge badge-success">Activa</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inactiva</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mt-4">Descripción</h5>
                        <p class="text-muted border p-3 rounded bg-light">
                            <?= nl2br(htmlspecialchars($company->getDescription() ?? 'No description available.')) ?>
                        </p>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="<?= FRONT_ROOT ?>StudentJobOffer/showOffersByCompany/<?= $company->getCompanyId(); ?>" 
                           class="btn btn-primary">
                           <i class="fas fa-briefcase"></i> Ver Ofertas Laborales
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>