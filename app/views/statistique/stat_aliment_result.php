<?php
?>
<style>
.stats-aliments-container {
    background: #f8fafc;
    border-radius: 10px;
    margin: 48px auto 0 auto;
    padding: 32px 36px 28px 36px;
    border-left: 4px solid #36b9cc;
    max-width: 1000px;
    font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
}
.stats-aliments-container h2 {
    color: #36b9cc;
    margin-bottom: 18px;
    text-align: center;
}
.stats-aliments-form {
    margin-bottom: 18px;
    text-align: center;
}
.stats-aliments-form label {
    font-weight: 500;
    margin-right: 8px;
}
.stats-aliments-form input[type="number"] {
    width: 90px;
    padding: 5px 8px;
    border-radius: 5px;
    border: 1.5px solid #b6c2d1;
    font-size: 15px;
    background: #fff;
    margin-right: 8px;
}
.stats-aliments-form button {
    background: #36b9cc;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 7px 18px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}
.stats-aliments-form button:hover {
    background: #4e73df;
}
.stats-aliments-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin: 32px auto 0 auto;
    max-width: 950px;
}
.stat-aliment-block {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px #36b9cc22;
    padding: 24px;
    min-height: 300px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
}
.stat-aliment-title {
    font-size: 18px;
    font-weight: 700;
    color: #36b9cc;
    margin-bottom: 20px;
    text-align: center;
}
.top-aliment-info {
    text-align: center;
    margin-bottom: 20px;
}
.top-aliment-name {
    font-size: 17px;
    color: #4e3f26;
    font-weight: 600;
}
.top-aliment-quantity {
    font-size: 15px;
    color: #4e3f26;
    font-weight: 400;
}
.chart-container {
    width: 100%;
    height: 220px;
    margin-top: 10px;
}
@media (max-width: 900px) {
    .stats-aliments-grid {
        grid-template-columns: 1fr;
    }
    .stat-aliment-block {
        min-height: 250px;
    }
}
</style>

<div class="stats-aliments-container">
    <h2>Statistiques des aliments achetés</h2>
    <form class="stats-aliments-form" method="post" action="<?= BASE_URL ?>/statistiques/aliments">
        <label>Année :
            <input type="number" name="annee" value="<?= isset($annee) ? $annee : date('Y') ?>" min="2000" max="<?= date('Y') ?>" required>
        </label>
        <button type="submit">Afficher</button>
    </form>

    <?php if (isset($stats) && $stats['data']): ?>
    <div class="stats-aliments-grid">
        <!-- Colonne 1: Aliment le plus acheté (agrandi) -->
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Aliment le plus acheté</div>
            <div class="top-aliment-info">
                <div class="top-aliment-name"><?= htmlspecialchars($stats['top']['nom_aliment']) ?></div>
                <div class="top-aliment-quantity"><?= number_format($stats['top']['total_kg'], 2, ',', ' ') ?> kg</div>
            </div>
            <div class="chart-container">
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        <!-- Colonne 2: Diagramme en barres -->
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Diagramme en barres</div>
            <div class="chart-container">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Colonne 3: Liste des aliments -->
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Top aliments</div>
            <div style="width: 100%; margin-top: 10px;">
                <ul style="list-style-type: none; padding: 0; margin: 0; text-align: left;">
                    <?php foreach($stats['data'] as $index => $aliment): ?>
                    <li style="padding: 8px 0; border-bottom: 1px solid #eee; color: #4e3f26;">
                        <span style="font-weight: 600;"><?= $index + 1 ?>. </span>
                        <?= htmlspecialchars($aliment['nom_aliment']) ?> 
                        <span style="float: right; font-weight: 600; color: #36b9cc;"><?= number_format($aliment['total_kg'], 1, ',', ' ') ?> kg</span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Aliments
    const dataAliments = <?= json_encode($stats['data']) ?>;
    const labelsAliments = dataAliments.map(d => d.nom_aliment);
    const valuesAliments = dataAliments.map(d => parseFloat(d.total_kg));
    
    if (labelsAliments.length > 0) {
        // Diagramme en barres
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: labelsAliments,
                datasets: [{
                    label: 'Quantité achetée (kg)',
                    data: valuesAliments,
                    backgroundColor: '#4e73df',
                    borderColor: '#fff',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Diagramme camembert
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: labelsAliments,
                datasets: [{
                    data: valuesAliments,
                    backgroundColor: ['#4e73df','#36b9cc','#f6c23e','#e74a3b','#1cc88a','#858796'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    }
                }
            }
        });
    }
    </script>
    <?php elseif(isset($stats)): ?>
        <p style="text-align: center; color: #95a5a6;">Aucune donnée pour cette année.</p>
    <?php endif; ?>
</div>