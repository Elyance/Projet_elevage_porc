<?php
?>
<style>
.stats-aliments-container {
    background: #f8fafc;
    border-radius: 10px;
    margin: 48px auto 0 auto;
    padding: 32px 36px 28px 36px;
    border-left: 4px solid #36b9cc;
    max-width: 700px;
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
.stats-aliments-charts {
    display: flex;
    gap: 40px;
    justify-content: center;
    align-items: flex-start;
    margin-top: 18px;
}
@media (max-width: 900px) {
    .stats-aliments-charts { flex-direction: column; gap: 18px; align-items: center; }
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
        <p><b>Aliment le plus acheté :</b> <?= htmlspecialchars($stats['top']['nom_aliment']) ?> (<?= number_format($stats['top']['total_kg'], 2, ',', ' ') ?> kg)</p>
        <div class="stats-aliments-charts">
            <div style="width:350px;">
                <canvas id="barChart" height="180"></canvas>
            </div>
            <div style="width:350px;">
                <canvas id="pieChart" height="180"></canvas>
            </div>
        </div>
        <?php if (isset($stats_vente) && $stats_vente['moisPlusRentable']): ?>
            <div class="stats-ventes-container" style="margin-top:32px;">
                <h3 style="color:#4e73df;text-align:center;">Statistiques des ventes</h3>
                <p><b>Mois le plus rentable :</b> Mois <?= $stats_vente['moisPlusRentable']['mois'] ?> (<?= $stats_vente['moisPlusRentable']['total_ventes'] ?> ventes)</p>
                <h4 style="margin:10px 0 5px 0;">Top 5 clients</h4>
                <ul>
                    <?php foreach($stats_vente['topClients'] as $client): ?>
                        <li><?= htmlspecialchars($client['nom_client']) ?> : <?= $client['total_ventes'] ?> ventes</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif(isset($stats_vente)): ?>
            <div class="stats-ventes-container" style="margin-top:32px;">
                <h3 style="color:#4e73df;text-align:center;">Statistiques des ventes</h3>
                <p>Aucune vente pour cette année.</p>
            </div>
        <?php endif; ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        // Aliments
        const dataAliments = <?= json_encode($stats['data']) ?>;
        const labelsAliments = dataAliments.map(d => d.nom_aliment);
        const valuesAliments = dataAliments.map(d => parseFloat(d.total_kg));
        if (labelsAliments.length > 0) {
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: labelsAliments,
                    datasets: [{
                        label: 'Quantité achetée (kg)',
                        data: valuesAliments,
                        backgroundColor: '#4e73df'
                    }]
                },
                options: {responsive: true}
            });
            new Chart(document.getElementById('pieChart'), {
                type: 'pie',
                data: {
                    labels: labelsAliments,
                    datasets: [{
                        data: valuesAliments,
                        backgroundColor: ['#4e73df','#36b9cc','#f6c23e','#e74a3b','#1cc88a','#858796']
                    }]
                },
                options: {responsive: true}
            });
        }
        // Top 5 clients ventes (barres)
        <?php if (isset($stats_vente) && $stats_vente['topClients']): ?>
        const topClients = <?= json_encode($stats_vente['topClients']) ?>;
        const clientLabels = topClients.map(d => d.nom_client);
        const clientValues = topClients.map(d => parseInt(d.total_ventes));
        if (clientLabels.length > 0) {
            const venteBar = document.createElement('canvas');
            venteBar.id = 'barVenteChart';
            venteBar.height = 180;
            document.querySelector('.stats-ventes-container').appendChild(venteBar);
            new Chart(venteBar, {
                type: 'bar',
                data: {
                    labels: clientLabels,
                    datasets: [{
                        label: 'Ventes par client (top 5)',
                        data: clientValues,
                        backgroundColor: '#f6c23e'
                    }]
                },
                options: {responsive: true}
            });
        }
        // Ventes par mois (camembert)
        const ventesMois = <?= json_encode($stats_vente['ventesMois']) ?>;
        const moisLabels = ventesMois.map(d => 'Mois ' + d.mois);
        const moisValues = ventesMois.map(d => parseInt(d.total_ventes));
        if (moisLabels.length > 0) {
            const ventePie = document.createElement('canvas');
            ventePie.id = 'pieVenteChart';
            ventePie.height = 180;
            document.querySelector('.stats-ventes-container').appendChild(ventePie);
            new Chart(ventePie, {
                type: 'pie',
                data: {
                    labels: moisLabels,
                    datasets: [{
                        data: moisValues,
                        backgroundColor: ['#4e73df','#36b9cc','#f6c23e','#e74a3b','#1cc88a','#858796','#a569bd','#f1948a','#7dcea0','#f7ca18','#34495e','#d35400']
                    }]
                },
                options: {responsive: true}
            });
        }
        <?php endif; ?>
        </script>
    <?php elseif(isset($stats)): ?>
        <p>Aucune donnée pour cette année.</p>
    <?php endif; ?>
</div>