<?php require_once __DIR__ . '/../sante/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Liste des Types d'Événements</h4>
                </div>
                <div class="mb-3">
                    <a href="<?= BASE_URL ?>/typeevenement/add" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Ajouter un type d'événement
                    </a>
                </div>
                <div class="table-responsive">
                    <?php if (!empty($typeevenements)): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prix</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($typeevenements as $typeevenement): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($typeevenement['nom_type_evenement']) ?></td>
                                        <td><?= htmlspecialchars($typeevenement['prix']) ?> €</td>
                                        <td>
                                            <a href="<?= BASE_URL ?>/typeevenement/edit/<?= $typeevenement['id_type_evenement'] ?>" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i> Modifier
                                            </a>
                                            <a href="<?= BASE_URL ?>/typeevenement/delete/<?= $typeevenement['id_type_evenement'] ?>" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Supprimer
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-info">Aucun type d'événement enregistré pour le moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>