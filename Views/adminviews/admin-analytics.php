<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
use Utils\Utils;
Utils::checkNav();
?>

<main class="page-root">

  <div class="page-header">
    <div>
      <h1 class="page-title">Estadísticas de plataforma</h1>
    </div>
    <a href="<?= FRONT_ROOT ?>Home/menuAdmin" class="btn-outline">Volver al menú</a>
  </div>

  <div style="display:grid; grid-template-columns: 1fr 2fr; gap:14px; align-items:start;">

    <div style="display:flex; flex-direction:column; gap:14px;">

      <div class="card" style="text-align:center;">
        <p class="text-muted" style="font-size:11px; font-weight:500; text-transform:uppercase; letter-spacing:0.05em; margin:0 0 8px;">Total de ofertas</p>
        <p style="font-family:'Lora',serif; font-size:48px; font-weight:500; color:#1c1b19; margin:0; line-height:1;"><?= $offerStats['total_count'] ?></p>
      </div>

      <div class="card">
        <p style="font-size:13px; font-weight:500; color:#1c1b19; margin:0 0 1rem; text-align:center;">Estado de ofertas</p>
        <canvas id="offersChart"></canvas>
      </div>

    </div>

    <div class="card" style="height:100%;">
      <p style="font-size:13px; font-weight:500; color:#1c1b19; margin:0 0 1.25rem;">Top 5 posiciones con más ofertas</p>
      <canvas id="positionsChart"></canvas>
    </div>

  </div>

  <a href="<?= FRONT_ROOT ?>Admin/showDashboard" class="page-back">← Volver al dashboard</a>

</main>

<script>
  const ctxOffers = document.getElementById('offersChart').getContext('2d');
  new Chart(ctxOffers, {
    type: 'doughnut',
    data: {
      labels: ['Activas', 'Inactivas'],
      datasets: [{
        data: [<?= $offerStats['active_count'] ?>, <?= $offerStats['inactive_count'] ?>],
        backgroundColor: ['#37352f', '#e0ddd8'],
        borderWidth: 0
      }]
    },
    options: {
      cutout: '70%',
      plugins: {
        legend: {
          position: 'bottom',
          labels: { font: { family: 'DM Sans', size: 12 }, color: '#9a9790' }
        }
      }
    }
  });

  const ctxPos = document.getElementById('positionsChart').getContext('2d');
  new Chart(ctxPos, {
    type: 'bar',
    data: {
      labels: [<?php foreach ($topPositions as $p) { echo '"' . $p['description'] . '",'; } ?>],
      datasets: [{
        label: 'Cantidad de ofertas',
        data: [<?php foreach ($topPositions as $p) { echo $p['count'] . ','; } ?>],
        backgroundColor: '#37352f',
        borderRadius: 6
      }]
    },
    options: {
      indexAxis: 'y',
      scales: {
        x: { beginAtZero: true, grid: { color: '#f0ede8' }, ticks: { color: '#9a9790', font: { family: 'DM Sans' } } },
        y: { grid: { display: false }, ticks: { color: '#1c1b19', font: { family: 'DM Sans' } } }
      },
      plugins: { legend: { display: false } }
    }
  });
</script>