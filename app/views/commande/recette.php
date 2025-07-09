<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Recettes</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Formulaire de filtre -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Filtrer les Recettes</h5>
                        <form method="get" action="/commande/recette">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="date_debut">Date de début</label>
                                    <input type="date" class="form-control" name="date_debut" id="date_debut" value="<?= htmlspecialchars($date_debut) ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="date_fin">Date de fin</label>
                                    <input type="date" class="form-control" name="date_fin" id="date_fin" value="<?= htmlspecialchars($date_fin) ?>">
                                </div>
                                <div class="form-group col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary mr-2">Filtrer</button>
                                    <a href="/commande/recette" class="btn btn-secondary">Réinitialiser</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end">
                <a href="/commande/add" class="btn btn-success mr-2">➕ Ajouter une commande</a>
                <a href="/budget/index" class="btn btn-info">💰 Voir le budget</a>
            </div>
        </div>

        <!-- Recette totale -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-success">
                    <strong>Recette totale :</strong> <?= number_format($total_recette, 2) ?> Ar
                </div>
            </div>
        </div>

        <!-- Tableau des recettes -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Liste des Recettes</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered verticle-middle">
                                <thead class="thead-dark">
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
                        </div> <!-- .table-responsive -->
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- .container-fluid -->

</div>
<!--**********************************
    Content body end
***********************************-->
