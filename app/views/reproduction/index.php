<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h4>Historique des Inséminations</h4>
            </div>
            <div class="mb-4 text-center">
                <a href="<?= BASE_URL ?>/reproduction/inseminate" class="btn btn-primary mr-3">Ajouter Insémination</a>
                <a href="<?= BASE_URL ?>/cycle" class="btn btn-secondary">Voir cycles</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Truie</th>
                            <th>Date Insémination</th>
                            <th>Résultat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inseminations as $insem): ?>
                        <tr>
                            <td><?= htmlspecialchars($insem->truie_poids) ?> kg</td>
                            <td><?= htmlspecialchars($insem->date_insemination) ?></td>
                            <td>
                                <?php if ($insem->resultat === 'en cours'): ?>
                                    <span class="badge badge-warning">En cours</span>
                                <?php elseif ($insem->resultat === 'Succès'): ?>
                                    <span class="badge badge-success">Succès</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Échec</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($insem->resultat === 'en cours'): ?>
                                    <a href="<?= BASE_URL ?>/reproduction?action=success&id=<?= $insem->id_insemination ?>" class="btn btn-success btn-sm mr-2">Succès</a>
                                    <a href="<?= BASE_URL ?>/reproduction?action=failure&id=<?= $insem->id_insemination ?>" class="btn btn-danger btn-sm">Échec</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>