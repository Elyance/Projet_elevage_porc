<div class="col-lg-12" style="margin-top: 30px;">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="card-title">
                    <h4>Historique des Pesées</h4>
                </div>
                <a href="<?= BASE_URL ?>/tache_peser" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Nouvelle Pesée
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Enclos</th>
                            <th>Poids (kg)</th>
                            <th>Date Pesée</th>
                            <th>Date Enregistrement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pesees as $pesee): ?>
                        <tr>
                            <td><?= htmlspecialchars($pesee->id_pesee) ?></td>
                            <td>Enclos <?= htmlspecialchars($pesee->id_enclos) ?></td>
                            <td><?= number_format($pesee->poids, 2) ?> kg</td>
                            <td><?= htmlspecialchars($pesee->date_pesee) ?></td>
                            <td>    
                                <?php 
                                if (!empty($pesee->created_at)) {
                                    $date = new DateTime($pesee->created_at);
                                    echo htmlspecialchars($date->format('d/m/Y H:i'));
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if (empty($pesees)): ?>
                <div class="alert alert-info">Aucune pesée enregistrée pour le moment.</div>
            <?php endif; ?>
        </div>
    </div>
</div>