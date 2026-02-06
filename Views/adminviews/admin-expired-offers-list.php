<?php
use Utils\Utils;
Utils::checkNav();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<main class="py-5">
    <div class="container">
        <h2 class="mb-4" style="color: #dc3545; border-bottom: 2px solid #dc3545; padding-bottom: 10px;">
            <i class="fas fa-history"></i> Expired or Inactive Job Offers
        </h2>           
    
        <div class="shadow-sm" style="background: white; border-radius: 8px; border: 1px solid #dee2e6; overflow: hidden;">
            <table class="table" style="width: 100%; table-layout: fixed; margin-bottom: 0;">
                <thead style="background: #6c757d; color: white;">
                    <tr>
                        <th style="width: 20%; padding: 12px;">Company</th>
                        <th style="width: 25%; padding: 12px;">Position</th>
                        <th style="width: 15%; padding: 12px; text-align: center;">Expired Date</th>
                        <th style="width: 25%; padding: 12px;">Description</th>
                        <th style="width: 15%; padding: 12px; text-align: center;">Actions</th>
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
                            <tr style="background-color: #fcfcfc; border-bottom: 1px solid #eee; opacity: 0.8;">
                                <td style="vertical-align: middle; padding: 12px;">
                                    <span style="color: #666; font-weight: bold; text-transform: uppercase; font-size: 0.8rem;">
                                        <?php echo $compName; ?>
                                    </span>
                                </td>

                                <td style="vertical-align: middle; padding: 12px;">
                                    <strong style="color: #333;"><?php echo $jobOffer->getTitle(); ?></strong>
                                    <br>
                                    <span class="badge badge-danger">EXPIRED / INACTIVE</span>
                                </td>

                                <td style="vertical-align: middle; text-align: center; font-size: 0.85rem; color: #d9534f;">
                                    <i class="fas fa-calendar-times"></i><br>
                                    <?php echo $jobOffer->getDeadline(); ?>
                                </td>

                                <td style="vertical-align: middle; padding: 12px;">
                                    <div style="font-size: 0.85rem; max-height: 60px; overflow-y: auto; color: #777;">
                                        <?php echo nl2br($jobOffer->getDescription()); ?>
                                    </div>
                                </td>

                                <td style="vertical-align: middle; text-align: center; padding: 12px;">
                                    <a href="<?php echo FRONT_ROOT ?>AdminJobOffer/restoreJobOffer/<?php echo $jobOffer->getJobOfferId(); ?>/<?php echo $jobOffer->getCompanyId(); ?>" 
                                       class="btn btn-success btn-sm" style="font-size: 0.75rem; padding: 5px 10px;">
                                        Reactivate
                                    </a>
                                </td>
                            </tr>
                        <?php } 
                    } else { ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                                No expired offers found.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="<?php echo FRONT_ROOT . "Admin/showDashboard" ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</main>