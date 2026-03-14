<?php
use Utils\Utils;
Utils::checkNav();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<main class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="color: #333; margin: 0;">
                <i class="fas fa-globe"></i> Global Active Job Offers
            </h2>
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 10px; top: 10px; color: #aaa;"></i>
                <input type="text" id="positionSearch" class="form-control" 
                       placeholder="Filter by position..." 
                       style="padding-left: 35px; border-radius: 20px; border: 1px solid #ced4da; height: 38px;">
            </div>
        </div>

        <div class="shadow-sm" style="background: white; border-radius: 8px; border: 1px solid #dee2e6; overflow: hidden;">
            <table class="table" id="offersTable" style="width: 100%; table-layout: fixed; margin-bottom: 0; border-collapse: collapse;">
                <thead style="background: #212529; color: white;">
                    <tr>
                        <th style="width: 15%; padding: 12px;">Company</th>
                        <th style="width: 20%; padding: 12px;">Position</th>
                        <th style="width: 15%; padding: 12px; text-align: center;">Deadline</th>
                        <th style="width: 25%; padding: 12px;">Description</th>
                        <th style="width: 25%; padding: 12px; text-align: center;">Actions</th>
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
                            <tr class="offer-row" style="border-bottom: 1px solid #eee;">
                                <td style="vertical-align: middle; padding: 12px; border-right: 1px solid #f4f4f4;">
                                    <span style="color: #007bff; font-weight: bold; text-transform: uppercase; font-size: 0.8rem;">
                                        <?php echo $compName; ?>
                                    </span>
                                </td>

                                <td class="position-cell" style="vertical-align: middle; padding: 12px;">
                                <?php if ($jobOffer->getFlyerImagePath()) { ?>
                                        <div class="mb-2">
                                            <img src="<?= str_replace('index.php', '', $_SERVER['PHP_SELF']) . 'uploads/job-offers/' . $jobOffer->getFlyerImagePath(); ?>" 
                                                alt="Flyer" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                        </div>
                                    <?php } ?>    
                                <strong style="color: #333;"><?php echo $jobOffer->getTitle(); ?></strong>
                                    <br>
                                    <small style="color: #28a745; font-weight: bold;">
                                        $<?php echo number_format($jobOffer->getSalary(), 2); ?>
                                    </small>
                                </td>

                                <td style="vertical-align: middle; text-align: center; font-size: 0.85rem; color: #666;">
                                    <strong>Ends on:</strong><br>
                                    <?php echo $jobOffer->getDeadline(); ?>
                                </td>

                                <td style="vertical-align: middle; padding: 12px;">
                                    <div style="font-size: 0.85rem; max-height: 60px; overflow-y: auto; color: #555; line-height: 1.3;">
                                        <?php echo nl2br($jobOffer->getDescription()); ?>
                                    </div>
                                </td>

                                <td style="vertical-align: middle; text-align: center; padding: 12px;">
                                    <div style="display: flex; justify-content: center; gap: 5px; flex-wrap: wrap;">
                                        
                                        <a href="<?php echo FRONT_ROOT ?>AdminJobOffer/showApplicants/<?php echo $jobOffer->getJobOfferId(); ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="View Applicants"
                                           style="font-size: 0.7rem; padding: 5px 10px; color: #212529; border-radius: 4px; text-decoration: none; font-weight: bold; border: 1px solid #e0a800;">
                                            <i class="fas fa-users"></i> Applicants
                                        </a>

                                        <a href="<?php echo FRONT_ROOT . "AdminJobOffer/showModifyJobOfferView/" . $jobOffer->getJobOfferId(); ?>" 
                                           class="btn btn-info btn-sm" 
                                           style="font-size: 0.7rem; padding: 5px 10px; color: white; border-radius: 4px; text-decoration: none;">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <a href="<?php echo FRONT_ROOT ?>AdminJobOffer/deleteJobOffer/<?php echo $jobOffer->getJobOfferId(); ?>/<?php echo $jobOffer->getCompanyId(); ?>" 
                                           class="btn btn-danger btn-sm" 
                                           style="font-size: 0.7rem; padding: 5px 10px; color: white; border-radius: 4px; text-decoration: none;"
                                           onclick="return confirm('Are you sure you want to close this offer?')">
                                            <i class="fas fa-times"></i> Close
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        <?php } 
                    } else { ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                                <i class="fas fa-folder-open fa-2x mb-3"></i><br>
                                No active job offers at the moment.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="<?php echo FRONT_ROOT . "Admin/showDashboard" ?>" class="btn btn-secondary" style="padding: 8px 15px; border-radius: 4px; text-decoration: none; color: white; background: #6c757d; display: inline-block;">
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