<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-md-9">
        <h2>📦 Stock des Aliments</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
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
                            <td><?= number_format($aliment['prix_kg'], 2) ?></td>
                            <td>
                                <a href="/aliments/<?= $aliment['id_aliment'] ?>" class="btn btn-info btn-sm">🔍 Détails</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (isset($showSidebar) && $showSidebar): ?>
            <?php Flight::render('aliments/partials/sidebar', [
                'aliments' => $aliments // Passer explicitement les variables
            ]) ?>
        <?php endif; ?>
        <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>