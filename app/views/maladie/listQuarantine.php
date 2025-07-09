<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Diagnostics en Quarantaine</h4>
                </div>
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
                <?php endif; ?>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                <?php endif; ?>
                <div class="table-responsive">
                    <?php if (empty($diagnostics)): ?>
                        <p class="text-info">Aucun diagnostic en quarantaine pour le moment.</p>
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
                                    <th>Action</th>
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
                                            <form action="<?= BASE_URL ?>/diagnostic/startTreatment/<?= htmlspecialchars($diag['id_diagnostic']) ?>" method="post" style="display:inline;">
                                                <button type="submit" class="btn btn-primary btn-sm">Traiter</button>
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