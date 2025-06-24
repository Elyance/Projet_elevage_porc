<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des truies</title>
    <style>
        table { border-collapse: collapse; width: 60%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Liste des truies</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Race</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($truies)): ?>
                <?php foreach ($truies as $truie): ?>
                    <tr>
                        <td><?= htmlspecialchars($truie->id) ?></td>
                        <td><?= htmlspecialchars($truie->nom) ?></td>
                        <td><?= htmlspecialchars($truie->race) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align:center;">Aucune truie trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>