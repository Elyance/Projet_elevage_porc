<h2>Budget</h2>
<form method="get" action="/budget/index">
    <div>
        <label for="annee">Année</label>
        <input type="number" name="annee" id="annee" value="<?= htmlspecialchars($annee) ?>" min="2000" max="<?= date('Y') ?>">
    </div>
    <button type="submit">Filtrer</button>
    <a href="/budget/index">Réinitialiser</a>
</form>

<h3>Budget Mensuel</h3>
<table border="1">
    <tr>
        <th>Année</th>
        <th>Mois</th>
        <th>Recette Totale (Ar)</th>
        <th>Dépense Totale (Ar)</th>
        <th>Budget (Ar)</th>
    </tr>
    <?php if (empty($budgetParMois)): ?>
        <tr>
            <td colspan="5">Aucun budget trouvé pour l'année sélectionnée.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($budgetParMois as $budget): ?>
            <tr>
                <td><?= htmlspecialchars($budget['annee']) ?></td>
                <td><?= htmlspecialchars(sprintf("%02d", $budget['mois'])) ?></td>
                <td><?= number_format($budget['total_recette'], 2) ?></td>
                <td><?= number_format($budget['total_depense'], 2) ?></td>
                <td><?= number_format($budget['budget'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<h3>Budget Annuel</h3>
<table border="1">
    <tr>
        <th>Année</th>
        <th>Recette Totale (Ar)</th>
        <th>Dépense Totale (Ar)</th>
        <th>Budget (Ar)</th>
    </tr>
    <?php if (empty($budgetParAn)): ?>
        <tr>
            <td colspan="4">Aucun budget trouvé pour l'année sélectionnée.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($budgetParAn as $budget): ?>
            <tr>
                <td><?= htmlspecialchars($budget['annee']) ?></td>
                <td><?= number_format($budget['total_recette'], 2) ?></td>
                <td><?= number_format($budget['total_depense'], 2) ?></td>
                <td><?= number_format($budget['budget'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>