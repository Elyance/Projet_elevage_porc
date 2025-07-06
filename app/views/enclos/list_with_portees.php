<!-- views/enclos/list_with_portees.php -->
<div class="container-fluid">
    <h1>Liste des Enclos avec Portées</h1>
    <div class="table-responsive">
        <?php foreach ($enclosData as $enclos): ?>
            <h2>Enclos ID: <?= $enclos['id_enclos'] ?> - Type: <?= $enclos['nom_type'] ?> - Surface: <?= $enclos['surface'] ?> m²</h2>
            <?php if (!empty($enclos['portees'])): ?>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Enclos Portée</th>
                            <th>ID Portée</th>
                            <th>Truie ID</th>
                            <th>Race ID</th>
                            <th>Date Naissance</th>
                            <th>Mâles</th>
                            <th>Femelles</th>
                            <th>Cycle Reprod. ID</th>
                            <th>Quantité Totale</th>
                            <th>Poids Est. (kg)</th>
                            <th>Statut Vente</th>
                            <th>Jours Écoulés</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($enclos['portees'] as $portee): ?>
                            <tr>
                                <td><?= $portee['id_enclos_portee'] ?? 'N/A' ?></td>
                                <td><?= $portee['id_portee'] ?? 'N/A' ?></td>
                                <td><?= $portee['id_truie'] ?? 'N/A' ?></td>
                                <td><?= $portee['id_race'] ?? 'N/A' ?></td>
                                <td><?= $portee['date_naissance'] ?? 'N/A' ?></td>
                                <td><?= $portee['nombre_males'] ?? 'N/A' ?></td>
                                <td><?= $portee['nombre_femelles'] ?? 'N/A' ?></td>
                                <td><?= $portee['id_cycle_reproduction'] ?? 'N/A' ?></td>
                                <td><?= $portee['quantite_total'] ?? 0 ?></td>
                                <td><?= $portee['poids_estimation'] ?? 0 ?></td>
                                <td><?= $portee['statut_vente'] ?? 'N/A' ?></td>
                                <td><?= $portee['nombre_jour_ecoule'] ?? 'N/A' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune portée dans cet enclos.</p>
            <?php endif; ?>
        <?php endforeach; ?>
        <a href="/enclos/move">Déplacer une portée</a>
        <a href="/enclos/convert-females">Convertir truie</a>
    </div>
</div>