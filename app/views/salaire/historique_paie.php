<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h4>Historique des Paiements</h4>
            </div>
            
            <div class="basic-form">
                <form method="get" action="<?= BASE_URL ?>/salaire/historique_paie">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Employé:</label>
                        <div class="col-sm-4">
                            <select name="employe" class="form-control" onchange="this.form.submit()">
                                <option value="">Tous les employés</option>
                                <?php foreach ($employes as $emp): ?>
                                    <option value="<?= $emp->id_employe ?>" <?= $emp->id_employe == $selected_employe ? "selected" : "" ?>>
                                        <?= htmlspecialchars($emp->nom_employe . ' ' . $emp->prenom_employe) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <label class="col-sm-2 col-form-label">Année:</label>
                        <div class="col-sm-4">
                            <select name="annee" class="form-control" onchange="this.form.submit()">
                                <?php foreach ($years as $y): ?>
                                    <option value="<?= $y ?>" <?= $y == $year ? "selected" : "" ?>><?= $y ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="table-responsive mt-4">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Mois</th>
                            <th>Jours Présents</th>
                            <th>Taux Journalier</th>
                            <th>Salaire Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $record): ?>
                        <tr>
                            <td><?= htmlspecialchars($record["mois"]) ?></td>
                            <td><?= htmlspecialchars($record["nb_jours_present"]) ?></td>
                            <td><?= number_format($record["taux"], 2) ?> FCFA</td>
                            <td><?= number_format($record["salaire_final"], 2) ?> FCFA</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if (empty($data)): ?>
                <div class="alert alert-info mt-3">Aucun paiement enregistré pour cette période.</div>
            <?php endif; ?>
            
            <div class="mt-3">
                <a href="<?= BASE_URL ?>/salaire" class="btn btn-light">
                    <i class="fa fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>
</div>