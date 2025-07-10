<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Dépenses</h4>
                </div>

                <div class="basic-form mb-4">
                    <form method="get" action="<?= BASE_URL ?>/depense/list">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Date de début</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="date_debut" id="date_debut" value="<?= htmlspecialchars($date_debut) ?>">
                            </div>
                            <label class="col-sm-2 col-form-label">Date de fin</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="date_fin" id="date_fin" value="<?= htmlspecialchars($date_fin) ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-primary">Filtrer</button>
                                <a href="<?= BASE_URL ?>/depense/list" class="btn btn-secondary">Réinitialiser</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="alert alert-info">
                    <strong>Dépense totale : </strong><?= number_format($total_depense, 2) ?> Ar
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
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
                </div>

                <div class="mt-3">
                    <a href="<?= BASE_URL ?>/budget/index" class="btn btn-info">Voir le budget</a>
                </div>
            </div>
        </div>
    </div>
</div>