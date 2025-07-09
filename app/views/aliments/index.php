<?php require_once __DIR__ . '/partials/header.php'; ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Stock des Aliments</h4>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Stock (kg)</th>
                                <th>Consommation/jour (kg)</th>
                                <th>Prix/kg (MGA)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aliments as $aliment): ?>
                                <tr>
                                    <td><?= htmlspecialchars($aliment['nom_aliment']) ?></td>
                                    <td><?= number_format($aliment['stock_kg'], 2) ?></td>
                                    <td><?= number_format($aliment['conso_journaliere_totale'], 2) ?></td>
                                    <td class="color-primary"><?= number_format($aliment['prix_kg'], 2) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL?>/aliments/<?= $aliment['id_aliment'] ?>" class="btn btn-info btn-sm">Voir Détails</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics and Chart Section -->
    <div class="col-lg-4">
        <!-- Donut Chart -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Répartition du Stock</h4>
                <div id="morris-donut-chart"></div>
                
                <!-- Statistics below the chart -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Aliments différents:</span>
                        <span class="font-weight-bold"><?= count($aliments) ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Stock total:</span>
                        <span class="font-weight-bold"><?= number_format(array_sum(array_column($aliments, 'stock_kg')), 2) ?> kg</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= STATIC_URL?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?= STATIC_URL?>/assets/plugins/morris/morris.min.js"></script>
<script>
$(document).ready(function() {
    var chartData = <?= json_encode(array_values($aliments)) ?>;
    Morris.Donut({
        element: 'morris-donut-chart',
        data: chartData.map(function(aliment) {
            return {
                label: aliment.nom_aliment,
                value: aliment.stock_kg
            };
        }),
        resize: true,
        colors: ['#4d7cff', '#7571F9', '#9097c4', '#FF6384', '#36A2EB', '#FFCE56'],
        formatter: function(value) { return value + ' kg'; }
    });
});
</script>
