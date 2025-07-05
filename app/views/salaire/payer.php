<h1>Paiement du Salaire</h1>
<p>Nom: <?= htmlspecialchars($employe->nom_employe . ' ' . $employe->prenom_employe) ?></p>
<p>Rôle: <?= htmlspecialchars($employe->nom_poste) ?></p>
<p>Salaire Brut: <?= number_format($salaire_brut, 2) ?> FCFA</p>
<p>Nombre de Jours Présents: <?= $nb_jours_present ?></p>
<p>Taux: <?= number_format($taux, 2) ?></p>
<p>Salaire Final: <?= number_format($salaire_final, 2) ?> FCFA</p>

<form method="post" action="/salaire/payer/<?= $employe->id_employe ?>?mois=<?= $month ?>&annee=<?= $year ?>">
    <input type="hidden" name="salaire_final" value="<?= $salaire_final ?>">
    <button type="submit">Confirmer Paiement</button>
</form>
<a href="/salaire?mois=<?= $month ?>&annee=<?= $year ?>">Retour</a>