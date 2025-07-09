
<?php use app\models\SalaireModel; ?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Gestion des Salaires</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Gestion des Salaires</h4>
                            <a href="<?=BASE_URL?>/salaire/historique_paie?annee=<?= $year ?>" class="btn btn-info btn-sm">
                                <i class="fa fa-history mr-1"></i> Historique Paiement
                            </a>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <form method="get" action="<?=BASE_URL?>/salaire" class="form-inline">
                                    <div class="form-group mr-3 mb-2">
                                        <label class="mr-2">Mois:</label>
                                        <select name="mois" class="form-control" onchange="this.form.submit()">
                                            <?php foreach ($months as $m): ?>
                                            <option value="<?= $m ?>" <?= $m == $month ? "selected" : "" ?>><?= $m ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="mr-2">Année:</label>
                                        <select name="annee" class="form-control" onchange="this.form.submit()">
                                            <?php foreach ($years as $y): ?>
                                            <option value="<?= $y ?>" <?= $y == $year ? "selected" : "" ?>><?= $y ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Rôle</th>
                                        <th>Statut Paiement</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($employes as $employe): 
                                        $date_pattern = "$year-$month%";
                                        $salaires = SalaireModel::getAll(["date_salaire LIKE" => $date_pattern, "id_employe" => $employe->id_employe]);
                                        $salaire = !empty($salaires) ? $salaires[0] : null;
                                        $statut = $salaire ? $salaire->statut : "non payé";
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($employe->nom_employe . ' ' . $employe->prenom_employe) ?></td>
                                        <td><?= htmlspecialchars($employe->nom_poste) ?></td>
                                        <td>
                                            <span class="badge <?= $statut === 'payé' ? 'badge-success' : 'badge-danger' ?>">
                                                <?= ucfirst(htmlspecialchars($statut)) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!$salaire || $salaire->statut === "non payé"): ?>
                                            <a href="<?=BASE_URL?>/salaire/payer/<?= $employe->id_employe ?>?mois=<?= $month ?>&annee=<?= $year ?>" 
                                               class="btn btn-primary btn-sm">
                                               <i class="fa fa-money mr-1"></i> Payer
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->