<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Modifier Commande</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            Modifier le statut de la commande #<?= htmlspecialchars($command->id_commande) ?>
                        </h4>

                        <ul class="list-group mb-4">
                            <li class="list-group-item"><strong>Client :</strong> <?= htmlspecialchars($command->nomClient ?? 'Inconnu') ?></li>
                            <li class="list-group-item"><strong>Enclos numéro :</strong> <?= htmlspecialchars($command->id_enclos_portee) ?></li>
                            <li class="list-group-item"><strong>Race :</strong> <?= htmlspecialchars($command->id_race ?? 'Non défini') ?></li>
                            <li class="list-group-item"><strong>Quantité :</strong> <?= htmlspecialchars($command->quantite) ?></li>
                            <li class="list-group-item"><strong>Date Commande :</strong> <?= htmlspecialchars($command->date_commande) ?></li>
                            <li class="list-group-item"><strong>Adresse Livraison :</strong> <?= htmlspecialchars($command->adresse_livraison) ?></li>
                            <li class="list-group-item"><strong>Date Livraison :</strong> <?= htmlspecialchars($command->date_livraison ?? 'Non défini') ?></li>
                            <li class="list-group-item"><strong>Statut Actuel :</strong> <?= htmlspecialchars($command->statut_livraison) ?></li>
                        </ul>

                        <form action="/commande/edit-status/<?= $command->id_commande ?>" method="POST">
                            <div class="form-group">
                                <label for="statut_livraison"><strong>Nouveau Statut :</strong></label>
                                <select name="statut_livraison" id="statut_livraison" class="form-control" required>
                                    <option value="en attente" <?= $command->statut_livraison === 'en attente' ? 'selected' : '' ?>>En attente</option>
                                    <option value="en cours" <?= $command->statut_livraison === 'en cours' ? 'selected' : '' ?>>En cours</option>
                                    <option value="livre" <?= $command->statut_livraison === 'livre' ? 'selected' : '' ?>>Livré</option>
                                    <option value="annule" <?= $command->statut_livraison === 'annule' ? 'selected' : '' ?>>Annulé</option>
                                </select>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">🔄 Mettre à jour</button>
                                <a href="/commande/list" class="btn btn-secondary ml-2">↩️ Retour à la liste</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!--**********************************
    Content body end
***********************************-->
