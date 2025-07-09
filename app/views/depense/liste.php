<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Dépenses</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Formulaire de filtre -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Filtrer les Dépenses</h5>
                        <form method="get" action="/depense/list">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="date_debut">Date de début</label>
                                    <input type="date" class="form-control" name="date_debut" id="date_debut" value="<?= htmlspecialchars($date_debut) ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="date_fin">Date de fin</label>
                                    <input type="date" class="form-control" name="date_fin" id="date_fin" value="<?= htmlspecialchars($date_fin) ?>">
                                </div>
                                <div class="form-group col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary mr-2">Filtrer</button>
                                    <a href="/depense/list" class="btn btn-secondary">Réinitialiser</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end">
                <a href="/budget/index" class="btn btn-info">💰 Voir le budget</a>
            </div>
        </div>

        <!-- Dépense totale -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-danger">
                    <strong>Dépense totale :</strong> <?= number_format($total_depense, 2) ?> Ar
                </div>
            </div>
        </div>

        <!-- Tableau des dépenses -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Liste des Dépenses</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered verticle-middle">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Type de dépense</th>
                                        <th>Date</th>
                                        <th>Montant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($depenses)): ?>
                                        <tr>
                                            <td colspan="3" class="text-center">Aucune dépense trouvée pour les dates sélectionnées.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($depenses as $depense): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($depense->type_depense) ?></td>
                                                <td><?= htmlspecialchars($depense->date_depense) ?></td>
                                                <td><?= number_format($depense->montant, 2) ?> Ar</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div> <!-- .table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .container-fluid -->

</div>
<!--**********************************
    Content body end
***********************************-->
