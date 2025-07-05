<h1>Historique des Paiements</h1>
<form method="get" action="/salaire/historique_paie">
    <label>Employé: 
        <select name="employe" onchange="this.form.submit()">
            <option value="">Tous</option>
            <?php foreach ($employes as $emp): ?>
                <option value="<?= $emp->id_employe ?>" <?= $emp->id_employe == $selected_employe ? "selected" : "" ?>>
                    <?= htmlspecialchars($emp->nom_employe . ' ' . $emp->prenom_employe) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>Année: 
        <select name="annee" onchange="this.form.submit()">
            <?php foreach ($years as $y): ?>
                <option value="<?= $y ?>" <?= $y == $year ? "selected" : "" ?>><?= $y ?></option>
            <?php endforeach; ?>
        </select>
    </label>
</form>
<table border="1">
    <tr>
        <th>Mois</th>
        <th>Nombre de Jours Présents</th>
        <th>Taux</th>
        <th>Salaire Final</th>
    </tr>
    <?php foreach ($data as $record): ?>
    <tr>
        <td><?= htmlspecialchars($record["mois"]) ?></td>
        <td><?= htmlspecialchars($record["nb_jours_present"]) ?></td>
        <td><?= number_format($record["taux"], 2) ?></td>
        <td><?= number_format($record["salaire_final"], 2) ?> FCFA</td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="/salaire">Retour</a>