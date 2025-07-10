<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Modifier le statut de la commande #<?= htmlspecialchars($command->id_commande) ?></h4>
                </div>
                
                <div class="mb-4">
                    <p><strong>Client:</strong> <?= htmlspecialchars($command->nomClient ?? 'Inconnu') ?></p>
                    <p><strong>Enclos numero:</strong> <?= htmlspecialchars($command->id_enclos_portee) ?></p>
                    <p><strong>Race:</strong> <?= htmlspecialchars($command->id_race ?? 'Non défini') ?></p>
                    <p><strong>Quantité:</strong> <?= htmlspecialchars($command->quantite) ?></p>
                    <p><strong>Date Commande:</strong> <?= htmlspecialchars($command->date_commande) ?></p>
                    <p><strong>Adresse Livraison:</strong> <?= htmlspecialchars($command->adresse_livraison) ?></p>
                    <p><strong>Date Livraison:</strong> <?= htmlspecialchars($command->date_livraison ?? 'Non défini') ?></p>
                    <p><strong>Statut Actuel:</strong> <?= htmlspecialchars($command->statut_livraison) ?></p>
                </div>

                <div class="basic-form">
                    <form action="<?= BASE_URL?>/commande/edit-status/<?= $command->id_commande ?>" method="POST">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nouveau Statut</label>
                            <div class="col-sm-10">
                                <select name="statut_livraison" id="statut_livraison" class="form-control" required>
                                    <option value="en attente" <?= $command->statut_livraison === 'en attente' ? 'selected' : '' ?>>En attente</option>
                                    <option value="en cours" <?= $command->statut_livraison === 'en cours' ? 'selected' : '' ?>>En cours</option>
                                    <option value="livre" <?= $command->statut_livraison === 'livre' ? 'selected' : '' ?>>Livré</option>
                                    <option value="annule" <?= $command->statut_livraison === 'annule' ? 'selected' : '' ?>>Annulé</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                <a href="<?= BASE_URL?>/commande/list" class="btn btn-secondary">Retour à la liste</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
