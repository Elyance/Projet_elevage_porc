<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Modifier la maladie</h4>
                <div class="basic-form">
                    <form method="post">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nom de la maladie</label>
                            <div class="col-sm-10">
                                <input type="text" name="nom_maladie" id="nom_maladie" class="form-control" 
                                    value="<?= htmlspecialchars($maladie['nom_maladie']) ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" name="description" id="description" class="form-control" 
                                    value="<?= htmlspecialchars($maladie['description']) ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Dangerosité</label>
                            <div class="col-sm-10">
                                <select name="dangerosite" id="dangerosite" class="form-control">
                                    <option value="faible" <?= $maladie['dangerosite'] === 'faible' ? 'selected' : '' ?>>Faible</option>
                                    <option value="moderee" <?= $maladie['dangerosite'] === 'moderee' ? 'selected' : '' ?>>Modérée</option>
                                    <option value="elevee" <?= $maladie['dangerosite'] === 'elevee' ? 'selected' : '' ?>>Élevée</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Symptômes</label>
                            <div class="col-sm-10">
                                <?php 
                                $idsSymptomesAssocies = array_column($symptomes_maladie, 'id_symptome');
                                foreach ($symptomes as $symptome): 
                                    $checked = in_array($symptome['id_symptome'], $idsSymptomesAssocies) ? 'checked' : '';
                                ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="id_symptomes[]" 
                                            value="<?= $symptome['id_symptome'] ?>" id="symptome_<?= $symptome['id_symptome'] ?>"
                                            <?= $checked ?>>
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
                                    <i class="fa fa-save"></i> Modifier la maladie
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>