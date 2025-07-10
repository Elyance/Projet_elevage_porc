<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Liste des commandes</h4>
                </div>
                
                <div class="basic-form mb-4">
                    <form method="get" action="<?= BASE_URL?>/commande/list">
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
                            <label class="col-sm-2 col-form-label">Statut</label>
                            <div class="col-sm-4">
                                <select name="statut" id="statut" class="form-control">
                                    <option value="">Tous</option>
                                    <option value="en attente" <?= $statut === 'en attente' ? 'selected' : '' ?>>En attente</option>
                                    <option value="en cours" <?= $statut === 'en cours' ? 'selected' : '' ?>>En cours</option>
                                    <option value="livre" <?= $statut === 'livre' ? 'selected' : '' ?>>Livré</option>
                                    <option value="annule" <?= $statut === 'annule' ? 'selected' : '' ?>>Annulé</option>
                                </select>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button type="submit" class="btn btn-primary">Filtrer</button>
                                <a href="<?= BASE_URL?>/commande/list" class="btn btn-secondary">Réinitialiser</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
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
                                        <a href="<?= BASE_URL?>/commande/edit-status/<?= $command->id_commande ?>" class="btn btn-warning btn-sm">Modifier statut</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
