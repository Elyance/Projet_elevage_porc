<?php
?>
<style>
.stats-aliments-container {
    background: #f8fafc;
    border-radius: 10px;
    margin: 48px auto 0 auto;
    padding: 32px 36px 28px 36px;
    border-left: 4px solid #36b9cc;
    max-width: 1200px;
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
    margin: 32px 0;
}
.stat-aliment-block {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(54, 185, 204, 0.15);
    padding: 20px;
    min-height: 280px;
    display: flex;
    flex-direction: column;
    font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
}
.stat-aliment-title {
    font-size: 16px;
    font-weight: 700;
    color: #36b9cc;
    margin-bottom: 15px;
    text-align: center;
}
.chart-container {
    flex: 1;
    min-height: 200px;
    position: relative;
}
.list-items {
    margin: 0;
    padding: 0;
    list-style: none;
}
.list-items li {
    padding: 6px 0;
    border-bottom: 1px solid #eee;
    color: #555;
    font-size: 14px;
}
.list-items li:last-child {
    border-bottom: none;
}
.no-data {
    color: #999;
    text-align: center;
    margin-top: 40px;
    font-style: italic;
}
@media (max-width: 900px) {
    .stats-aliments-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<div class="stats-aliments-container">
    <h2>Statistiques des ventes</h2>
    <form class="stats-aliments-form" method="post" action="<?= BASE_URL ?>/statistiques/ventes">
        <label>Année :
            <input type="number" name="annee" value="<?= isset($annee) ? $annee : date('Y') ?>" min="2000" max="<?= date('Y') ?>" required>
        </label>
        <button type="submit">Afficher</button>
    </form>
    
    <?php if (isset($stats) && $stats['nbCommandes'] > 0): ?>
    <div class="stats-aliments-grid">
        <!-- Ligne 1 -->
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Total commandes</div>
            <div style="text-align: center; font-size: 32px; color: #4e73df; margin-top: 30px;">
                <?= $stats['nbCommandes'] ?>
            </div>
        </div>
        
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Quantité totale vendue</div>
            <div style="text-align: center; font-size: 32px; color: #1cc88a; margin-top: 30px;">
                <?= number_format($stats['quantiteTotale'], 0, ',', ' ') ?> porcs
            </div>
        </div>
        
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Top 5 clients</div>
            <ul class="list-items">
                <?php foreach($stats['topClients'] as $client): ?>
                    <li>
                        <?= htmlspecialchars($client['nom_client']) ?> : 
                        <strong><?= $client['total_ventes'] ?></strong> porcs
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <!-- Ligne 2 -->
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Ventes par mois (Line Chart)</div>
            <div class="chart-container">
                <canvas id="ventesMoisLineChart"></canvas>
            </div>
        </div>
        
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Ventes par mois (Bar Chart)</div>
            <div class="chart-container">
                <canvas id="ventesMoisBarChart"></canvas>
            </div>
        </div>
        
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Répartition statuts (Donut)</div>
            <div class="chart-container">
                <canvas id="statutDonutChart"></canvas>
            </div>
        </div>
        
        <!-- Ligne 3 -->
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Livraisons par mois (Area Chart)</div>
            <div class="chart-container">
                <canvas id="livraisonAreaChart"></canvas>
            </div>
        </div>
        
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Top adresses livraison</div>
            <ul class="list-items">
                <?php foreach($stats['adresses'] as $adr): ?>
                    <li>
                        <?= htmlspecialchars($adr['adresse_livraison']) ?> : 
                        <strong><?= $adr['nb'] ?></strong> cmd
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Top enclos</div>
            <ul class="list-items">
                <?php foreach($stats['enclos'] as $enclos): ?>
                    <li>
                        Enclos <?= $enclos['id_enclos_portee'] ?> : 
                        <strong><?= $enclos['nb'] ?></strong> cmd
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Couleurs
    const colors = {
        blue: '#4e73df',
        lightBlue: '#36b9cc',
        green: '#1cc88a',
        yellow: '#f6c23e',
        red: '#e74a3b',
        gray: '#858796'
    };
    
    // Ventes par mois - Line Chart
    const ventesMois = <?= json_encode($stats['ventesMois']) ?>;
    const moisLabels = ventesMois.map(d => 'M' + d.mois);
    const ventesValues = ventesMois.map(d => parseInt(d.total_ventes));
    new Chart(document.getElementById('ventesMoisLineChart'), {
        type: 'line',
        data: {
            labels: moisLabels,
            datasets: [{
                label: 'Ventes',
                data: ventesValues,
                backgroundColor: colors.blue + '20',
                borderColor: colors.blue,
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
    
    // Ventes par mois - Bar Chart
    new Chart(document.getElementById('ventesMoisBarChart'), {
        type: 'bar',
        data: {
            labels: moisLabels,
            datasets: [{
                label: 'Ventes',
                data: ventesValues,
                backgroundColor: Array(moisLabels.length).fill().map((_, i) => 
                    i % 2 ? colors.blue : colors.lightBlue)
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
    
    // Statuts livraison - Donut Chart
    const statuts = <?= json_encode($stats['statuts']) ?>;
    const statutLabels = statuts.map(d => d.statut_livraison);
    const statutValues = statuts.map(d => parseInt(d.nb));
    new Chart(document.getElementById('statutDonutChart'), {
        type: 'doughnut',
        data: {
            labels: statutLabels,
            datasets: [{
                data: statutValues,
                backgroundColor: [colors.blue, colors.lightBlue, colors.yellow, colors.red, colors.green, colors.gray],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12 }
                }
            }
        }
    });
    
    // Livraisons par mois - Area Chart
    const livraisons = <?= json_encode($stats['livraisons']) ?>;
    const livMoisLabels = livraisons.map(d => 'M' + d.mois);
    const livMoisValues = livraisons.map(d => parseInt(d.nb));
    new Chart(document.getElementById('livraisonAreaChart'), {
        type: 'line',
        data: {
            labels: livMoisLabels,
            datasets: [{
                label: 'Livraisons',
                data: livMoisValues,
                backgroundColor: colors.green + '40',
                borderColor: colors.green,
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
    </script>
    
    <?php elseif(isset($stats)): ?>
        <p class="no-data">Aucune donnée disponible pour cette année.</p>
    <?php endif; ?>
</div>