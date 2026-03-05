<?php
use Utils\Utils;
Utils::checkNav();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<main class="py-5">
    <div class="container">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 style="color: #333;">
                <i class="fas fa-users-cog"></i> Applicants for: 
                <span class="text-primary"><?php echo $jobOffer->getTitle(); ?></span>
            </h2>
            <span class="badge badge-info" style="font-size: 1rem; padding: 10px;">
                Total: <?php echo count($applicantList); ?>
            </span>
        </div>

        <div class="mb-3">
            <a href="<?= FRONT_ROOT ?>AdminJobOffer/generateApplicantsPDF/<?= $jobOffer->getJobOfferId() ?>" 
            class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Download PDF List
            </a>
        </div>
        
        <div class="shadow-sm" style="background: white; border-radius: 8px; border: 1px solid #dee2e6; overflow: hidden;">
            <table class="table table-hover" style="margin-bottom: 0; border-collapse: collapse;">
                <thead style="background: #212529; color: white;">
                    <tr>
                        <th style="padding: 12px;">Full Name</th>
                        <th style="padding: 12px;">Email</th>
                        <th style="padding: 12px; text-align: center;">Date Applied</th>
                        <th style="padding: 12px; text-align: center;">Status</th>
                        <th style="padding: 12px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($applicantList)) {
                        foreach($applicantList as $student) { 
                            $isDeclined = ($student['status'] == 'declined');
                            ?>
                            <tr style="<?php echo $isDeclined ? 'background-color: #f8f9fa; color: #6c757d;' : ''; ?>">
                                <td style="vertical-align: middle; padding: 12px;">
                                    <strong><?php echo $student['firstName'] . " " . $student['lastName']; ?></strong>
                                </td>
                                
                                <td style="vertical-align: middle; padding: 12px;">
                                    <i class="fas fa-envelope-open-text text-muted mr-2"></i>
                                    <?php echo $student['email']; ?>
                                </td>
                                
                                <td style="vertical-align: middle; text-align: center; padding: 12px;">
                                    <?php echo date('d/m/Y H:i', strtotime($student['applicationDate'])); ?>
                                </td>

                                <td style="vertical-align: middle; text-align: center; padding: 12px;">
                                    <?php if(!$isDeclined) { ?>
                                        <span class="badge badge-success" style="padding: 5px 10px;">ACTIVE</span>
                                    <?php } else { ?>
                                        <span class="badge badge-secondary" style="padding: 5px 10px;">DECLINED</span>
                                    <?php } ?>
                                </td>

                                <td style="vertical-align: middle; text-align: center; padding: 12px;">
                                    <?php if(!$isDeclined) { ?>
                                        <a href="<?php echo FRONT_ROOT; ?>AdminJobOffer/declineApplicant/<?php echo $student['studentId']; ?>/<?php echo $jobOffer->getJobOfferId(); ?>" 
                                           class="btn btn-outline-danger btn-sm" 
                                           onclick="return confirm('Are you sure you want to decline this application?')"
                                           style="text-decoration: none; font-weight: bold;">
                                           <i class="fas fa-user-slash"></i> Decline
                                        </a>
                                    <?php } else { ?>
                                        <button class="btn btn-sm btn-light" disabled>
                                            <i class="fas fa-ban"></i> Processed
                                        </button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } 
                    } else { ?>
                        <tr>
                            <td colspan="5" class="text-center" style="padding: 50px; color: #999;">
                                <i class="fas fa-user-clock fa-3x mb-3"></i><br>
                                No students have applied for this position yet.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            <a href="<?php echo FRONT_ROOT; ?>AdminJobOffer/showActiveJobOffers" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Job Offers
            </a>
        </div>
    </div>
</main>