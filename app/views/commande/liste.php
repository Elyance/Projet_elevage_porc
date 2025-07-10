<h2>Liste des commandes</h2>

<form method="get" action="/commande/list">
    <div>
        <label for="date_debut">Date de début</label>
        <input type="date" name="date_debut" id="date_debut" value="<?= htmlspecialchars($date_debut) ?>">
    </div>
    <div>
        <label for="date_fin">Date de fin</label>
        <input type="date" name="date_fin" id="date_fin" value="<?= htmlspecialchars($date_fin) ?>">
    </div>
    <div>
        <label for="statut">Statut</label>
        <select name="statut" id="statut">
            <option value="">Tous</option>
            <option value="en attente" <?= $statut === 'en attente' ? 'selected' : '' ?>>En attente</option>
            <option value="en cours" <?= $statut === 'en cours' ? 'selected' : '' ?>>En cours</option>
            <option value="livre" <?= $statut === 'livre' ? 'selected' : '' ?>>Livré</option>
            <option value="annule" <?= $statut === 'annule' ? 'selected' : '' ?>>Annulé</option>
        </select>
    </div>
    <button type="submit">Filtrer</button>
    <a href="<?= BASE_URL?>/commande/list">Réinitialiser</a>
</form>

<table border="1">
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
    <?php foreach ($commands as $command): ?>
        <tr>
            <td><?= htmlspecialchars($command->id_commande) ?></td>
            <td><?= htmlspecialchars($command->nomClient ?? 'Inconnu') ?></td>
            <td><?= htmlspecialchars($command->id_enclos_portee) ?></td>
            <td><?= htmlspecialchars($command->nom_race ?? 'Non défini') ?></td> <!-- ✅ Affichage du nom_race -->
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
            <td><a href="<?= BASE_URL?>/commande/edit-status/<?= $command->id_commande ?>"><button>Modifier statut</button></a></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="<?= BASE_URL?>/commande/add">Ajouter une nouvelle commande</a>
<a href="<?= BASE_URL?>/budget/index">Voir le budget</a>