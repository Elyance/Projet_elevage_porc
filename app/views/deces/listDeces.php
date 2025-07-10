<?php require_once __DIR__ . '/../sante/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Liste des Décès</h4>
                </div>
                <div class="mb-3">
                    <a href="<?= BASE_URL ?>/deces/add" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Ajouter un décès
                    </a>
                </div>
                <div class="table-responsive">
                    <?php if (!empty($deces)): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Enclos</th>
                                    <th>Nombre de décès</th>
                                    <th>Date de décès</th>
                                    <th>Cause</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($deces as $dece): ?>
                                    <tr>
                                        <td><?= ($dece['id_enclos']) ?></td>
                                        <td><?= ($dece['nombre_deces']) ?></td>
                                        <td><?= ($dece['date_deces']) ?></td>
                                        <td><?= ($dece['cause_deces']) ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>/deces/edit/<?= $dece['id_deces'] ?>" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i> Modifier
                                            </a>
                                            <a href="<?= BASE_URL ?>/deces/delete/<?= $dece['id_deces'] ?>" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Supprimer
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-info">Aucun décès enregistré pour le moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>