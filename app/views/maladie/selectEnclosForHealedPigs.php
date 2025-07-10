<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Sélectionner un Enclos pour les Porcs Guéris</h4>
                </div>
                <div class="basic-form">
                    <form method="post" action="<?= BASE_URL ?>/diagnostic/markSuccess/<?php echo $diagnostic['id_diagnostic']; ?>">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Enclos de Destination</label>
                            <div class="col-sm-10">
                                <select name="id_enclos_destination" id="id_enclos_destination" class="form-control">
                                    <?php foreach ($enclosList as $enclos): ?>
                                        <option value="<?php echo $enclos['id_enclos']; ?>">
                                            <?php echo htmlspecialchars($enclos['nom_type'] . ' - ID: ' . $enclos['id_enclos']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Confirmer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>