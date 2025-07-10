<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="card-title">
                    <h4>CYCLES EN COURS</h4>
                </div>
                <a href="<?= BASE_URL ?>/cycle/add" class="btn btn-primary">Ajouter Cycle</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Truie</th>
                            <th>Date Début</th>
                            <th>Date Fin</th>
                            <th>Mâles</th>
                            <th>Femelles</th>
                            <th>État</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cycles as $cycle): ?>
                        <tr>
                            <td><?= htmlspecialchars($cycle->truie_poids) ?> kg</td>
                            <td><?= htmlspecialchars($cycle->date_debut_cycle ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($cycle->date_fin_cycle ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($cycle->nombre_males ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($cycle->nombre_femelles ?? 'N/A') ?></td>
                            <td>
                                <span class="badge badge-<?= 
                                    $cycle->etat === 'actif' ? 'primary' : 
                                    ($cycle->etat === 'termine' ? 'success' : 
                                    ($cycle->etat === 'en cours' ? 'warning' : 'secondary')) ?>">
                                    <?= htmlspecialchars($cycle->etat ?? 'N/A') ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= BASE_URL ?>/cycle/details/<?= $cycle->id_cycle_reproduction ?>" class="btn btn-info btn-sm">Détails</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>