<?php
use Utils\Utils;
Utils::checkNav();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<main class="py-5">
    <div class="container">
        <h2 class="mb-4" style="color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px;">
            <i class="fas fa-file-signature text-primary"></i> My Job Applications
        </h2>           
    
        <div class="shadow-sm" style="background: white; border-radius: 8px; border: 1px solid #dee2e6; overflow: hidden;">
            <table class="table table-hover" style="width: 100%; table-layout: fixed; margin-bottom: 0; border-collapse: collapse;">
                <thead style="background: #007bff; color: white;">
                    <tr>
                        <th style="width: 20%; padding: 12px;">Company</th>
                        <th style="width: 25%; padding: 12px;">Position</th>
                        <th style="width: 15%; padding: 12px; text-align: center;">Date Applied</th>
                        <th style="width: 15%; padding: 12px; text-align: center;">Offer Status</th>
                        <th style="width: 25%; padding: 12px; text-align: center;">My Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (!empty($applicationList)) {
                        foreach ($applicationList as $app) { 
                            // Lógica de expiración: Si isRealActive es 0, la oferta murió
                            $isOfferActuallyOpen = ($app['isRealActive'] == 1);
                            $currentAppStatus = trim($app['appStatus']);
                            ?>
                            <tr style="<?php echo ($currentAppStatus == 'declined') ? 'background-color: #f8f9fa; opacity: 0.8;' : ''; ?>">
                                
                                <td style="vertical-align: middle; padding: 12px;">
                                    <strong style="color: #007bff; text-transform: uppercase; font-size: 0.85rem;">
                                        <?php echo $app['companyName']; ?>
                                    </strong>
                                </td>

                                <td style="vertical-align: middle; padding: 12px;">
                                    <span style="font-weight: 600; color: #444;"><?php echo $app['title']; ?></span>
                                </td>

                                <td style="vertical-align: middle; text-align: center; font-size: 0.9rem; color: #666;">
                                    <?php echo date('d/m/Y', strtotime($app['applicationDate'])); ?>
                                </td>

                                <td style="vertical-align: middle; text-align: center;">
                                    <?php if ($isOfferActuallyOpen) { ?>
                                        <span class="badge badge-info" style="font-weight: 500;">
                                            <i class="fas fa-check-circle"></i> Open
                                        </span>
                                    <?php } else { ?>
                                        <span class="badge badge-secondary" style="font-weight: 500; background-color: #6c757d;">
                                            <i class="fas fa-clock"></i> Expired
                                        </span>
                                    <?php } ?>
                                </td>

                                <td style="vertical-align: middle; text-align: center;">
                                    <?php if ($currentAppStatus === 'active') { ?>
                                        <div class="text-success" style="font-weight: bold; font-size: 0.9rem;">
                                            <i class="fas fa-spinner fa-spin mr-1"></i> In Review
                                        </div>
                                    <?php } else { ?>
                                        <div class="text-danger" style="font-weight: bold; font-size: 0.9rem;">
                                            <i class="fas fa-times-circle mr-1"></i> Declined
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } 
                    } else { ?>
                        <tr><td colspan="5" class="text-center" style="padding: 50px;">No applications found.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>