<?php
use Utils\Utils;
Utils::checkNav();

$companyName = "Details"; 
if (!empty($jobOfferList) && !empty($companiesList)) {
    foreach ($companiesList as $company) {
        if ($company->getCompanyId() == $jobOfferList[0]->getCompanyId()) {
            $companyName = $company->getName();
            break;
        }
    }
}
?>

<main class="py-5">
    <div class="container">
        <h2 class="mb-4" style="color: #333;">Ofertas Laborales: <span style="color: #007bff;"><?php echo $companyName; ?></span></h2>           
    
        <div class="shadow-sm" style="background: white; border-radius: 8px; border: 1px solid #dee2e6;">
            <table class="table" style="width: 100%; table-layout: fixed; margin-bottom: 0;">
                <thead style="background: #343a40; color: white;">
                    <tr>
                        <th style="width: 25%; padding: 12px;">Posición</th>
                        <th style="width: 15%; padding: 12px; text-align: center;">Fechas</th>
                        <th style="width: 12%; padding: 12px; text-align: center;">Salario</th>
                        <th style="width: 33%; padding: 12px;">Descripción</th>
                        <th style="width: 15%; padding: 12px; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($jobOfferList)) {
                        foreach ($jobOfferList as $jobOffer) {
                            $isActive = $jobOffer->getActive(); ?>
                            <tr style="<?php echo !$isActive ? 'background-color: #f9f9f9; opacity: 0.6;' : ''; ?>">
                                <td style="vertical-align: middle; padding: 12px;">
                                    <strong><?php echo $jobOffer->getTitle(); ?></strong><br>
                                    <small style="padding: 2px 6px; border-radius: 4px; background: <?php echo $isActive ? '#28a745' : '#6c757d'; ?>; color: white;">
                                        <?php echo $isActive ? 'Activa' : 'Inactiva'; ?>
                                    </small>
                                </td>
                                <td style="vertical-align: middle; text-align: center; font-size: 0.85rem;">
                                    Comienzo: <?php echo $jobOffer->getStartDate(); ?><br>
                                    Fin: <?php echo $jobOffer->getDeadline(); ?>
                                </td>
                                <td style="vertical-align: middle; text-align: center; color: #28a745; font-weight: bold;">
                                    $<?php echo number_format($jobOffer->getSalary(), 2); ?>
                                </td>
                                <td style="vertical-align: middle; padding: 12px;">
                                    <div style="font-size: 0.85rem; max-height: 80px; overflow-y: auto; color: #555;">
                                        <?php echo nl2br($jobOffer->getDescription()); ?>
                                    </div>
                                </td>
                                <td style="vertical-align: middle; text-align: center; padding: 12px;">
                                    <div style="display: flex; justify-content: center; gap: 5px;">
                                        <a href="<?php echo FRONT_ROOT . "AdminJobOffer/showModifyJobOfferView/" . $jobOffer->getJobOfferId(); ?>" 
                                           class="btn btn-info btn-sm" style="font-size: 0.75rem; padding: 5px 8px;">
                                            Editar
                                        </a>

                                        <?php if ($isActive) { ?>
                                            <a href="<?php echo FRONT_ROOT ?>AdminJobOffer/deleteJobOffer/<?php echo $jobOffer->getJobOfferId(); ?>/<?php echo $jobOffer->getCompanyId(); ?>" 
                                               class="btn btn-danger btn-sm" style="font-size: 0.75rem; padding: 5px 8px;"
                                               onclick="return confirm('Deactivate?')">
                                                Borrar
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?php echo FRONT_ROOT ?>AdminJobOffer/restoreJobOffer/<?php echo $jobOffer->getJobOfferId(); ?>/<?php echo $jobOffer->getCompanyId(); ?>" 
                                               class="btn btn-success btn-sm" style="font-size: 0.75rem; padding: 5px 8px;">
                                                Restaurar
                                            </a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr><td colspan="5" style="text-align: center; padding: 30px;">Sin ofertas encontradas.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="<?php echo FRONT_ROOT . "AdminCompany/showCompaniesViews" ?>" class="btn btn-secondary">
                Volver a Companías
            </a>
        </div>
    </div>
</main>