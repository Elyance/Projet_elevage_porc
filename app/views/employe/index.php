<!-- app/views/employe/index.php -->
<h1>Gestion des Employés</h1>
<div>
    <a href="<?= BASE_URL?>/salaire">Gestion Salaire</a> | 
    <a href="<?= BASE_URL?>/presence">Gestion Présence</a> | 
    <a href="<?= BASE_URL?>/tache">Gestion Tâches</a> | 
    <a href="<?= BASE_URL?>/add_employe">Ajouter Employé</a>
</div>
<table border="1">
    <tr>
        <th>Nom</th>
        <th>Rôle</th>
        <th>Date Recrutement</th>
        <th>Action</th>
    </tr>
    <?php foreach ($employes as $employe): ?>
    <tr>
        <td><?= htmlspecialchars($employe->nom_employe . ' ' . $employe->prenom_employe) ?></td>
        <td><?= htmlspecialchars($employe->nom_poste) ?></td>
        <td><?= htmlspecialchars($employe->date_recrutement) ?></td>
        <td>
            <a href="/conge/add?id_employe=<?= $employe->id_employe ?>">Demande de Congé</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>