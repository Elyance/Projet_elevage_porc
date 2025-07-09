<?php require_once __DIR__ . '/../sante/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Création d'un Avis de Décès</h4>
                </div>
                <div class="basic-form">
                    <form method="post">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Enclos</label>
                            <div class="col-sm-10">
                                <select name="id_enclos" id="id_enclos" class="form-control" required>
                                    <?php if(!empty($enclos)): ?>
                                        <?php foreach($enclos as $enclo): ?>
                                            <option value="<?= htmlspecialchars($enclo['id_enclos']) ?>">
                                                Enclos <?= htmlspecialchars($enclo['id_enclos']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nombre de décès</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="nombre_deces" id="nombre_deces" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="date_deces" id="date_deces" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Cause</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="cause_deces" id="cause_deces" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>