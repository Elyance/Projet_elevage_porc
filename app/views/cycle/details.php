<!-- app/views/cycle/details.php -->
<h1>Détails des Cycles</h1>


<h2>Cycle Actuel (ID: <?= htmlspecialchars($currentCycle->id_cycle_reproduction) ?>)</h2>
<p>Truie: <?= htmlspecialchars($currentCycle->truie_poids) ?> kg</p>
<p>Date Début: <?= htmlspecialchars($currentCycle->date_debut_cycle) ?></p>
<p>Date Fin: <?= htmlspecialchars($currentCycle->date_fin_cycle) ?></p>
<p>Nombre Portée: <?= htmlspecialchars($currentCycle->nombre_portee) ?></p>
<p>État: <?= htmlspecialchars($currentCycle->etat) ?></p>

<h2>Précédent Cycle</h2>
<?php if ($precedentCycle): ?>
    <table>
        <tr>
            <th>Date Début</th>
            <th>Date Fin</th>
            <th>Nombre Portée</th>
            <th>État</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($precedentCycle->date_debut_cycle) ?></td>
            <td><?= htmlspecialchars($precedentCycle->date_fin_cycle) ?></td>
            <td><?= htmlspecialchars($precedentCycle->nombre_portee) ?></td>
            <td><?= htmlspecialchars($precedentCycle->etat) ?></td>
        </tr>
    </table>
<?php else: ?>
    <p>Aucun cycle précédent pour cette truie.</p>
<?php endif; ?>

<h2>Prévision</h2>
<p>Durée Moyenne (jours): <?= number_format($prevision['days'], 2) ?></p>
<p>Nombre de Portées Moyen: <?= number_format($prevision['portee'], 2) ?></p>

<h2>Action</h2>
<a href="/naissance/add?cycle_id=<?= htmlspecialchars($currentCycle->id_cycle_reproduction) ?>&truie_id=<?= htmlspecialchars($currentCycle->id_truie) ?>">Naissance</a>