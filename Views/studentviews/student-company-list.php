<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-dark">Companies List</h2>
                <div style="position: relative; width: 300px;">
                    <i class="fas fa-search" style="position: absolute; left: 10px; top: 12px; color: #aaa;"></i>
                    <input type="text" id="companySearch" class="form-control" 
                           placeholder="Search by name..." 
                           style="padding-left: 35px; border-radius: 20px;">
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover bg-light shadow-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>City</th>
                            <th>Email</th>
                            <th>Actions</th> </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($companiesWithEmail)): ?>
                            <?php foreach ($companiesWithEmail as $item):
                                $company = $item['company'];
                                $email   = $item['email'];
                            ?>
                                <tr class="company-row">
                                    <td class="company-name"><?= htmlspecialchars($company->getName()) ?></td>
                                    <td><?= htmlspecialchars($company->getCity() ?? '-') ?></td>
                                    <td><?= htmlspecialchars($email) ?></td>
                                    <td>
                                        <a href="<?= FRONT_ROOT ?>StudentCompany/showCompanyDetails/<?= $company->getCompanyId(); ?>"
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-info-circle"></i> Details
                                        </a>
                                        
                                        <a href="<?= FRONT_ROOT ?>StudentJobOffer/showOffersByCompany/<?= $company->getCompanyId(); ?>"
                                           class="btn btn-secondary btn-sm">
                                            Job Offers
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">No companies found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <a href="<?php echo FRONT_ROOT . "Home/menuStudent" ?>" class="btn btn-secondary" style="padding: 8px 15px; border-radius: 4px; text-decoration: none; color: white; background: #6c757d; display: inline-block;">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </section>
</main>

<script>
    const searchInput = document.getElementById('companySearch');
    
    searchInput.addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.company-row');

        rows.forEach(row => {
            // Buscamos el nombre dentro de la celda con clase company-name
            let nameText = row.querySelector('.company-name').textContent.toLowerCase();
            
            // Lógica: coincide si empieza con el texto escrito
            if (nameText.startsWith(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>