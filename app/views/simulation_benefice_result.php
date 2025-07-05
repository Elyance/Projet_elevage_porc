<?php
?>
<style>
.container {
    background-color: #fff;
    padding: 32px 36px 28px 36px;
    border-radius: 14px;
    box-shadow: 0 4px 24px #0001;
    max-width: 1100px;
    margin: 48px auto 0 auto;
    font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
}
.container h2 {
    text-align: center;
    color: #4e73df;
    margin-bottom: 28px;
    font-weight: 700;
    letter-spacing: 1px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #f8fafc;
    border-radius: 10px;
    overflow: hidden;
    font-size: 15px;
}
th, td {
    border: 1px solid #e0e7ef;
    padding: 8px;
    text-align: center;
}
th {
    background-color: #f8f9fa;
    font-weight: bold;
}
.positive { color: #1cc88a; font-weight: bold; }
.negative { color: #e74a3b; font-weight: bold; }
.summary {
    background-color: #fff3cd;
    padding: 18px 22px;
    border-radius: 8px;
    margin-top: 32px;
    color: #444;
    font-size: 16px;
    border-left: 4px solid #4e73df;
}
.summary strong { color: #4e73df; }
</style>
<div class="container">
    <h2>📊 Résultats de la simulation</h2>
    <table>
        <tr>
            <th>Mois</th>
            <th>Truies</th>
            <th>Porcelets</th>
            <th>Porcs</th>
            <th>Événements</th>
            <th>Revenus</th>
            <th>Coûts</th>
            <th>Bénéfice</th>
            <th>Bénéfice Cumulé</th>
        </tr>
        <?php foreach($simulation as $mois): ?>
        <tr>
            <td><?= $mois['mois'] ?></td>
            <td><?= $mois['nbTruies'] ?></td>
            <td><?= $mois['nbPorcelets'] ?></td>
            <td><?= $mois['nbPorcs'] ?></td>
            <td style="text-align:left"><?= implode('<br>', $mois['evenements']) ?></td>
            <td><?= number_format($mois['revenus'], 0, ',', ' ') ?></td>
            <td><?= number_format($mois['couts'], 0, ',', ' ') ?></td>
            <td class="<?= $mois['beneficeMensuel'] >= 0 ? 'positive' : 'negative' ?>">
                <?= number_format($mois['beneficeMensuel'], 0, ',', ' ') ?>
            </td>
            <td class="<?= $mois['beneficeCumule'] >= 0 ? 'positive' : 'negative' ?>">
                <?= number_format($mois['beneficeCumule'], 0, ',', ' ') ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php
    // Résumé financier PHP
    $dernierMois = end($simulation);
    $investissementInitial = ($params['nbTruies'] * $params['prixAlimentTruie']) + ($params['nbPorcs'] * $params['prixAlimentPorc']);
    $beneficeTotal = $dernierMois['beneficeCumule'];
    $roi = $investissementInitial > 0 ? ($beneficeTotal / $investissementInitial) * 100 : 0;
    // Recherche du mois de retour sur investissement
    $moisROI = 'Non atteint';
    foreach ($simulation as $mois) {
        if ($mois['beneficeCumule'] >= 0) {
            $moisROI = 'Mois ' . $mois['mois'];
            break;
        }
    }
    ?>
    <div class="summary">
        <h3>💰 Résumé Financier</h3>
        <p><strong>Paramètres :</strong> <?= $params['porceletsParAn'] ?> porcelets/truie/an, maturation en <?= $params['moisMaturation'] ?> mois</p>
        <p><strong>Vente :</strong> <?= ($params['venteAutomatique'] === true || $params['venteAutomatique'] === 'true') ? 'Automatique dès maturation' : 'Manuelle (porcs gardés en stock)' ?></p>
        <p><strong>Investissement mensuel moyen :</strong> <?= number_format($investissementInitial, 0, ',', ' ') ?> Ar</p>
        <p><strong>Bénéfice total sur <?= $params['nbMoisSimulation'] ?> mois :</strong> 
           <span class="<?= $beneficeTotal >= 0 ? 'positive' : 'negative' ?>"><?= number_format($beneficeTotal, 0, ',', ' ') ?> Ar</span></p>
        <p><strong>ROI :</strong> <span class="<?= $roi >= 0 ? 'positive' : 'negative' ?>"><?= number_format($roi, 2, ',', ' ') ?>%</span></p>
        <p><strong>Retour sur investissement :</strong> <?= $moisROI ?></p>
        <p><strong>Bénéfice moyen par mois :</strong> <?= number_format($beneficeTotal / $params['nbMoisSimulation'], 0, ',', ' ') ?> Ar</p>
    </div>
</div>