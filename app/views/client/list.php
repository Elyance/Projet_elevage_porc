<h2>📋 Liste des clients</h2>
<a href="/clients/create">➕ Ajouter un client</a>
<table border="1">
    <tr><th>Nom</th><th>Type</th><th>Téléphone</th><th>Email</th><th>Actions</th></tr>
    <?php foreach ($clients as $c): ?>
    <tr>
        <td><?= htmlspecialchars($c['nom_client']) ?></td>
        <td><?= $c['type_profil'] ?></td>
        <td><?= $c['contact_telephone'] ?></td>
        <td><?= $c['contact_email'] ?></td>
        <td>
            <a href="/clients/edit/<?= $c['id_client'] ?>">✏️</a>
            <a href="/clients/delete/<?= $c['id_client'] ?>" onclick="return confirm('Supprimer ?')">🗑️</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
