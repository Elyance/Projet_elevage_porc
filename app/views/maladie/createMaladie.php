<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Création d'une maladie</h4>
                <div class="basic-form">
                    <form method="post">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nom de la maladie</label>
                            <div class="col-sm-10">
                                <input type="text" name="nom_maladie" id="nom_maladie" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" name="description" id="description" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Dangerosité</label>
                            <div class="col-sm-10">
                                <select name="dangerosite" id="dangerosite" class="form-control">
                                    <option value="faible">Faible</option>
                                    <option value="moderee">Modérée</option>
                                    <option value="elevee">Élevée</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Symptômes</label>
                            <div class="col-sm-10">
                                <?php foreach ($symptomes as $symptome): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="id_symptomes[]" 
                                            value="<?= $symptome['id_symptome'] ?>" id="symptome_<?= $symptome['id_symptome'] ?>">
                                        <label class="form-check-label" for="symptome_<?= $symptome['id_symptome'] ?>">
                                            <?= htmlspecialchars($symptome['nom_symptome']) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Créer la maladie
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>