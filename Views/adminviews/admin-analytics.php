<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
    use Utils\Utils;
    Utils::checkNav();
?>
<main class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Estadísticas de Plataforma</h2>
            <a href="<?= FRONT_ROOT ?>Home/menuAdmin" class="btn btn-outline-secondary btn-sm">Volver al Menú</a>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 mb-3" style="border-radius: 12px;">
                    <div class="card-body text-center">
                        <h6 class="text-muted text-uppercase small fw-bold">Total de Ofertas</h6>
                        <h2 class="display-5 fw-bold text-dark"><?= $offerStats['total_count'] ?></h2>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm p-4" style="border-radius: 12px;">
                    <h6 class="fw-bold mb-3 text-center">Estado de Ofertas</h6>
                    <canvas id="offersChart"></canvas>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 12px; height: 100%;">
                    <h6 class="fw-bold mb-4">Top 5 Posiciones con más Ofertas</h6>
                    <canvas id="positionsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Configuración Gráfico de Torta (Ofertas)
    const ctxOffers = document.getElementById('offersChart').getContext('2d');
    new Chart(ctxOffers, {
        type: 'doughnut',
        data: {
            labels: ['Activas/Vigentes', 'Inactivas/Vencidas'],
            datasets: [{
                data: [<?= $offerStats['active_count'] ?>, <?= $offerStats['inactive_count'] ?>],
                backgroundColor: ['#198754', '#dee2e6'],
                borderWidth: 0
            }]
        },
        options: { cutout: '70%', plugins: { legend: { position: 'bottom' } } }
    });

    // Configuración Gráfico de Barras (Posiciones)
    const ctxPos = document.getElementById('positionsChart').getContext('2d');
    new Chart(ctxPos, {
        type: 'bar',
        data: {
            labels: [<?php foreach($topPositions as $p) { echo '"' . $p['description'] . '",'; } ?>],
            datasets: [{
                label: 'Cantidad de Ofertas',
                data: [<?php foreach($topPositions as $p) { echo $p['count'] . ','; } ?>],
                backgroundColor: '#37352f',
                borderRadius: 5
            }]
        },
        options: {
            indexAxis: 'y', // Barra horizontal para que se lean mejor los nombres largos
            scales: { x: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });
</script>