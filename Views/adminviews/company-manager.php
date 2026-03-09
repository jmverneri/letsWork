<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container-fluid px-4"> 
            <h2 class="mb-4 text-dark">Company Management</h2>

            <h2 class="mb-4 text-dark">Company Management</h2>

            <?php if (isset($_SESSION['success_message'])) { ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?php 
                        echo $_SESSION['success_message']; 
                        unset($_SESSION['success_message']); // Lo borramos para que no aparezca de nuevo al refrescar
                    ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>

           <form action="<?php echo FRONT_ROOT . "AdminCompany/showCompaniesViews" ?>" method="POST" class="form-inline mb-4">
                <input type="text" name="search" class="form-control mr-sm-2" placeholder="Search by name..." value="<?php echo (isset($search)) ? $search : ''; ?>">
                <button class="btn btn-primary" type="submit">Search</button>
                
                <a href="<?php echo FRONT_ROOT . "AdminCompany/showCompaniesViews" ?>" class="btn btn-secondary ml-2">Clear</a>
            </form>

            <div class="btn-group btn-group-toggle mb-4" data-toggle="buttons">
                <label class="btn btn-secondary active" onclick="filterByStatus('all')">
                    <input type="radio" name="options" id="option1" checked> All
                </label>
                <label class="btn btn-success" onclick="filterByStatus('active')">
                    <input type="radio" name="options" id="option2"> Only Active
                </label>
                <label class="btn btn-danger" onclick="filterByStatus('inactive')">
                    <input type="radio" name="options" id="option3"> Only Inactive
                </label>
            </div>

            <div class="table-responsive">
                <table class="table table-hover bg-light shadow-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>CUIT</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Phone</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Job Offers</th>
                            <th class="text-center">Management</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($companiesWithEmail)) { 
                            foreach ($companiesWithEmail as $item) { 
                                $company = $item['company'];
                                $email = $item['email']; ?>
                            <tr class="company-row" data-status="<?php echo ($company->isActive()) ? 'active' : 'inactive'; ?>">
                                <td class="align-middle"><strong><?php echo $company->getName(); ?></strong></td>
                                <td class="align-middle"><?php echo $company->getCuit(); ?></td>
                                <td class="align-middle"><?php echo $email; ?></td>
                                <td class="align-middle"><?php echo $company->getCity(); ?></td>
                                <td class="align-middle"><?php echo $company->getPhoneNumber(); ?></td>
                                
                                <td class="align-middle text-center">
                                    <?php if($company->isActive()) { ?>
                                        <span class="badge badge-success p-2">Active</span>
                                    <?php } else { ?>
                                        <span class="badge badge-danger p-2">Inactive</span>
                                    <?php } ?>
                                </td>

                                <td class="align-middle text-center">
                                    <div class="btn-group">
                                        <a href="<?php echo FRONT_ROOT . "AdminJobOffer/showAddView/" . $company->getCompanyId(); ?>" 
                                            class="btn btn-success" 
                                            style="min-width: 80px;">
                                            Add
                                        </a>
                                        <a href="<?php echo FRONT_ROOT . "AdminJobOffer/showListView/" . $company->getCompanyId(); ?>" 
                                        class="btn btn-info" style="min-width: 80px;">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center">
                                        <form action="<?php echo FRONT_ROOT . "AdminCompany/showModifyView" ?>" method="POST" class="mx-1">
                                            <input type="hidden" name="companyId" value="<?php echo $company->getCompanyId(); ?>">
                                            <button type="submit" class="btn btn-warning text-dark" style="min-width: 90px;">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        </form>

                                        <?php if($company->isActive()) { ?>
                                            <form action="<?php echo FRONT_ROOT . "AdminCompany/deleteCompany" ?>" method="POST" class="mx-1" onsubmit="return confirm('Are you sure?');">
                                                <input type="hidden" name="companyId" value="<?php echo $company->getCompanyId(); ?>">
                                                <button type="submit" class="btn btn-danger" style="min-width: 90px;">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        <?php } else { ?>
                                            <form action="<?php echo FRONT_ROOT . "AdminCompany/reactiveCompany" ?>" method="POST" class="mx-1">
                                                <input type="hidden" name="companyId" value="<?php echo $company->getCompanyId(); ?>">
                                                <button type="submit" class="btn btn-success" style="min-width: 90px;">
                                                    <i class="fas fa-redo"></i> Restore
                                                </button>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } 
                        } else { ?>
                            <tr>
                                <td colspan="8" class="text-center py-5"><h3>No companies found.</h3></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <a href="<?php echo FRONT_ROOT . "AdminCompany/showAddView" ?>" class="btn btn-success btn-lg shadow">
                    <i class="fas fa-plus-circle"></i> Register New Company
                </a>
            </div>
        </div>
    </section>
</main>

<script>
function filterByStatus(status) {
    const rows = document.querySelectorAll('.company-row');

    rows.forEach(row => {
        if (status === 'all') {
            row.style.display = ''; // Muestra todo
        } else {
            // Si el data-status de la fila coincide con el botón, se muestra, sino se oculta
            if (row.getAttribute('data-status') === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}
</script>