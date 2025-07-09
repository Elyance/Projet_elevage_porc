<h2>Dépenses</h2>
<form method="get" action="/depense/list">
    <div>
        <label for="date_debut">Date de début</label>
        <input type="date" name="date_debut" id="date_debut" value="<?= htmlspecialchars($date_debut) ?>">
    </div>
    <div>
        <label for="date_fin">Date de fin</label>
        <input type="date" name="date_fin" id="date_fin" value="<?= htmlspecialchars($date_fin) ?>">
    </div>
    <button type="submit">Filtrer</button>
    <a href="/depense/list">Réinitialiser</a>
</form>
<table border="1">
<a href="/budget/index">Voir le budget</a>

<p><strong>Dépense totale : </strong><?= number_format($total_depense, 2) ?> Ar</p>

    <tr>
        <th>Type de dépense</th>
        <th>Date</th>
        <th>Montant</th>
    </tr>
    <?php if (empty($depenses)): ?>
        <tr>
            <td colspan="3">Aucune dépense trouvée pour les dates sélectionnées.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($depenses as $depense): ?>
            <tr>
                <td><?= htmlspecialchars($depense->type_depense) ?></td>
                <td><?= htmlspecialchars($depense->date_depense) ?></td>
                <td><?= number_format($depense->montant, 2) ?> Ar</td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>