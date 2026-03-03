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
            <table class="table" style="width: 100%; table-layout: fixed; margin-bottom: 0; border-collapse: collapse;">
                <thead style="background: #6c757d; color: white;">
                    <tr>
                        <th style="width: 15%; padding: 12px;">Company</th>
                        <th style="width: 20%; padding: 12px;">Position</th>
                        <th style="width: 15%; padding: 12px; text-align: center;">Expired Date</th>
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
                            <tr style="background-color: #fcfcfc; border-bottom: 1px solid #eee; opacity: 0.9;">
                                <td style="vertical-align: middle; padding: 12px; border-right: 1px solid #f4f4f4;">
                                    <span style="color: #666; font-weight: bold; text-transform: uppercase; font-size: 0.8rem;">
                                        <?php echo $compName; ?>
                                    </span>
                                </td>

                                <td style="vertical-align: middle; padding: 12px;">
                                    <strong style="color: #333;"><?php echo $jobOffer->getTitle(); ?></strong>
                                    <br>
                                    <span class="badge badge-danger" style="font-size: 0.65rem;">CLOSED</span>
                                </td>

                                <td style="vertical-align: middle; text-align: center; font-size: 0.85rem; color: #d9534f;">
                                    <i class="fas fa-calendar-times"></i><br>
                                    <strong>Ended:</strong><br>
                                    <?php echo $jobOffer->getDeadline(); ?>
                                </td>

                                <td style="vertical-align: middle; padding: 12px;">
                                    <div style="font-size: 0.85rem; max-height: 60px; overflow-y: auto; color: #777; line-height: 1.3;">
                                        <?php echo nl2br($jobOffer->getDescription()); ?>
                                    </div>
                                </td>

                                <td style="vertical-align: middle; text-align: center; padding: 12px;">
                                    <div style="display: flex; justify-content: center; gap: 5px; flex-wrap: wrap;">
                                        
                                        <a href="<?php echo FRONT_ROOT ?>AdminJobOffer/showApplicants/<?php echo $jobOffer->getJobOfferId(); ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="View History of Applicants"
                                           style="font-size: 0.7rem; padding: 5px 10px; color: #212529; border-radius: 4px; text-decoration: none; font-weight: bold; border: 1px solid #e0a800;">
                                            <i class="fas fa-users"></i> Applicants
                                        </a>

                                        <a href="<?php echo FRONT_ROOT ?>AdminJobOffer/restoreJobOffer/<?php echo $jobOffer->getJobOfferId(); ?>/<?php echo $jobOffer->getCompanyId(); ?>" 
                                           class="btn btn-success btn-sm" 
                                           title="Reactivate this offer"
                                           style="font-size: 0.7rem; padding: 5px 10px; color: white; border-radius: 4px; text-decoration: none; font-weight: bold;">
                                            <i class="fas fa-undo"></i> Reactivate
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        <?php } 
                    } else { ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                                <i class="fas fa-archive fa-2x mb-3"></i><br>
                                No expired or inactive job offers found.
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