```php
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h1 style="font-size: 1.5rem; margin-bottom: 1rem;">VOIR CYCLES</h1>
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
                    <a href="<?php echo Flight::get('flight.base_url')?>/reproduction?action=success&id=<?= $insem->id_insemination ?>">Succès</a>
                    <a href="<?php echo Flight::get('flight.base_url')?>/reproduction?action=failure&id=<?= $insem->id_insemination ?>">Échec</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="<?php echo Flight::get('flight.base_url')?>/reproduction/inseminate">Ajouter Insémination</a>
    <a href="<?php echo Flight::get('flight.base_url')?>/cycle">Voir cycles</a>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>