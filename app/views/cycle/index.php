```php
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h1 style="font-size: 1.5rem; margin-bottom: 1rem;">CYCLES EN COURS</h1>
    <table>
        <tr>
            <th>Truie</th>
            <th>Date Début Cycle</th>
            <th>Date Fin Cycle</th>
            <th>Nombre de Mâles</th>
            <th>Nombre de Femelles</th>
            <th>État</th>
            <th>Action</th>
        </tr>
        <?php foreach ($cycles as $cycle): ?>
        <tr>
            <td><?= htmlspecialchars($cycle->truie_poids) ?> kg</td>
            <td><?= htmlspecialchars($cycle->date_debut_cycle) ?></td>
            <td><?= htmlspecialchars($cycle->date_fin_cycle) ?></td>
            <td><?= htmlspecialchars($cycle->nombre_males ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($cycle->nombre_femelles ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($cycle->etat ?? 'N/A') ?></td>
            <td><a href="<?php echo Flight::get('flight.base_url')?>/cycle/details/<?= $cycle->id_cycle_reproduction ?>">Détails</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="<?php echo Flight::get('flight.base_url')?>/cycle/add">Ajouter Cycle</a>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>