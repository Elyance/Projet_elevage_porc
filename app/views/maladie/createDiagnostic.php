<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Création d'un diagnostic</h4>
                <div class="basic-form">
                    <form method="post">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Maladie</label>
                            <div class="col-sm-10">
                                <select name="id_maladie" id="id_maladie" class="form-control" required>
                                    <?php if(!empty($maladies)): ?>
                                        <?php foreach($maladies as $maladie): ?>
                                            <option value="<?= htmlspecialchars($maladie['id_maladie']) ?>">
                                                <?= htmlspecialchars($maladie['nom_maladie']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Enclos Portée</label>
                            <div class="col-sm-10">
                                <select name="id_enclos_portee" id="id_enclos_portee" class="form-control" required>
                                    <?php if(!empty($enclos_portee)): ?>
                                        <?php foreach($enclos_portee as $enclo): ?>
                                            <option value="<?= htmlspecialchars($enclo['id_enclos_portee']) ?>">
                                                <?= htmlspecialchars($enclo['id_enclos_portee']) ?> (Enclos: <?= $enclo['id_enclos'] ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <!-- More form groups following the same pattern -->
                        <!-- ... (other form fields) ... -->

                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Créer l'évènement
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>