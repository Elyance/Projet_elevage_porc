<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Gestion des Salaires</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Paiement du Salaire</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Paiement du Salaire</h4>
                        <div class="basic-form">
                            <form method="post" action="<?=BASE_URL?>/salaire/payer/<?= $employe->id_employe ?>?mois=<?= $month ?>&annee=<?= $year ?>">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nom:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control-plaintext" readonly 
                                               value="<?= htmlspecialchars($employe->nom_employe . ' ' . $employe->prenom_employe) ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Rôle:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control-plaintext" readonly 
                                               value="<?= htmlspecialchars($employe->nom_poste) ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Salaire Brut:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control-plaintext" readonly 
                                               value="<?= number_format($salaire_brut, 2) ?> FCFA">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jours Présents:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control-plaintext" readonly 
                                               value="<?= $nb_jours_present ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Taux:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control-plaintext" readonly 
                                               value="<?= number_format($taux, 2) ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Salaire Final:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control-plaintext font-weight-bold" readonly 
                                               value="<?= number_format($salaire_final, 2) ?> FCFA">
                                    </div>
                                </div>
                                
                                <input type="hidden" name="salaire_final" value="<?= $salaire_final ?>">
                                
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-check mr-1"></i> Confirmer Paiement
                                        </button>
                                        <a href="<?=BASE_URL?>/salaire?mois=<?= $month ?>&annee=<?= $year ?>" class="btn btn-light">
                                            <i class="fa fa-arrow-left mr-1"></i> Retour
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
<!--**********************************
    Content body end
***********************************-->