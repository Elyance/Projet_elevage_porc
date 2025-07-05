<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="/insert">Aujouter Employer</a>
    <a href=""></a>
    <a href=""></a>
    <a href=""></a>
    <h2>Liste des employés</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom complet</th>
                <th>Poste</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Date recrutement</th>
                <th>Date retrait</th>
                <th>Statut</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($employes) === 0): ?>
                <tr><td colspan="8">Aucun employé trouvé.</td></tr>
            <?php else: ?>
                <?php foreach ($employes as $emp): ?>
                    <tr>
                        <td><?= $emp['id_employe'] ?></td>
                        <td><?= htmlspecialchars($emp['nom_employe'] . ' ' . $emp['prenom_employe']) ?></td>
                        <td><?= htmlspecialchars($emp['nom_poste'] ?? 'Non défini') ?></td>
                        <td><?= htmlspecialchars($emp['adresse']) ?></td>
                        <td><?= htmlspecialchars($emp['contact_telephone']) ?></td>
                        <td><?= htmlspecialchars($emp['date_recrutement']) ?></td>
                        <td><?= $emp['date_retirer'] ? htmlspecialchars($emp['date_retirer']) : '-' ?></td>
                        <td><?= htmlspecialchars($emp['statut']) ?></td>
                        <td>
                            <form method="post" class="inline">
                                <input type="hidden" name="id_employe" value="<?= $emp['id_employe'] ?>">
                                <select name="nouveau_statut" required>
                                    <option disabled selected>Choisir</option>
                                    <?php if ($emp['statut'] !== 'actif'): ?>
                                        <option value="actif">Actif</option>
                                    <?php endif; ?>
                                    <?php if ($emp['statut'] !== 'retraiter'): ?>
                                        <option value="retraiter">Retraité</option>
                                    <?php endif; ?>
                                    <?php if ($emp['statut'] !== 'congedier'): ?>
                                        <option value="congedier">Congédié</option>
                                    <?php endif; ?>
                                </select>
                                <button type="submit" name="changer_statut">OK</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>