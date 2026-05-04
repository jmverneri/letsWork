<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Administración de compañías</h1>
    </div>
    <div class="search-wrap">
      <span class="search-icon">&#9906;</span>
      <input type="text" id="companySearch" placeholder="Buscar por nombre...">
    </div>
  </div>

  <?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success" role="alert">
      <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
    </div>
  <?php endif; ?>

  <div class="filters">
    <button class="filter-pill active" onclick="filterByStatus('all', this)">Todas</button>
    <button class="filter-pill" onclick="filterByStatus('active', this)">Solo activas</button>
    <button class="filter-pill" onclick="filterByStatus('inactive', this)">Solo inactivas</button>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>CUIT</th>
          <th>Email</th>
          <th>Ciudad</th>
          <th>Teléfono</th>
          <th style="text-align:center">Status</th>
          <th style="text-align:center">Ofertas</th>
          <th style="text-align:center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($companiesWithEmail)):
          foreach ($companiesWithEmail as $item):
            $company = $item['company'];
            $email = $item['email'];
            $isActive = $company->isActive();
        ?>
          <tr class="company-row" data-status="<?php echo $isActive ? 'active' : 'inactive'; ?>">
            <td style="font-weight:500"><?php echo htmlspecialchars($company->getName()); ?></td>
            <td class="text-muted"><?php echo $company->getCuit(); ?></td>
            <td class="text-muted"><?php echo $email; ?></td>
            <td class="text-muted"><?php echo $company->getCity(); ?></td>
            <td class="text-muted"><?php echo $company->getPhoneNumber(); ?></td>

            <td style="text-align:center">
              <span class="<?php echo $isActive ? 'badge-active' : 'badge-inactive'; ?>">
                <?php echo $isActive ? 'Activa' : 'Inactiva'; ?>
              </span>
            </td>

            <td style="text-align:center">
              <div class="table-actions">
                <a href="<?= FRONT_ROOT ?>AdminJobOffer/showAddView/<?= $company->getCompanyId(); ?>" class="btn-sm btn-sm-success">Agregar</a>
                <a href="<?= FRONT_ROOT ?>AdminJobOffer/showListView/<?= $company->getCompanyId(); ?>" class="btn-sm">Ver</a>
              </div>
            </td>

            <td style="text-align:center">
              <div class="table-actions">
                <form action="<?= FRONT_ROOT ?>AdminCompany/showModifyView" method="POST">
                  <input type="hidden" name="companyId" value="<?= $company->getCompanyId(); ?>">
                  <button type="submit" class="btn-sm">Editar</button>
                </form>

                <?php if ($isActive): ?>
                  <form action="<?= FRONT_ROOT ?>AdminCompany/deleteCompany" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                    <input type="hidden" name="companyId" value="<?= $company->getCompanyId(); ?>">
                    <button type="submit" class="btn-sm btn-sm-danger">Borrar</button>
                  </form>
                <?php else: ?>
                  <form action="<?= FRONT_ROOT ?>AdminCompany/reactiveCompany" method="POST">
                    <input type="hidden" name="companyId" value="<?= $company->getCompanyId(); ?>">
                    <button type="submit" class="btn-sm btn-sm-success">Restaurar</button>
                  </form>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach;
        else: ?>
          <tr>
            <td colspan="8" class="table-empty">No se encontraron compañías.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <a href="<?php echo FRONT_ROOT . 'Admin/showDashboard'; ?>" class="page-back">← Volver al dashboard</a>

</main>

<script>
  const searchInput = document.getElementById('companySearch');
  let currentStatus = 'all';

  searchInput.addEventListener('input', applyFilters);

  function filterByStatus(status, btn) {
    currentStatus = status;
    document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    applyFilters();
  }

  function applyFilters() {
    const term = searchInput.value.toLowerCase();
    document.querySelectorAll('.company-row').forEach(row => {
      const name = row.querySelector('td').textContent.toLowerCase();
      const status = row.getAttribute('data-status');
      const matchesName = name.startsWith(term);
      const matchesStatus = currentStatus === 'all' || status === currentStatus;
      row.style.display = matchesName && matchesStatus ? '' : 'none';
    });
  }
</script>