<!-- app/views/reproduction/index.php -->
<h1>VOIR CYCLES</h1>
<table>
    <tr>
        <th>Truie</th>
        <th>Date Insémination</th>
        <th>Résultat</th>
        <th>Action</th>
    </tr>
    <?php foreach ($inseminations as $insem): ?>
    <tr>
        <td><?= htmlspecialchars($insem['truie_poids']) ?> kg</td>
        <td><?= htmlspecialchars($insem['date_insemination']) ?></td>
        <td><?= htmlspecialchars($insem['resultat']) ?></td>
        <td>
            <?php if ($insem['resultat'] === 'en cours'): ?>
                <a href="/reproduction?action=success&id=<?= $insem['id_insemination'] ?>">Succès</a>
                <a href="/reproduction?action=echec&id=<?= $insem['id_insemination'] ?>">Échec</a>
            <?php else: ?>
                N/A
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="/reproduction/inseminate">INSÉMINER</a>
<a href="/cycle">VOIR CYCLES</a>