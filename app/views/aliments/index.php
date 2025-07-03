<?php require_once __DIR__ . '../app/views/aliments/partials/header.php'; ?>

<div class="row">
    <div class="col-md-9">
        <!-- Contenu actuel de la table -->
    </div>
    <?php require_once __DIR__ . '../app/views/aliments/partials/sidebar.php'; ?>
</div>

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

<?php require_once __DIR__ . '../app/views/aliments/partials/footer.php'; ?>