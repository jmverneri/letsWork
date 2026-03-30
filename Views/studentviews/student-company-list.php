<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="py-5" style="background-color: #fbfbfa; min-height: 88vh;">
    <section id="listado" class="mb-5">
        <div class="container">
            <div class="row align-items-center mb-4 g-3">
                <div class="col-md-6 text-center text-md-start">
                    <h2 class="fw-bold text-dark mb-0">
                        <i class="fas fa-building text-primary me-2"></i>Directorio de Compañías
                    </h2>
                    <p class="text-muted small mb-0">Explorá las empresas que forman parte de nuestra red.</p>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-center">
                    <div style="position: relative; width: 100%; max-width: 350px;">
                        <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
                        <input type="text" id="companySearch" class="form-control shadow-sm border-0" 
                               placeholder="Buscar por nombre..." 
                               style="padding-left: 40px; border-radius: 25px; height: 45px;">
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark"> <tr class="text-center">
                                <th class="py-3">Nombre</th>
                                <th class="py-3">Ciudad</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php if (!empty($companiesWithEmail)): ?>
                                <?php foreach ($companiesWithEmail as $item):
                                    $company = $item['company'];
                                    $email   = $item['email'];
                                ?>
                                    <tr class="company-row align-middle text-center">
                                        <td class="company-name fw-bold text-dark">
                                            <?= htmlspecialchars($company->getName()) ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-secondary border">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <?= htmlspecialchars($company->getCity() ?? '-') ?>
                                            </span>
                                        </td>
                                        <td class="text-muted"><?= htmlspecialchars($email) ?></td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="<?= FRONT_ROOT ?>StudentCompany/showCompanyDetails/<?= $company->getCompanyId(); ?>"
                                                   class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                    <i class="fas fa-info-circle me-1"></i> Detalles
                                                </a>
                                                
                                                <a href="<?= FRONT_ROOT ?>StudentJobOffer/showOffersByCompany/<?= $company->getCompanyId(); ?>"
                                                   class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                                    Ver Ofertas
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-search mb-3 d-block" style="font-size: 2rem; opacity: 0.3;"></i>
                                        No se encontraron compañías registradas.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <a href="<?php echo FRONT_ROOT . "Home/menuStudent" ?>" class="btn btn-link text-decoration-none text-muted p-0">
                    <i class="fas fa-arrow-left me-2"></i> Volver al Dashboard
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
            let nameText = row.querySelector('.company-name').textContent.toLowerCase();
            // startsWith es bueno, pero includes suele ser más cómodo para el usuario
            if (nameText.trim().includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>