<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <ul>
            <li><a href="diagnostic/add">Ajouter diagnostic</a></li>
            <li><a href="maladie">Liste maladies</a></li>
        </ul>
    </div>
    <div>
        <?php if (!empty($diagnostics)) { ?>
            <table>
                <tr>
                    <th>Nom maladie</th>
                    <th>Enclos Portée</th>
                    <th>Statut</th>
                    <th>Mâles infectés</th>
                    <th>Femelles infectées</th>
                </tr>
                <?php foreach ($diagnostics as $diagnostic) { ?>
                    <tr>
                        <td><?= htmlspecialchars($diagnostic['id_maladie']) ?></td>
                        <td><?= htmlspecialchars($diagnostic['id_enclos_portee']) ?></td>
                        <td><?= htmlspecialchars($diagnostic['statut']) ?></td>
                        <td><?= htmlspecialchars($diagnostic['nombre_males_infectes']) ?></td>
                        <td><?= htmlspecialchars($diagnostic['nombre_femelles_infectes']) ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
</body>

</html>