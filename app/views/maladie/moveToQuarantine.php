<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Sélectionner un Enclos de Quarantaine</h4>
                </div>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                <?php endif; ?>
                <div class="basic-form">
                    <form action="<?= BASE_URL ?>/diagnostic/moveToQuarantine/<?= htmlspecialchars($id_diagnostic) ?>" method="post">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Enclos de Quarantaine</label>
                            <div class="col-sm-10">
                                <select name="id_enclos_destination" id="id_enclos_destination" class="form-control" required>
                                    <?php foreach ($quarantineEnclos as $enclos): ?>
                                        <option value="<?= htmlspecialchars($enclos['id_enclos']) ?>">
                                            <?= htmlspecialchars($enclos['nom_type'] . ' - ' . $enclos['id_enclos']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Confirmer la Quarantaine</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>