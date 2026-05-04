<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Directorio de compañías</h1>
      <p class="page-subtitle">Explorá las empresas que forman parte de nuestra red.</p>
    </div>
    <div class="search-wrap">
      <span class="search-icon">&#9906;</span>
      <input type="text" id="companySearch" placeholder="Buscar por nombre...">
    </div>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th style="text-align:center">Ciudad</th>
          <th>Email</th>
          <th style="text-align:center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($companiesWithEmail)):
          foreach ($companiesWithEmail as $item):
            $company = $item['company'];
            $email   = $item['email'];
        ?>
          <tr class="company-row">
            <td class="company-name" style="font-weight:500;"><?= htmlspecialchars($company->getName()) ?></td>
            <td style="text-align:center">
              <span class="badge-pill"><?= htmlspecialchars($company->getCity() ?? '-') ?></span>
            </td>
            <td class="text-muted"><?= htmlspecialchars($email) ?></td>
            <td style="text-align:center">
              <div class="table-actions">
                <a href="<?= FRONT_ROOT ?>StudentCompany/showCompanyDetails/<?= $company->getCompanyId(); ?>" class="btn-sm">Detalles</a>
                <a href="<?= FRONT_ROOT ?>StudentJobOffer/showOffersByCompany/<?= $company->getCompanyId(); ?>" class="btn-sm btn-sm-success">Ver ofertas</a>
              </div>
            </td>
          </tr>
        <?php endforeach;
        else: ?>
          <tr>
            <td colspan="4" class="table-empty">No se encontraron compañías registradas.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <a href="<?php echo FRONT_ROOT . 'Home/menuStudent'; ?>" class="page-back">← Volver al dashboard</a>

</main>

<script>
  document.getElementById('companySearch').addEventListener('input', function () {
    const filter = this.value.toLowerCase();
    document.querySelectorAll('.company-row').forEach(row => {
      const name = row.querySelector('.company-name').textContent.toLowerCase().trim();
      row.style.display = name.includes(filter) ? '' : 'none';
    });
  });
</script>