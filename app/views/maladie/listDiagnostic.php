<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Liste des Diagnostics</h4>
                <div class="mb-3">
                    <a href="<?= BASE_URL ?>/diagnostic/add" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Ajouter diagnostic
                    </a>
                    <a href="<?= BASE_URL ?>/maladie" class="btn btn-secondary">
                        <i class="fa fa-list"></i> Liste maladies
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nom maladie</th>
                                <th>Enclos Portée</th>
                                <th>Statut</th>
                                <th>Mâles infectés</th>
                                <th>Femelles infectées</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($diagnostics)): ?>
                                <?php foreach ($diagnostics as $diagnostic): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($diagnostic['id_maladie']) ?></td>
                                        <td><?= htmlspecialchars($diagnostic['id_enclos_portee']) ?></td>
                                        <td>
                                            <span class="badge badge-<?= 
                                                $diagnostic['statut'] === 'signale' ? 'warning' : 
                                                ($diagnostic['statut'] === 'en quarantaine' ? 'info' : 
                                                ($diagnostic['statut'] === 'en traitement' ? 'primary' : 
                                                ($diagnostic['statut'] === 'reussi' ? 'success' : 'danger'))) 
                                            ?>">
                                                <?= htmlspecialchars($diagnostic['statut']) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($diagnostic['nombre_males_infectes']) ?></td>
                                        <td><?= htmlspecialchars($diagnostic['nombre_femelles_infectes']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Aucun diagnostic trouvé</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>