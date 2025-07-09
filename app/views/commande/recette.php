<h2>Recettes</h2>
<form method="get" action="/commande/recette">
    <div>
        <label for="date_debut">Date de début</label>
        <input type="date" name="date_debut" id="date_debut" value="<?= htmlspecialchars($date_debut) ?>">
    </div>
    <div>
        <label for="date_fin">Date de fin</label>
        <input type="date" name="date_fin" id="date_fin" value="<?= htmlspecialchars($date_fin) ?>">
    </div>
    <button type="submit">Filtrer</button>
    <a href="/commande/recette">Réinitialiser</a>
</form>
<table border="1">
<a href="/budget/index">Voir le budget</a>

<p><strong>Recette totale : </strong><?= number_format($total_recette, 2) ?> Ar</p>

    <tr>
        <th>ID Commande</th>
        <th>Client</th>
        <th>Date Recette</th>
        <th>Quantité</th>
        <th>Prix Unitaire</th>
        <th>Prix Total</th>
    </tr>
    <?php if (empty($recettes)): ?>
        <tr>
            <td colspan="6">Aucune recette trouvée pour les dates sélectionnées.</td>
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
</table>
<a href="/commande/add">Ajouter une nouvelle commande</a>