<h1>Gestion des Employés</h1>
<div>
    <a href="/salaire">Gestion Salaire</a> | 
    <a href="/presence">Gestion Présence</a> | 
    <a href="/tache">Gestion Tâches</a> | 
    <a href="/add_employe">Ajouter Employé</a>
</div>
<table border="1">
    <tr>
        <th>Nom</th>
        <th>Rôle</th>
        <th>Date Recrutement</th>
        <th>Statut</th>
        <th>Action</th>
    </tr>
    <?php foreach ($employes as $employe): ?>
    <tr>
        <td><?= htmlspecialchars($employe->nom_employe . ' ' . $employe->prenom_employe) ?></td>
        <td><?= htmlspecialchars($employe->nom_poste) ?></td>
        <td><?= htmlspecialchars($employe->date_recrutement) ?></td>
        <td><?= htmlspecialchars($employe->statut) ?></td>
        <td>
            <?php if ($employe->statut === 'actif'): ?>
                <a href="/employe/congedier/<?= $employe->id_employe ?>">Congédier</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>