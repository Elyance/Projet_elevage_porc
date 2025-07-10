<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Recettes</h4>
                </div>

                <div class="basic-form mb-4">
                    <form method="get" action="<?= BASE_URL?>/commande/recette">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Date de début</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="date_debut" id="date_debut" value="<?= htmlspecialchars($date_debut) ?>">
                            </div>
                            <label class="col-sm-2 col-form-label">Date de fin</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="date_fin" id="date_fin" value="<?= htmlspecialchars($date_fin) ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-primary">Filtrer</button>
                                <a href="<?= BASE_URL?>/commande/recette" class="btn btn-secondary">Réinitialiser</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="alert alert-info">
                    <strong>Recette totale : </strong><?= number_format($total_recette, 2) ?> Ar
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Commande</th>
                                <th>Client</th>
                                <th>Date Recette</th>
                                <th>Quantité</th>
                                <th>Prix Unitaire</th>
                                <th>Prix Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recettes)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Aucune recette trouvée pour les dates sélectionnées.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recettes as $recette): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($recette['id_commande']) ?></td>
                                        <td><?= htmlspecialchars($recette['nomclient']) ?></td>
                                        <td><?= htmlspecialchars($recette['date_recette']) ?></td>
                                        <td><?= htmlspecialchars($recette['quantite']) ?></td>
                                        <td><?= htmlspecialchars($recette['prix_unitaire']) ?></td>
                                        <td><?= htmlspecialchars($recette['prix_total']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <a href="<?= BASE_URL?>/commande/add" class="btn btn-primary">Ajouter une nouvelle commande</a>
                    <a href="<?= BASE_URL?>/budget/index" class="btn btn-info ml-2">Voir le budget</a>
                </div>
            </div>
        </div>
    </div>
</div>