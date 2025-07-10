<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Modifier un décès</h4>
                <div class="basic-form">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Id enclos</label>
                            <div class="col-sm-10">
                                <select name="id_enclos" id="id_enclos" class="form-control" required>
                                    <?php foreach ($enclos as $enclo): ?>
                                        <option value="<?= $enclo['id_enclos'] ?>" 
                                            <?= $enclo['id_enclos'] == $deces['id_enclos'] ? 'selected' : '' ?>>
                                            <?= $enclo['id_enclos'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nombre de décès</label>
                            <div class="col-sm-10">
                                <input type="number" name="nombre_deces" id="nombre_deces" class="form-control" 
                                    value="<?= htmlspecialchars($deces['nombre_deces']) ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Date</label>
                            <div class="col-sm-10">
                                <input type="date" name="date_deces" class="form-control" 
                                    value="<?= htmlspecialchars($deces['date_deces']) ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Cause du décès</label>
                            <div class="col-sm-10">
                                <input type="text" name="cause_deces" class="form-control" 
                                    value="<?= htmlspecialchars($deces['cause_deces']) ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Mettre à jour
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>