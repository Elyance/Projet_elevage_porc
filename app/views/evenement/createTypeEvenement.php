<?php require_once __DIR__ . '/../sante/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Création d'un Type d'Événement</h4>
                </div>
                <div class="basic-form">
                    <form method="post">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nom de l'événement</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nom_type_evenement" id="nom_type_evenement" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Prix</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="prix" id="prix" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Créer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>