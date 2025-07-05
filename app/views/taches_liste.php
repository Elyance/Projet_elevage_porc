<?php
// views/taches_liste.php
// Tableau des tâches (admin)
// Colonnes : Nom, Rôle concerné, Actions (modifier, supprimer)
?>
<h2>Liste des tâches</h2>
<a href="<?= BASE_URL ?>/tache/create">Créer une tâche</a>
<table border="1">
    <tr>
        <th>Nom de la tâche</th>
        <th>Rôle concerné</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($taches as $tache): ?>
    <tr>
        <td><?= htmlspecialchars($tache['nom_tache']) ?></td>
        <td><?= htmlspecialchars($tache['nom_poste']) ?></td>
        <td>
            <a href="<?= BASE_URL ?>/tache/edit/<?= $tache['id_tache'] ?>">Modifier</a> |
            <a href="<?= BASE_URL ?>/tache/delete/<?= $tache['id_tache'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="<?= BASE_URL ?>/tache/assign">Assigner une tâche</a>
