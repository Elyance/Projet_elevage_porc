<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Menu Santé</h4>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="<?= BASE_URL ?>/sante/listDiagnostic">Liste des Diagnostics</a>
                    </li>
                    <li class="list-group-item">
                        <a href="<?= BASE_URL ?>/sante/listSignale">Liste des Cas Signalés</a>
                    </li>
                    <li class="list-group-item">
                        <a href="<?= BASE_URL ?>/sante/listQuarantine">Liste des Cas en Quarantaine</a>
                    </li>
                    <li class="list-group-item">
                        <a href="<?= BASE_URL ?>/sante/listTreatment">Liste des Cas en Traitement</a>
                    </li>
                    <li class="list-group-item">
                        <a href="<?= BASE_URL ?>/sante">Retour</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>