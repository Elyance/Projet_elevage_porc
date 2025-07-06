<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h2>Diagnostics en Traitement</h2>
    </div>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>
    <div class="card-body">
        <?php if (empty($diagnostics)): ?>
            <p class="text-info">Aucun diagnostic en traitement pour le moment.</p>
        <?php else: ?>
            <table class="table table-striped">
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
                                <form action="/diagnostic/markSuccess/<?= htmlspecialchars($diag['id_diagnostic']) ?>" method="get" style="display:inline;">
                                    <button type="submit" class="btn btn-success btn-sm">Succès</button>
                                </form>
                                <form action="/diagnostic/markFailure/<?= htmlspecialchars($diag['id_diagnostic']) ?>" method="post" style="display:inline;">
                                    <button type="submit" class="btn btn-warning btn-sm">Échec</button>
                                </form>
                                <form method="post" action="/diagnostic/recordDeath/<?php echo $diag['id_diagnostic']; ?>">
                                    <label for="male_deces">Nombre de mâles décédés:</label>
                                    <input type="number" name="male_deces" id="male_deces" min="0" required>
                                    <label for="female_deces">Nombre de femelles décédées:</label>
                                    <input type="number" name="female_deces" id="female_deces" min="0" required>
                                    <input type="submit" value="Enregistrer les décès">
                                </form>                            
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>