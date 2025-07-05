<!-- app/views/cycle/index.php -->
<h1>CYCLES EN COURS</h1>
<table>
    <tr>
        <th>Truie</th>
        <th>Date Début Cycle</th>
        <th>Date Fin Cycle</th>
        <th>Nombre Portée</th>
        <th>Action</th>
    </tr>
    <?php foreach ($cycles as $cycle): ?>
    <tr>
        <td><?= htmlspecialchars($cycle->truie_poids) ?> kg</td>
        <td><?= htmlspecialchars($cycle->date_debut_cycle) ?></td>
        <td><?= htmlspecialchars($cycle->date_fin_cycle) ?></td>
        <td><?= htmlspecialchars($cycle->nombre_portee) ?></td>
        <td><a href="<?php echo Flight::get('flight.base_url')?>/cycle/details/<?= $cycle->id_cycle_reproduction ?>">Détails</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="<?php echo Flight::get('flight.base_url')?>/cycle/add">Ajouter Cycle</a>
<a href="<?php echo Flight::get('flight.base_url')?>/naissance/add">Ajouter Naissance</a>