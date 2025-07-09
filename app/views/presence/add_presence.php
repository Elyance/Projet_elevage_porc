<?php use app\models\PresenceModel; ?>
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Gestion de Présence</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Ajouter Présence - <?= htmlspecialchars($date) ?></a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ajouter Présence - <?= htmlspecialchars($date) ?></h4>
                        
                        <form method="post" action="<?=BASE_URL?>/presence/add_presence?date=<?= $date ?>">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th>Nom</th>
                                            <th class="text-center">Présence</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($employes as $employe): 
                                            $isPresent = PresenceModel::getPresenceStatus($employe->id_employe, $date) === "present";
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($employe->nom_employe . ' ' . $employe->prenom_employe) ?></td>
                                            <td class="text-center">
                                                <label class="css-control css-control-primary css-checkbox">
                                                    <input type="checkbox" 
                                                           class="css-control-input" 
                                                           name="presence_<?= $employe->id_employe ?>" 
                                                           <?= $isPresent ? "checked" : "" ?>>
                                                    <span class="css-control-indicator"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save mr-1"></i> Sauvegarder
                                </button>
                                <a href="<?=BASE_URL?>/presence/detail_jour/<?= $date ?>" class="btn btn-light">
                                    <i class="fa fa-arrow-left mr-1"></i> Retour
                                </a>
                            </div>
                        </form>
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