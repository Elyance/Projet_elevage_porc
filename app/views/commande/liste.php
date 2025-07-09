<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Commandes</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <!-- Formulaire de filtre -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Filtrer les Commandes</h5>
                        <form method="get" action="/commande/list">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="date_debut">Date de début</label>
                                    <input type="date" class="form-control" name="date_debut" id="date_debut" value="<?= htmlspecialchars($date_debut) ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="date_fin">Date de fin</label>
                                    <input type="date" class="form-control" name="date_fin" id="date_fin" value="<?= htmlspecialchars($date_fin) ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="statut">Statut</label>
                                    <select class="form-control" name="statut" id="statut">
                                        <option value="">Tous</option>
                                        <option value="en attente" <?= $statut === 'en attente' ? 'selected' : '' ?>>En attente</option>
                                        <option value="en cours" <?= $statut === 'en cours' ? 'selected' : '' ?>>En cours</option>
                                        <option value="livre" <?= $statut === 'livre' ? 'selected' : '' ?>>Livré</option>
                                        <option value="annule" <?= $statut === 'annule' ? 'selected' : '' ?>>Annulé</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary mr-2">Filtrer</button>
                                    <a href="/commande/list" class="btn btn-secondary">Réinitialiser</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liens d'action -->
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end">
                <a href="/commande/add" class="btn btn-success mr-2">➕ Ajouter une commande</a>
                <a href="/budget/index" class="btn btn-info">💰 Voir le budget</a>
            </div>
        </div>

        <!-- Tableau des commandes -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Liste des Commandes</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered verticle-middle">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID Commande</th>
                                        <th>Client</th>
                                        <th>Enclos/Portée</th>
                                        <th>Race</th>
                                        <th>Quantité</th>
                                        <th>Date Commande</th>
                                        <th>Adresse Livraison</th>
                                        <th>Date Livraison</th>
                                        <th>Statut Livraison</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($commands as $command): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($command->id_commande) ?></td>
                                            <td><?= htmlspecialchars($command->nomClient ?? 'Inconnu') ?></td>
                                            <td><?= htmlspecialchars($command->id_enclos_portee) ?></td>
                                            <td><?= htmlspecialchars($command->nom_race ?? 'Non défini') ?></td>
                                            <td><?= htmlspecialchars($command->quantite) ?></td>
                                            <td><?= htmlspecialchars($command->date_commande) ?></td>
                                            <td><?= htmlspecialchars($command->adresse_livraison) ?></td>
                                            <td><?= htmlspecialchars($command->date_livraison ?? 'Non défini') ?></td>
                                            <td>
                                                <?php
                                                $statut_map = [
                                                    'en attente' => 'En attente',
                                                    'en cours' => 'En cours',
                                                    'livre' => 'Livré',
                                                    'annule' => 'Annulé'
                                                ];
                                                echo htmlspecialchars($statut_map[$command->statut_livraison] ?? $command->statut_livraison);
                                                ?>
                                            </td>
                                            <td>
                                                <a href="/commande/edit-status/<?= $command->id_commande ?>" class="btn btn-warning btn-sm">Modifier</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
