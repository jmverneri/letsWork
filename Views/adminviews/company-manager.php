<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container-fluid px-4"> 
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-dark m-0">Administración de Compañías</h2>
                <div style="position: relative; width: 300px;">
                    <i class="fas fa-search" style="position: absolute; left: 10px; top: 12px; color: #aaa;"></i>
                    <input type="text" id="companySearch" class="form-control" 
                           placeholder="Elegir por nombre..." 
                           style="padding-left: 35px; border-radius: 20px;">
                </div>
            </div>

            <?php if (isset($_SESSION['success_message'])) { ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            <?php } ?>

            <div class="btn-group btn-group-toggle mb-4" data-toggle="buttons">
                <label class="btn btn-secondary active" onclick="filterByStatus('all')">
                    <input type="radio" name="options" checked> Todas
                </label>
                <label class="btn btn-success" onclick="filterByStatus('active')">
                    <input type="radio" name="options"> Solo Activas
                </label>
                <label class="btn btn-danger" onclick="filterByStatus('inactive')">
                    <input type="radio" name="options"> Solo Inactivas
                </label>
            </div>

            

            <div class="table-responsive">
                <table class="table table-hover bg-light shadow-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>CUIT</th>
                            <th>Email</th>
                            <th>Ciudad</th>
                            <th>Teléfono</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Oferas de Trabajo</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($companiesWithEmail)) { 
                            foreach ($companiesWithEmail as $item) { 
                                $company = $item['company'];
                                $email = $item['email']; ?>
                            <tr class="company-row" data-status="<?php echo ($company->isActive()) ? 'active' : 'inactive'; ?>">
                                <td class="align-middle"><strong><?php echo htmlspecialchars($company->getName()); ?></strong></td>
                                <td class="align-middle"><?php echo $company->getCuit(); ?></td>
                                <td class="align-middle"><?php echo $email; ?></td>
                                <td class="align-middle"><?php echo $company->getCity(); ?></td>
                                <td class="align-middle"><?php echo $company->getPhoneNumber(); ?></td>
                                
                                <td class="align-middle text-center">
                                    <span class="badge <?php echo $company->isActive() ? 'badge-success' : 'badge-danger'; ?> p-2">
                                        <?php echo $company->isActive() ? 'Activa' : 'Inactiva'; ?>
                                    </span>
                                </td>

                                <td class="align-middle text-center">
                                    <div class="btn-group">
                                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/showAddView/<?= $company->getCompanyId(); ?>" class="btn btn-success btn-sm">Agregar</a>
                                        <a href="<?= FRONT_ROOT ?>AdminJobOffer/showListView/<?= $company->getCompanyId(); ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Ver</a>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center">
                                        <form action="<?= FRONT_ROOT ?>AdminCompany/showModifyView" method="POST" class="mx-1">
                                            <input type="hidden" name="companyId" value="<?= $company->getCompanyId(); ?>">
                                            <button type="submit" class="btn btn-warning btn-sm text-dark"><i class="fas fa-edit"></i> Editar</button>
                                        </form>

                                        <?php if($company->isActive()) { ?>
                                            <form action="<?= FRONT_ROOT ?>AdminCompany/deleteCompany" method="POST" class="mx-1" onsubmit="return confirm('Are you sure?');">
                                                <input type="hidden" name="companyId" value="<?= $company->getCompanyId(); ?>">
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Borrar</button>
                                            </form>
                                        <?php } else { ?>
                                            <form action="<?= FRONT_ROOT ?>AdminCompany/reactiveCompany" method="POST" class="mx-1">
                                                <input type="hidden" name="companyId" value="<?= $company->getCompanyId(); ?>">
                                                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-redo"></i> Restaurar</button>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } 
                        } else { ?>
                            <tr><td colspan="8" class="text-center py-5"><h3>No se encontraron companías.</h3></td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <a href="<?php echo FRONT_ROOT . "Admin/showDashboard" ?>" class="btn btn-secondary" style="padding: 8px 15px; border-radius: 4px; text-decoration: none; color: white; background: #6c757d; display: inline-block;">
                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                </a>
            </div>
        </div>
    </section>
</main>

<script>
    const searchInput = document.getElementById('companySearch');
    let currentFilterStatus = 'all';

    searchInput.addEventListener('input', applyFilters);

    function filterByStatus(status) {
        currentFilterStatus = status;
        applyFilters();
    }

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('.company-row');

        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            const rowName = row.querySelector('strong').textContent.toLowerCase();

            // Lógica unificada: comienza con el texto Y coincide con el estado
            const matchesName = rowName.startsWith(searchTerm);
            const matchesStatus = (currentFilterStatus === 'all' || rowStatus === currentFilterStatus);

            row.style.display = (matchesName && matchesStatus) ? '' : 'none';
        });
    }
</script>