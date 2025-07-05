<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="card">
    <div class="card-header">
        <h2>🔍 Détails de l'aliment : <?= htmlspecialchars($aliment['nom_aliment']) ?></h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Stock actuel :</strong> <?= number_format($aliment['stock_kg'], 2) ?> kg
                    </li>
                    <li class="list-group-item">
                        <strong>Prix au kg :</strong> <?= number_format($aliment['prix_kg'], 2) ?> MGA
                    </li>
                    <li class="list-group-item">
                        <strong>Contact fournisseur :</strong> <?= htmlspecialchars($aliment['contact_fournisseur']) ?>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Apports nutritionnels :</strong>
                    </div>
                    <div class="card-body">
                        <p><?= nl2br(htmlspecialchars($aliment['apports_nutritionnels'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mt-4">Historique des réapprovisionnements</h4>
        <?php if (!empty($aliment['quantite_reappro'])): ?>
            <table class="table table-sm">
                <tr>
                    <th>Date</th>
                    <th>Quantité (kg)</th>
                    <th>Coût total (MGA)</th>
                </tr>
                <tr>
                    <td><?= date('d/m/Y', strtotime($aliment['date_reappro'])) ?></td>
                    <td><?= number_format($aliment['quantite_reappro'], 2) ?></td>
                    <td><?= number_format($aliment['cout_total'], 2) ?></td>
                </tr>
            </table>
        <?php else: ?>
            <div class="alert alert-warning">Aucun réapprovisionnement enregistré.</div>
        <?php endif; ?>

        <a href="/aliments" class="btn btn-secondary mt-3">← Retour à la liste</a>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>