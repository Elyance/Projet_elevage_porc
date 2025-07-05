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
            <li><a href="deces/add">Ajouter deces</a></li>
        </ul>
    </div>
    <div>
        <?php if (!empty($deces)) { ?>
            <table>
                <tr>
                    <th>Enclos</th>
                    <th>Nombre de décès</th>
                    <th>Date de deces</th>
                    <th>Cause</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($deces as $dece) { ?>
                    <tr>
                        <td><?= htmlspecialchars($dece['id_enclos']) ?></td>
                        <td><?= htmlspecialchars($dece['nombre_deces']) ?></td>
                        <td><?= htmlspecialchars($dece['date_deces']) ?></td>
                        <td><?= htmlspecialchars($dece['cause_deces']) ?></td>
                        <td>
                            <a href="deces/edit/<?= $dece['id_deces'] ?>">Modifier</a>
                            <a href="deces/delete/<?= $dece['id_deces'] ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
</body>

</html>