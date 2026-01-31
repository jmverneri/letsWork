<?php
use Utils\Utils;
Utils::checkNav();

?>

<div class="container mt-4">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i> Operación realizada con éxito.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> 
            <?php 
                echo ($_GET['error'] == "activeOffers") 
                    ? "No se puede eliminar: La empresa tiene ofertas publicadas." 
                    : "Ha ocurrido un error inesperado.";
            ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
</div>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 fw-bold mb-0" style="color: #37352f;">Company Management</h2>
                <a href="<?= FRONT_ROOT ?>Company/RedirectAddForm" class="btn btn-primary btn-sm px-4 shadow-sm">
                    + Add New Company
                </a>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 bg-white">
                        <thead style="background-color: #f8f9fa;">
                            <tr class="text-muted small text-uppercase">
                                <th class="py-3 px-4">Name</th>
                                <th class="py-3">City</th>
                                <th class="py-3">CUIT</th>
                                <th class="py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($companyList as $company): ?>
                                <tr>
                                    <td class="py-3 px-4 font-weight-bold" style="color: #37352f;">
                                        <?= htmlspecialchars($company->getName() ?? '') ?>
                                    </td>
                                    <td class="py-3 align-middle text-muted small">
                                        <?= htmlspecialchars($company->getCity() ?? '') ?>
                                    </td>
                                    <td class="py-3 align-middle">
                                        <span class="badge badge-light border text-muted px-2 py-1">
                                            <?= htmlspecialchars($company->getCuit() ?? '') ?>
                                        </span>
                                    </td>
                                    <td class="py-3 text-right align-middle">
                                        <div class="btn-group" role="group">
                                            
                                            <a href="<?= FRONT_ROOT ?>AdminJobOffer/showJobsByCompany?id=<?= $company->getCompanyId() ?>" 
                                            class="btn btn-outline-primary btn-sm mr-1" title="View Job Offers">
                                                <i class="fas fa-briefcase"></i> Offers
                                            </a>

                                            <a href="<?= FRONT_ROOT ?>Company/showEditView?id=<?= $company->getCompanyId() ?>" 
                                            class="btn btn-outline-secondary btn-sm mr-1" title="Edit Company">
                                                Edit
                                            </a>

                                            <button class="btn btn-outline-danger btn-sm" 
                                                    onclick="confirmDelete('<?= $company->getCompanyId() ?>', '<?= addslashes($company->getName()) ?>')" 
                                                    title="Delete Company">
                                                Delete
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
function confirmDelete(id, name) {
    if (confirm("Are you sure you want to delete " + name + "?")) {
        window.location.href = "<?= FRONT_ROOT ?>Company/deleteCompany&id=" + id;
    }
}
</script>