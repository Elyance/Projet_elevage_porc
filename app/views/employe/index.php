<!-- app/views/employe/index.php -->

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Gestion Employés</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Gestion des Employés</h4>
                        <div class="mb-4">
                            <a href="<?= BASE_URL?>/salaire" class="btn btn-primary btn-sm">Gestion Salaire</a>
                            <a href="<?= BASE_URL?>/presence" class="btn btn-primary btn-sm">Gestion Présence</a>
                            <a href="<?= BASE_URL?>/tache" class="btn btn-primary btn-sm">Gestion Tâches</a>
                            <a href="<?= BASE_URL?>/add_employe" class="btn btn-success btn-sm">Ajouter Employé</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered verticle-middle">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Rôle</th>
                                        <th>Date Recrutement</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($employes as $employe): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($employe->nom_employe . ' ' . $employe->prenom_employe) ?></td>
                                        <td><?= htmlspecialchars($employe->nom_poste) ?></td>
                                        <td><?= htmlspecialchars($employe->date_recrutement) ?></td>
                                        <td>
                                            <a href="/conge/add?id_employe=<?= $employe->id_employe ?>" class="btn btn-info btn-sm">Demande de Congé</a>
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