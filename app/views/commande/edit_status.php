<h2>Modifier le statut de la commande #<?= htmlspecialchars($command->id_commande) ?></h2>
<p><strong>Client:</strong> <?= htmlspecialchars($command->nomClient ?? 'Inconnu') ?></p>
<p><strong>Enclos numero:</strong> <?= htmlspecialchars($command->id_enclos_portee) ?></p>
<p><strong>Race:</strong> <?= htmlspecialchars($command->id_race ?? 'Non défini') ?></p>
<p><strong>Quantité:</strong> <?= htmlspecialchars($command->quantite) ?></p>
<p><strong>Date Commande:</strong> <?= htmlspecialchars($command->date_commande) ?></p>
<p><strong>Adresse Livraison:</strong> <?= htmlspecialchars($command->adresse_livraison) ?></p>
<p><strong>Date Livraison:</strong> <?= htmlspecialchars($command->date_livraison ?? 'Non défini') ?></p>
<p><strong>Statut Actuel:</strong> <?= htmlspecialchars($command->statut_livraison) ?></p>

<form action="/commande/edit-status/<?= $command->id_commande ?>" method="POST">
    <label for="statut_livraison">Nouveau Statut:</label>
    <select name="statut_livraison" id="statut_livraison" required>
        <option value="en attente" <?= $command->statut_livraison === 'en attente' ? 'selected' : '' ?>>En attente</option>
        <option value="en cours" <?= $command->statut_livraison === 'en cours' ? 'selected' : '' ?>>En cours</option>
        <option value="livre" <?= $command->statut_livraison === 'livre' ? 'selected' : '' ?>>Livré</option>
        <option value="annule" <?= $command->statut_livraison === 'annule' ? 'selected' : '' ?>>Annulé</option>
    </select>
    <br>
    <button type="submit">Mettre à jour</button>
</form>
<a href="/commande/list">Retour à la liste</a>