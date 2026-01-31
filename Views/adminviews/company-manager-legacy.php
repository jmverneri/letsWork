<?php
use Utils\Utils;
Utils::checkNav();
?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert alert-success">
        Company deleted successfully.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'activeOffers'): ?>
    <div class="alert alert-danger">
        Cannot delete company with active job offers.
    </div>
<?php endif; ?>

<?php
    // Aseguramos que la navegación se cargue si no viene del controlador
    // require_once(VIEWS_PATH . "nav-admin.php"); 
?>

<main class="py-5" style="background-color: #fbfbfa; min-height: 100vh;">
    <div class="container">
        
        <div class="messages-container mb-4">
            <?php if (isset($_GET['success']) || (isset($_GET['msg']) && $_GET['msg'] === 'deleted')): ?>
                <div class="alert alert-success shadow-sm">
                    <strong>Success!</strong> Operation completed successfully.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'activeOffers'): ?>
                <div class="alert alert-danger shadow-sm">
                    <strong>Error:</strong> Cannot delete company with active job offers.
                </div>
            <?php endif; ?>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="fw-bold" style="color: #37352f;">Company Management</h2>
                <p class="text-muted">Manage all registered companies and their job offers.</p>
            </div>
            <div class="col-md-4 text-right">
                <a href="<?= FRONT_ROOT ?>Company/RedirectAddForm" class="btn btn-dark shadow-sm px-4">
                    + Add New Company
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="table-responsive">
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th class="py-3 px-4">Company Name</th>
                            <th class="py-3">Location</th>
                            <th class="py-3">CUIT</th>
                            <th class="py-3 text-right px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($companyList)) { 
                            foreach ($companyList as $company): ?>
                            <tr>
                                <td class="py-3 px-4 font-weight-bold">
                                    <?= htmlspecialchars($company->getName() ?? '') ?>
                                </td>
                                <td class="py-3 text-muted">
                                    <?= htmlspecialchars($company->getCity() ?? 'N/A') ?>
                                </td>
                                <td class="py-3">
                                    <span class="badge badge-light border px-2 py-1">
                                        <?= htmlspecialchars($company->getCuit() ?? '---') ?>
                                    </span>
                                </td>
                                <td class="py-3 text-right px-4">
                                    <div class="d-inline-flex justify-content-end" style="gap: 5px;">
                                        
                                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/showAddView?idCompany=<?= $company->getCompanyId() ?>" 
                                           class="btn btn-success btn-sm font-weight-bold">
                                            + Job Offer
                                        </a>

                                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/showJobsByCompany?id=<?= $company->getCompanyId() ?>" 
                                           class="btn btn-primary btn-sm">
                                            View Offers
                                        </a>

                                        <a href="<?= FRONT_ROOT ?>Company/showEditView?id=<?= $company->getCompanyId() ?>" 
                                           class="btn btn-secondary btn-sm">
                                            Edit
                                        </a>

                                        <button class="btn btn-danger btn-sm" 
                                                onclick="confirmDelete('<?= $company->getCompanyId() ?>', '<?= addslashes($company->getName()) ?>')">
                                            Delete
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; 
                        } else { ?>
                            <tr>
                                <td colspan="4" class="py-5 text-center text-muted">No companies found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="<?= FRONT_ROOT ?>Home/menuAdmin" class="text-muted">
                &larr; Back to Admin Menu
            </a>
        </div>
    </div>
</main>

<script>
function confirmDelete(id, name) {
    if (confirm("Are you sure you want to delete " + name + "?")) {
        // Formato de URL estándar para evitar fallos de ruteo
        window.location.href = "<?= FRONT_ROOT ?>Company/deleteCompany?id=" + id;
    }
}
</script>