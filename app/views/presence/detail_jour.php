<h1>Détail du Jour - <?= htmlspecialchars($date) ?></h1>
<h2>Employés Présents</h2>
<ul>
    <?php foreach ($present_employes as $emp): ?>
        <li><?= htmlspecialchars($emp->nom_employe . ' ' . $emp->prenom_employe) ?></li>
    <?php endforeach; ?>
</ul>
<h2>Employés en Congé Payé</h2>
<p>(Placeholder)</p>
<ul>
    <?php foreach ($conge_payes as $emp): ?>
        <li><?= htmlspecialchars($emp->nom_employe . ' ' . $emp->prenom_employe) ?></li>
    <?php endforeach; ?>
</ul>
<a href="/presence/add_presence?date=<?= $date ?>">Ajouter Présence</a>
<a href="/presence">Retour</a>