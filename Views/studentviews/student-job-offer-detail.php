<main class="py-5">
    <div class="container">
        <h2 class="mb-4">Detalles de la Oferta</h2>
        
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><?php echo $jobPosition->getDescription(); ?></h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5>Empresa: <strong><?php echo $company->getName(); ?></strong></h5>
                        <p class="text-muted">Publicada el: <?php echo $jobOffer->getstartDate(); ?></p>
                        <hr>
                        <h6>Descripción del Puesto:</h6>
                        <p><?php echo $jobOffer->getDescription(); ?></p>
                    </div>
                    <div class="col-md-4 border-start">
                        <div class="d-grid gap-2">
                            <?php if (!$alreadyApplied): ?>
                                <a href="<?php echo FRONT_ROOT ?>StudentJobOffer/apply/<?php echo $jobOffer->getJobOfferId(); ?>" 
                                   class="btn btn-success btn-lg">Postularme Ahora</a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-lg" disabled>Ya postulado</button>
                            <?php endif; ?>
                            
                            <a href="<?php echo FRONT_ROOT ?>StudentJobOffer/showActiveJobOffers" 
                               class="btn btn-outline-primary">Volver al listado</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>