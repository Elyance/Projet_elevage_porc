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
    </tr>
    <?php foreach ($commands as $command): ?>
        <tr>
            <td><?= $command->id_commande ?></td>
            <td><?= $command->nomClient ?? 'Inconnu' ?></td>
            <td><?= $command->id_enclos_portee ?></td>
            <td><?= $command->quantite ?></td>
            <td><?= $command->date_commande ?></td>
            <td><?= $command->adresse_livraison ?></td>
            <td><?= $command->date_livraison ?? 'Non défini' ?></td>
            <td><?= $command->statut_livraison ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="/commande/add">Ajouter une nouvelle commande</a>
<a href="/budget/index">Voir le budget</a>
