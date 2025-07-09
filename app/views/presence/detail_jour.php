<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Gestion de Présence</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Détail du Jour - <?= htmlspecialchars($date) ?></a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Détail du Jour - <?= htmlspecialchars($date) ?></h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title text-white">Employés Présents</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <?php foreach ($present_employes as $emp): ?>
                                                <li class="list-group-item">
                                                    <?= htmlspecialchars($emp->nom_employe . ' ' . $emp->prenom_employe) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="card-title text-white">Employés en Congé Payé</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <?php foreach ($conge_payes as $emp): ?>
                                                <li class="list-group-item">
                                                    <?= htmlspecialchars($emp->nom_employe . ' ' . $emp->prenom_employe) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="<?=BASE_URL?>/presence/add_presence?date=<?= $date ?>" class="btn btn-primary mr-2">
                                <i class="fa fa-plus mr-1"></i> Ajouter Présence
                            </a>
                            <a href="<?=BASE_URL?>/presence" class="btn btn-light">
                                <i class="fa fa-arrow-left mr-1"></i> Retour
                            </a>
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