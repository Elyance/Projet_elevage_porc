<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Liste des Maladies</h4>
                <div class="mb-3">
                    <a href="<?= BASE_URL ?>/maladie/add" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Ajouter maladie
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nom maladie</th>
                                <th>Symptômes</th>
                                <th>Description</th>
                                <th>Dangerosité</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($maladies)): ?>
                                <?php foreach ($maladies as $maladie): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($maladie['nom_maladie']) ?></td>
                                        <td>
                                            <?php if (!empty($symptomes)): ?>
                                                <?php foreach ($symptomes as $symptome): ?>
                                                    <?php if($symptome['id_maladie'] == $maladie['id_maladie']): ?>
                                                        <span class="badge badge-light"><?= htmlspecialchars($symptome['nom_symptome']) ?></span>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($maladie['description']) ?></td>
                                        <td>
                                            <span class="badge badge-<?= 
                                                $maladie['dangerosite'] === 'faible' ? 'success' : 
                                                ($maladie['dangerosite'] === 'moderee' ? 'warning' : 'danger')
                                            ?>">
                                                <?= htmlspecialchars($maladie['dangerosite']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= BASE_URL ?>/maladie/edit/<?= $maladie['id_maladie'] ?>" class="btn btn-info btn-sm">
                                                <i class="fa fa-edit"></i> Modifier
                                            </a>
                                            <a href="<?= BASE_URL ?>/maladie/delete/<?= $maladie['id_maladie'] ?>" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Supprimer
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Aucune maladie trouvée</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>