<h2>Liste des commandes</h2>
<table border="1">
    <tr>
        <th>ID Commande</th>
        <th>Client</th>
        <th>Enclos/Portée</th>
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
            <td><?= htmlspecialchars($command->quantite) ?></td>
            <td><?= htmlspecialchars($command->date_commande) ?></td>
            <td><?= htmlspecialchars($command->adresse_livraison) ?></td>
            <td><?= htmlspecialchars($command->date_livraison ?? 'Non défini') ?></td>
            <td><?= htmlspecialchars($command->statut_livraison) ?></td>
            <td><a href="/commande/edit-status/<?= $command->id_commande ?>"><button>Modifier statut</button></a></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="/commande/add">Ajouter une nouvelle commande</a>
<a href="/budget/index">Voir le budget</a>