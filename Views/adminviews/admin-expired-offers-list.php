<?php
use Utils\Utils;
Utils::checkNav();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<main class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="color: #dc3545; border-bottom: 2px solid #dc3545; padding-bottom: 10px;">
                <i class="fas fa-history"></i> Ofertas Laborales Expiradas o Inactivas
            </h2>
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 10px; top: 10px; color: #aaa;"></i>
                <input type="text" id="positionSearch" class="form-control" 
                       placeholder="Filter by position..." 
                       style="padding-left: 35px; border-radius: 20px; border: 1px solid #ced4da; height: 38px;">
            </div>
        </div>
    
        <div class="shadow-sm" style="background: white; border-radius: 8px; border: 1px solid #dee2e6; overflow: hidden;">
            <table class="table" style="width: 100%; table-layout: fixed; margin-bottom: 0; border-collapse: collapse;">
                <thead style="background: #6c757d; color: white;">
                    <tr>
                        <th style="width: 15%; padding: 12px;">Companía</th>
                        <th style="width: 20%; padding: 12px;">Posición</th>
                        <th style="width: 15%; padding: 12px; text-align: center;">Fecha de expiración</th>
                        <th style="width: 25%; padding: 12px;">Descripción</th>
                        <th style="width: 25%; padding: 12px; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (!empty($jobOfferList)) {
                        foreach ($jobOfferList as $jobOffer) { 
                            $compName = "N/A";
                            foreach($companiesList as $company) {
                                if($company->getCompanyId() == $jobOffer->getCompanyId()) {
                                    $compName = $company->getName();
                                    break;
                                }
                            }
                            ?>
                            <tr class="offer-row" style="background-color: #fcfcfc; border-bottom: 1px solid #eee;">
                                <td style="vertical-align: middle; padding: 12px; border-right: 1px solid #f4f4f4;">
                                    <span style="color: #666; font-weight: bold; text-transform: uppercase; font-size: 0.8rem;">
                                        <?php echo htmlspecialchars($compName); ?>
                                    </span>
                                </td>

                                <td class="position-cell" style="vertical-align: middle; padding: 12px;">
                                    <?php if ($jobOffer->getFlyerImagePath()) { ?>
                                        <div class="mb-2">
                                            <img src="<?= str_replace('index.php', '', $_SERVER['PHP_SELF']) . 'uploads/job-offers/' . $jobOffer->getFlyerImagePath(); ?>" 
                                                alt="Flyer" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                        </div>
                                    <?php } ?>
                                    <strong style="color: #333;"><?php echo htmlspecialchars($jobOffer->getTitle()); ?></strong>
                                    <br>
                                    <span class="badge badge-danger" style="font-size: 0.65rem;">CERRADA</span>
                                </td>

                                <td style="vertical-align: middle; text-align: center; font-size: 0.85rem; color: #d9534f;">
                                    <i class="fas fa-calendar-times"></i><br>
                                    <?php echo $jobOffer->getDeadline(); ?>
                                </td>

                                <td style="vertical-align: middle; padding: 12px;">
                                    <div style="font-size: 0.85rem; max-height: 60px; overflow-y: auto; color: #777;">
                                        <?php echo nl2br(htmlspecialchars($jobOffer->getDescription())); ?>
                                    </div>
                                </td>

                                <td style="vertical-align: middle; text-align: center; padding: 12px;">
                                    <div style="display: flex; justify-content: center; gap: 5px; flex-wrap: wrap;">
                                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/showApplicants/<?= $jobOffer->getJobOfferId(); ?>" 
                                           class="btn btn-warning btn-sm" style="font-size: 0.7rem; font-weight: bold;">
                                            <i class="fas fa-users"></i> Aplicantes
                                        </a>

                                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/restoreJobOffer/<?= $jobOffer->getJobOfferId(); ?>/<?= $jobOffer->getCompanyId(); ?>" 
                                           class="btn btn-success btn-sm" style="font-size: 0.7rem; font-weight: bold;">
                                            <i class="fas fa-undo"></i> Reactivar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } 
                    } else { ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                                <i class="fas fa-archive fa-2x mb-3"></i><br>
                                No se encontraron ofertas laborales expiradas o inactivas.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="<?= FRONT_ROOT ?>Admin/showDashboard" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</main>



<script>
    document.getElementById('positionSearch').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.offer-row');

        rows.forEach(row => {
            // Buscamos el texto dentro de la fila
            let positionText = row.querySelector('.position-cell strong').textContent.toLowerCase();
            
            // CAMBIO AQUÍ: usamos .startsWith() en lugar de .includes()
            if (positionText.startsWith(filter)) {
                row.style.display = ""; // Coincide desde el inicio, se muestra
            } else {
                row.style.display = "none"; // No coincide, se oculta
            }
        });
    });
</script>