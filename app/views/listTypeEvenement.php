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
            <li><a href="typeevenement/add">Ajouter type d'evenement</a></li>
        </ul>
    </div>
    <div>
        <?php if (!empty($typeevenements)) { ?>
            <table>
                <tr>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($typeevenements as $typeevenement) { ?>
                    <tr>
                        <td><?= htmlspecialchars($typeevenement['nom_type_evenement']) ?></td>
                        <td><?= htmlspecialchars($typeevenement['prix']) ?></td>
                        <td>
                            <a href="typeevenement/edit/<?= $typeevenement['id_type_evenement'] ?>">Modifier</a>
                            <a href="typeevenement/delete/<?= $typeevenement['id_type_evenement'] ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
</body>

</html>