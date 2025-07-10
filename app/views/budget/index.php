<?php
$moisNoms = [
    1 => 'Janvier',
    2 => 'Février',
    3 => 'Mars',
    4 => 'Avril',
    5 => 'Mai',
    6 => 'Juin',
    7 => 'Juillet',
    8 => 'Août',
    9 => 'Septembre',
    10 => 'Octobre',
    11 => 'Novembre',
    12 => 'Décembre'
];
?>

<h2>Budget</h2>
<form method="get" action="/budget/index">
    <div>
        <label for="annee">Année</label>
        <input type="number" name="annee" id="annee" value="<?= htmlspecialchars($annee) ?>" min="2000" max="<?= date('Y') ?>">
    </div>
    <button type="submit">Filtrer</button>
    <a href="<?= BASE_URL?>/budget/index">Réinitialiser</a>
</form>

<h3>Budget Mensuel</h3>
<table border="1">
    <tr>
        <th>Année</th>
        <th>Mois</th>
        <th>Recette Totale (Ar)</th>
        <th>Dépense Totale (Ar)</th>
        <th>Budget (Ar)</th>
    </tr>
    <?php if (empty($budgetParMois)): ?>
        <tr>
            <td colspan="5">Aucun budget trouvé pour l'année sélectionnée.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($budgetParMois as $budget): ?>
            <?php
                $annee = $budget['annee'];
                $mois = $budget['mois'];
                $moisNom = $moisNoms[$mois]; // Nom du mois en français
                $date_debut = "$annee-" . sprintf("%02d", $mois) . "-01";
                $dernier_jour = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
                $date_fin = "$annee-" . sprintf("%02d", $mois) . "-$dernier_jour";
                $recette_url = "/commande/recette?date_debut=$date_debut&date_fin=$date_fin";
                $depense_url = "/depense/list?date_debut=$date_debut&date_fin=$date_fin";
            ?>
            <tr>
                <td><?= htmlspecialchars($budget['annee']) ?></td>
                <td><?= htmlspecialchars($moisNom) ?></td>
                <td><?= number_format($budget['total_recette'], 2) ?> <a href="<?= BASE_URL?><?= htmlspecialchars($recette_url) ?>">(Détails)</a></td>
                <td><?= number_format($budget['total_depense'], 2) ?><a href="<?= BASE_URL?><?= htmlspecialchars($depense_url) ?>"> (Détails)</a></td>
                <td><?= number_format($budget['budget'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<h3>Budget Annuel</h3>
<table border="1">
    <tr>
        <th>Année</th>
        <th>Recette Totale (Ar)</th>
        <th>Dépense Totale (Ar)</th>
        <th>Budget (Ar)</th>
    </tr>
    <?php if (empty($budgetParAn)): ?>
        <tr>
            <td colspan="4">Aucun budget trouvé pour l'année sélectionnée.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($budgetParAn as $budget): ?>
            <?php
                $annee = $budget['annee'];
                $date_debut = "$annee-01-01";
                $date_fin = "$annee-12-31";
                $recette_url = "/commande/recette?date_debut=$date_debut&date_fin=$date_fin";
                $depense_url = "/depense/list?date_debut=$date_debut&date_fin=$date_fin";
            ?>
            <tr>
                <td><?= htmlspecialchars($budget['annee']) ?></td>
                <td><?= number_format($budget['total_recette'], 2) ?><a href="<?= BASE_URL?><?= htmlspecialchars($recette_url) ?>"> Détails</a></td>
                <td><?= number_format($budget['total_depense'], 2) ?><a href="<?= BASE_URL?><?= htmlspecialchars($depense_url) ?>"> Détails</a></td>
                <td><?= number_format($budget['budget'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>