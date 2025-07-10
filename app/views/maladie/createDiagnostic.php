<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Création d'un Diagnostic</h4>
                </div>
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
                                                <?= htmlspecialchars($enclo['id_enclos_portee']) ?> (Enclos: <?= htmlspecialchars($enclo['id_enclos']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Enclos Portée Original</label>
                            <div class="col-sm-10">
                                <select name="id_enclos_portee_original" id="id_enclos_portee_original" class="form-control" required>
                                    <?php if(!empty($enclos_portee)): ?>
                                        <?php foreach($enclos_portee as $enclo): ?>
                                            <option value="<?= htmlspecialchars($enclo['id_enclos_portee']) ?>">
                                                <?= htmlspecialchars($enclo['id_enclos_portee']) ?> (Enclos: <?= htmlspecialchars($enclo['id_enclos']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Mâles infectés</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="nombre_males_infectes" id="nombre_males_infectes" min="0" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Femelles infectées</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="nombre_femelles_infectes" id="nombre_femelles_infectes" min="0" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Date d'apparition</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="date_apparition" id="date_apparition" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Date de diagnostic</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="date_diagnostic" id="date_diagnostic" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="desc_traitement" id="desc_traitement">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Statut</label>
                            <div class="col-sm-10">
                                <select name="statut" id="statut" class="form-control" required>
                                    <option value="signale">Signalé</option>
                                    <option value="en quarantaine">En quarantaine</option>
                                    <option value="en traitement">En traitement</option>
                                    <option value="reussi">Réussi</option>
                                    <option value="echec">Échec</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Prix</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="prix_traitement" id="prix_traitement" step="0.01" min="0">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Créer le diagnostic</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>