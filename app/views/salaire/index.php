<?php use app\models\SalaireModel; ?>
<h1>Gestion des Salaires</h1>
<form method="get" action="/salaire">
    <label>Mois: 
        <select name="mois" onchange="this.form.submit()">
            <?php foreach ($months as $m): ?>
                <option value="<?= $m ?>" <?= $m == $month ? "selected" : "" ?>><?= $m ?></option>
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
    <a href="/salaire/historique_paie?annee=<?= $year ?>">Historique Paiement</a>
</form>
<table border="1">
    <tr>
        <th>Nom</th>
        <th>Rôle</th>
        <th>Statut Paiement</th>
        <th>Action</th>
    </tr>
    <?php foreach ($employes as $employe): ?>
    <tr>
        <td><?= htmlspecialchars($employe->nom_employe . ' ' . $employe->prenom_employe) ?></td>
        <td><?= htmlspecialchars($employe->nom_poste) ?></td>
        <td>
            <?php
            $date_pattern = "$year-$month%"; // e.g., "2025-07%"
            $salaires = SalaireModel::getAll(["date_salaire LIKE" => $date_pattern, "id_employe" => $employe->id_employe]);
            $salaire = !empty($salaires) ? $salaires[0] : null;
            echo htmlspecialchars($salaire ? $salaire->statut : "non payé");
            ?>
        </td>
        <td>
            <?php if (!$salaire || $salaire->statut === "non payé"): ?>
                <a href="/salaire/payer/<?= $employe->id_employe ?>?mois=<?= $month ?>&annee=<?= $year ?>">Payer</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>