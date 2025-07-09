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
.stats-fin-container {
    background: #fffbe6;
    border-radius: 10px;
    margin: 38px auto 0 auto;
    padding: 28px 32px 24px 32px;
    border-left: 4px solid #f6c23e;
    max-width: 700px;
    font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
    box-shadow: 0 2px 12px #f6c23e22;
}
.stats-fin-container h3 {
    color: #f6c23e;
    margin-bottom: 18px;
    text-align: center;
}
.stats-fin-row {
    display: flex;
    gap: 32px;
    justify-content: center;
    align-items: flex-start;
    margin-top: 18px;
}
.stats-fin-col {
    flex: 1;
    min-width: 220px;
}
.stats-fin-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    font-size: 15px;
}
.stats-fin-table th, .stats-fin-table td {
    border: 1px solid #f6c23e55;
    padding: 7px 8px;
    text-align: center;
}
.stats-fin-table th {
    background: #fffbe6;
    color: #b48a00;
}
.stats-fin-key {
    color: #b48a00;
    font-weight: 600;
}
.stats-fin-val {
    color: #1cc88a;
    font-weight: 600;
}
.stats-aliments-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    gap: 32px 32px;
    max-width: 950px;
    margin: 48px auto 0 auto;
    padding: 0 10px;
}
.stat-aliment-block {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px #36b9cc22;
    padding: 28px 22px;
    min-height: 160px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    color: #36b9cc;
    font-weight: 600;
    text-align: center;
}
.stat-aliment-title {
    font-size: 18px;
    font-weight: 700;
    color: #36b9cc;
    margin-bottom: 10px;
}
</style>
<div class="stats-aliments-container">
    <h2>Statistiques des aliments achetés</h2>
    <form class="stats-aliments-form" method="post" action="<?= Flight::get('flight.base_url') ?>/statistiques/aliments">
        <label>Année :
            <input type="number" name="annee" value="<?= isset($annee) ? $annee : date('Y') ?>" min="2000" max="<?= date('Y') ?>" required>
        </label>
        <button type="submit">Afficher</button>
    </form>
    <?php if (isset($stats) && $stats['data']): ?>
    <div class="stats-aliments-grid">
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Aliment le plus acheté</div>
            <div><?= htmlspecialchars($stats['top']['nom_aliment']) ?> <br><span style="color:#4e3f26;font-weight:400;">(<?= number_format($stats['top']['total_kg'], 2, ',', ' ') ?> kg)</span></div>
        </div>
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Diagramme en barres</div>
            <canvas id="barChart" height="140"></canvas>
        </div>
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Diagramme camembert</div>
            <canvas id="pieChart" height="140"></canvas>
        </div>
        <div class="stat-aliment-block">
            <div class="stat-aliment-title">Statistiques des ventes</div>
            <?php if (isset($stats_vente) && $stats_vente['moisPlusRentable']): ?>
                <div style="color:#4e73df;font-weight:600;">Mois le plus rentable : Mois <?= $stats_vente['moisPlusRentable']['mois'] ?> (<?= $stats_vente['moisPlusRentable']['total_ventes'] ?> ventes)</div>
                <div style="margin:8px 0 0 0;text-align:left;">
                    <b>Top 5 clients</b>
                    <ul style="margin:4px 0 0 16px;padding:0;">
                        <?php foreach($stats_vente['topClients'] as $client): ?>
                            <li style="color:#4e3f26;font-weight:400;"><?= htmlspecialchars($client['nom_client']) ?> : <?= $client['total_ventes'] ?> ventes</li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php elseif(isset($stats_vente)): ?>
                <div>Aucune vente pour cette année.</div>
            <?php endif; ?>
        </div>
    </div>
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
    </script>
    <?php elseif(isset($stats)): ?>
        <p>Aucune donnée pour cette année.</p>
    <?php endif; ?>
</div>
<?php
// Statistiques financières fictives pour l'exemple (à remplacer par des vraies requêtes SQL)
$benefices_mois = [
    ['mois' => 'Janvier', 'benefice' => 120000],
    ['mois' => 'Février', 'benefice' => 95000],
    ['mois' => 'Mars', 'benefice' => 150000],
    ['mois' => 'Avril', 'benefice' => 110000],
    ['mois' => 'Mai', 'benefice' => 130000],
    ['mois' => 'Juin', 'benefice' => 170000],
    ['mois' => 'Juillet', 'benefice' => 90000],
    ['mois' => 'Août', 'benefice' => 140000],
    ['mois' => 'Septembre', 'benefice' => 160000],
    ['mois' => 'Octobre', 'benefice' => 180000],
    ['mois' => 'Novembre', 'benefice' => 120000],
    ['mois' => 'Décembre', 'benefice' => 200000],
];
$benefice_annuel = array_sum(array_column($benefices_mois, 'benefice'));
$roi = 32.5; // exemple
$couts = [
    ['poste' => 'Alimentation', 'valeur' => 1200000],
    ['poste' => 'Soins', 'valeur' => 350000],
    ['poste' => 'Achats', 'valeur' => 500000],
    ['poste' => 'Autres', 'valeur' => 200000],
];
?>
<div class="stats-fin-container">
    <h3>Statistiques financières</h3>
    <div class="stats-fin-row">
        <div class="stats-fin-col">
            <b>Bénéfice net par mois</b>
            <canvas id="beneficeMoisChart" height="140"></canvas>
        </div>
        <div class="stats-fin-col">
            <b>Répartition des coûts</b>
            <canvas id="coutsPieChart" height="140"></canvas>
        </div>
    </div>
    <table class="stats-fin-table" style="margin-top:22px;">
        <tr><th>Bénéfice annuel</th><th>ROI</th></tr>
        <tr><td class="stats-fin-val"><?= number_format($benefice_annuel, 0, ',', ' ') ?> Ar</td><td class="stats-fin-key"><?= $roi ?> %</td></tr>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Bénéfice net par mois
const beneficesMois = <?= json_encode($benefices_mois) ?>;
const moisLabelsFin = beneficesMois.map(d => d.mois);
const beneficeValues = beneficesMois.map(d => d.benefice);
new Chart(document.getElementById('beneficeMoisChart'), {
    type: 'bar',
    data: {
        labels: moisLabelsFin,
        datasets: [{
            label: 'Bénéfice net (Ar)',
            data: beneficeValues,
            backgroundColor: '#1cc88a'
        }]
    },
    options: {responsive: true}
});
// Répartition des coûts
const couts = <?= json_encode($couts) ?>;
const coutsLabels = couts.map(d => d.poste);
const coutsValues = couts.map(d => d.valeur);
new Chart(document.getElementById('coutsPieChart'), {
    type: 'pie',
    data: {
        labels: coutsLabels,
        datasets: [{
            data: coutsValues,
            backgroundColor: ['#f6c23e','#4e73df','#36b9cc','#e74a3b']
        }]
    },
    options: {responsive: true}
});
</script>