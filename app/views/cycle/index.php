<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title" style="font-size: 2rem;">CYCLES EN COURS</h4>
                            <a href="<?= BASE_URL ?>/cycle/add" class="btn btn-primary btn-lg" style="font-size: 1.4rem; padding: 0.75rem 2rem;">Ajouter Cycle</a>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover" style="font-size: 1.4rem;">
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
                                                ($cycle->etat === 'en cours' ? 'warning' : 'secondary')) ?>" 
                                                style="font-size: 1.3rem;">
                                                <?= htmlspecialchars($cycle->etat ?? 'N/A') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= BASE_URL ?>/cycle/details/<?= $cycle->id_cycle_reproduction ?>" class="btn btn-info btn-sm" style="font-size: 1.3rem;">Détails</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card {
    border-radius: 0.5rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-title {
    color: #4e73df;
    font-weight: 600;
}

.table th {
    font-size: 1.4rem;
    font-weight: 600;
    color: #4e73df;
}

/* Badges colorés pour les différents états */
.badge-success {
    background-color: #1cc88a; /* Vert pour "actif" */
    color: white;
}

.badge-primary {
    background-color: #4e73df; /* Bleu pour "terminé" */
    color: white;
}

.badge-warning {
    background-color: #f6c23e; /* Jaune pour "en attente" */
    color: #2e2e2e;
}

.badge-danger {
    background-color: #e74a3b; /* Rouge pour "annulé" */
    color: white;
}

.badge-secondary {
    background-color: #858796; /* Gris pour autres états */
    color: white;
}

/* Animation pour les états actifs */
.badge-success {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(28, 200, 138, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(28, 200, 138, 0); }
    100% { box-shadow: 0 0 0 0 rgba(28, 200, 138, 0); }
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.4rem;
    border-radius: 0.35rem;
}

.form-control-lg {
    font-size: 1.4rem;
    padding: 1rem 1.5rem;
    height: calc(2.5em + 1rem + 2px);
}

.section-title {
    border-bottom: 2px solid #f8f9fc;
    padding-bottom: 0.5rem;
}

.chart-container {
    position: relative;
    height: 300px;
}
</style>