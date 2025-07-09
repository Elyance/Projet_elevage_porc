<?php ?>
<div class="card">
    <h1>Historique des Inséminations</h1>
    <a href="<?= BASE_URL ?>/reproduction/inseminate">Ajouter Insémination</a>
    <a href="<?= BASE_URL ?>/cycle">Voir cycles</a>
    <table>
        <tr>
            <th>Truie</th>
            <th>Date Insémination</th>
            <th>Résultat</th>
            <th>Action</th>
        </tr>
        <?php foreach ($inseminations as $insem): ?>
        <tr>
            <td><?= htmlspecialchars($insem->truie_poids) ?> kg</td>
            <td><?= htmlspecialchars($insem->date_insemination) ?></td>
            <td><?= htmlspecialchars($insem->resultat) ?></td>
            <td>
                <?php if ($insem->resultat === 'en cours'): ?>
                    <a href="<?= BASE_URL ?>/reproduction?action=success&id=<?= $insem->id_insemination ?>">Succès</a>
                    <a href="<?= BASE_URL ?>/reproduction?action=failure&id=<?= $insem->id_insemination ?>">Échec</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>