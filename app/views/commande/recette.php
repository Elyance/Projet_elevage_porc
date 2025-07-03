<h2>Recettes</h2>
<table>
    <tr>
        <th>ID Commande</th>
        <th>Client</th>
        <th>Date Recette</th>
        <th>Quantité</th>
        <th>Prix Unitaire</th>
        <th>Prix Total</th>
    </tr>
    <?php foreach ($recettes as $recette): ?>
        <tr>
            <td><?= $recette['id_commande'] ?></td>
            <td><?= $recette['nom_client'] ?></td>
            <td><?= $recette['date_recette'] ?></td>
            <td><?= $recette['quantite'] ?></td>
            <td><?= $recette['prix_unitaire'] ?></td>
            <td><?= $recette['prix_total'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>