<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Gestion des Tâches</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Liste des Tâches</h4>
                            <div>
                                <a href="<?=BASE_URL?>/tache/create" class="btn btn-primary btn-sm mr-2">
                                    <i class="fa fa-plus mr-1"></i> Créer une tâche
                                </a>
                                <a href="<?= BASE_URL?>/tache/assign" class="btn btn-info btn-sm">
                                    <i class="fa fa-tasks mr-1"></i> Assigner une tâche
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Nom de la tâche</th>
                                        <th>Rôle concerné</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($taches as $tache): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($tache['nom_tache']) ?></td>
                                        <td><?= htmlspecialchars($tache['nom_poste']) ?></td>
                                        <td>
                                            <a href="<?=BASE_URL?>/tache/edit/<?= $tache['id_tache'] ?>" class="btn btn-warning btn-sm mr-1">
                                                <i class="fa fa-edit mr-1"></i> Modifier
                                            </a>
                                            <a href="<?=BASE_URL?>/tache/delete/<?= $tache['id_tache'] ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                                                <i class="fa fa-trash mr-1"></i> Supprimer
                                            </a>
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
    <!-- #/ container -->
</div>
<!--**********************************
    Content body end
***********************************-->
