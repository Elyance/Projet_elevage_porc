<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="card">
    <div class="card-header bg-warning text-white">
        <h2>Sélectionner un Enclos de Quarantaine</h2>
    </div>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>
    <div class="card-body">
        <form action="/diagnostic/moveToQuarantine/<?= htmlspecialchars($id_diagnostic) ?>" method="post">
            <div class="form-group">
                <label for="id_enclos_destination">Enclos de Quarantaine</label>
                <select name="id_enclos_destination" id="id_enclos_destination" class="form-control" required>
                    <?php foreach ($quarantineEnclos as $enclos): ?>
                        <option value="<?= htmlspecialchars($enclos['id_enclos']) ?>">
                            <?= htmlspecialchars($enclos['nom_type'] . ' - ' . $enclos['id_enclos']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Confirmer la Quarantaine</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>