<?php use app\models\PresenceModel; ?>
<h1>Ajouter Présence - <?= htmlspecialchars($date) ?></h1>
<form method="post" action="/presence/add_presence?date=<?= $date ?>">
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Présence</th>
        </tr>
        <?php foreach ($employes as $employe): ?>
        <tr>
            <td><?= htmlspecialchars($employe->nom_employe . ' ' . $employe->prenom_employe) ?></td>
            <td><input type="checkbox" name="presence_<?= $employe->id_employe ?>" <?= PresenceModel::getPresenceStatus($employe->id_employe, $date) === "present" ? "checked" : "" ?>></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <button type="submit">Sauvegarder</button>
</form>
<a href="/presence/detail_jour/<?= $date ?>">Retour</a>