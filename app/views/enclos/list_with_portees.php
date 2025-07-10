<!-- views/enclos/list_with_portees.php -->
<div class="container-fluid mt-4">

    <!-- Boutons en haut (conservés de la version originale) -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Liste des Enclos et de leurs Portées</h1>
        <div>
            <a href="<?= BASE_URL ?>/enclos/move" class="btn btn-warning btn-icon-split btn-sm me-2">
                <span class="icon text-white-50"><i class="fas fa-random"></i></span>
                <span class="text">Déplacer une portée</span>
            </a>
            <a href="<?= BASE_URL ?>/enclos/convert-females" class="btn btn-success btn-icon-split btn-sm">
                <span class="icon text-white-50"><i class="fas fa-sync-alt"></i></span>
                <span class="text">Convertir truie</span>
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Vue d'ensemble des enclos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Enclos ID</th>
                            <th>Type d'enclos</th>
                            <th>Surface (m²)</th>
                            <th>ID Portée</th>
                            <th>Date Naissance</th>
                            <th>Âge (jours)</th>
                            <th>Composition (M / F)</th>
                            <th>Poids Est. (kg)</th>
                            <th>Statut Vente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($enclosData)): ?>
                            <tr>
                                <td colspan="9" class="text-center">Aucun enclos trouvé.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($enclosData as $enclos): ?>
                                <?php
                                    // Calculer le nombre de portées pour le rowspan
                                    $porteeCount = count($enclos['portees']);
                                    $rowspan = ($porteeCount > 0) ? $porteeCount : 1;
                                ?>
                                <tr>
                                    <td rowspan="<?= $rowspan ?>" style="vertical-align: middle; text-align: center; font-weight: bold;">
                                        <?= htmlspecialchars($enclos['id_enclos']) ?>
                                    </td>
                                    <td rowspan="<?= $rowspan ?>" style="vertical-align: middle;">
                                        <?= htmlspecialchars($enclos['nom_type']) ?>
                                    </td>
                                    <td rowspan="<?= $rowspan ?>" style="vertical-align: middle; text-align: center;">
                                        <?= htmlspecialchars($enclos['surface']) ?>
                                    </td>

                                    <?php if ($porteeCount > 0): ?>
                                        <?php // Afficher les détails de la première portée sur la même ligne ?>
                                        <?php $portee = $enclos['portees'][0]; ?>
                                        <td><?= htmlspecialchars($portee['id_portee']) ?></td>
                                        <td><?= htmlspecialchars($portee['date_naissance']) ?></td>
                                        <td><?= htmlspecialchars($portee['nombre_jour_ecoule']) ?></td>
                                        <td><?= htmlspecialchars($portee['nombre_males']) ?> M / <?= htmlspecialchars($portee['nombre_femelles']) ?> F</td>
                                        <td><?= htmlspecialchars(number_format($portee['poids_estimation'], 2)) ?></td>
                                        <td>
                                            <span class="badge badge-info"><?= htmlspecialchars($portee['statut_vente']) ?></span>
                                        </td>
                                    <?php else: ?>
                                        <?php // Si l'enclos est vide, afficher un message sur les colonnes restantes ?>
                                        <td colspan="6" class="text-center text-muted"><em>Enclos Vide</em></td>
                                    <?php endif; ?>
                                </tr>

                                <?php // Afficher les autres portées (à partir de la deuxième) sur de nouvelles lignes ?>
                                <?php if ($porteeCount > 1): ?>
                                    <?php for ($i = 1; $i < $porteeCount; $i++): ?>
                                        <?php $portee = $enclos['portees'][$i]; ?>
                                        <tr>
                                            <td><?= htmlspecialchars($portee['id_portee']) ?></td>
                                            <td><?= htmlspecialchars($portee['date_naissance']) ?></td>
                                            <td><?= htmlspecialchars($portee['nombre_jour_ecoule']) ?></td>
                                            <td><?= htmlspecialchars($portee['nombre_males']) ?> M / <?= htmlspecialchars($portee['nombre_femelles']) ?> F</td>
                                            <td><?= htmlspecialchars(number_format($portee['poids_estimation'], 2)) ?></td>
                                            <td>
                                                <span class="badge badge-info"><?= htmlspecialchars($portee['statut_vente']) ?></span>
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Le style et le script de la version canvas ne sont plus nécessaires et ont été retirés. -->
<!-- Vous pouvez ajouter des scripts pour la pagination ou la recherche de la table ici si besoin. -->