<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Diagnostics en Traitement</h4>
                </div>
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
                <?php endif; ?>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                <?php endif; ?>
                <div class="table-responsive">
                    <?php if (empty($diagnostics)): ?>
                        <p class="text-info">Aucun diagnostic en traitement pour le moment.</p>
                    <?php else: ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Maladie</th>
                                    <th>Enclos Portée</th>
                                    <th>Mâles Infectés</th>
                                    <th>Femelles Infectées</th>
                                    <th>Date Apparition</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($diagnostics as $diag): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($diag['id_diagnostic']) ?></td>
                                        <td><?= htmlspecialchars($diag['id_maladie']) ?></td>
                                        <td><?= htmlspecialchars($diag['id_enclos_portee']) ?></td>
                                        <td><?= htmlspecialchars($diag['nombre_males_infectes']) ?></td>
                                        <td><?= htmlspecialchars($diag['nombre_femelles_infectes']) ?></td>
                                        <td><?= htmlspecialchars($diag['date_apparition']) ?></td>
                                        <td>
                                            <form action="<?= BASE_URL ?>/diagnostic/markSuccess/<?= htmlspecialchars($diag['id_diagnostic']) ?>" method="get" style="display:inline;">
                                                <button type="submit" class="btn btn-success btn-sm">Succès</button>
                                            </form>
                                            <form action="<?= BASE_URL ?>/diagnostic/markFailure/<?= htmlspecialchars($diag['id_diagnostic']) ?>" method="post" style="display:inline;">
                                                <button type="submit" class="btn btn-warning btn-sm">Échec</button>
                                            </form>
                                            <form method="post" action="<?= BASE_URL ?>/diagnostic/recordDeath/<?php echo $diag['id_diagnostic']; ?>" class="mt-2">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Mâles décédés:</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" name="male_deces" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Femelles décédées:</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" name="female_deces" min="0" required>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-dark btn-sm">Enregistrer les décès</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>