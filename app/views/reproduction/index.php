<?php ?>
<style>
    .enlarged-content {
        font-size: 1.4rem; /* Augmentation de la taille de base */
    }
    .enlarged-table th, 
    .enlarged-table td {
        padding: 1.2rem 0.8rem; /* Plus d'espace dans les cellules */
    }
    .enlarged-badge {
        font-size: 1.2rem;
        padding: 0.5rem 1rem;
    }
    .enlarged-btn {
        font-size: 1.2rem;
        padding: 0.5rem 1.5rem;
    }
    .enlarged-card-title {
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }
</style>

<div class="d-flex justify-content-center enlarged-content">
    <div class="col-lg-10"> <!-- Largeur augmentée -->
        <div class="card">
            <div class="card-body p-5"> <!-- Padding augmenté -->
                <div class="card-title text-center mb-4">
                    <h2 class="enlarged-card-title">Historique des Inséminations</h2>
                </div>
                <div class="mb-4 text-center"> <!-- Marge augmentée -->
                    <a href="<?= BASE_URL ?>/reproduction/inseminate" class="btn btn-primary mr-3 enlarged-btn">Ajouter Insémination</a>
                    <a href="<?= BASE_URL ?>/cycle" class="btn btn-secondary enlarged-btn">Voir cycles</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover enlarged-table">
                        <thead class="text-center">
                            <tr>
                                <th style="font-size: 1.5rem;">Truie</th>
                                <th style="font-size: 1.5rem;">Date Insémination</th>
                                <th style="font-size: 1.5rem;">Résultat</th>
                                <th style="font-size: 1.5rem;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inseminations as $insem): ?>
                            <tr class="text-center">
                                <td style="font-size: 1.4rem;"><?= htmlspecialchars($insem->truie_poids) ?> kg</td>
                                <td style="font-size: 1.4rem;"><?= htmlspecialchars($insem->date_insemination) ?></td>
                                <td>
                                    <?php if ($insem->resultat === 'en cours'): ?>
                                        <span class="badge badge-warning enlarged-badge">En cours</span>
                                    <?php elseif ($insem->resultat === 'Succès'): ?>
                                        <span class="badge badge-success enlarged-badge">Succès</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger enlarged-badge">Échec</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($insem->resultat === 'en cours'): ?>
                                        <a href="<?= BASE_URL ?>/reproduction?action=success&id=<?= $insem->id_insemination ?>" class="btn btn-success btn-sm mr-2 enlarged-btn">Succès</a>
                                        <a href="<?= BASE_URL ?>/reproduction?action=failure&id=<?= $insem->id_insemination ?>" class="btn btn-danger btn-sm enlarged-btn">Échec</a>
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
</div>