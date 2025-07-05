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
            <li><a href="maladie/add">Ajouter maladie</a></li>
        </ul>
    </div>
    <div>
        <?php if (!empty($maladies)) { ?>
            <table>
                <tr>
                    <th>Nom maladie</th>
                    <th>Symptomes</th>
                    <th>Description</th>
                    <th>Dangerosite</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($maladies as $maladie) { ?>
                    <tr>
                        <td><?= htmlspecialchars($maladie['nom_maladie']) ?></td>
                        <td>
                            <?php if (!empty($symptomes)) {
                                    foreach ($symptomes as $symptome) {
                                        if($symptome['id_maladie']==$maladie['id_maladie']) {?>
                                            <?= htmlspecialchars($symptome['nom_symptome']) ?> 
                                    <?php }
                                    }
                                }?>
                        </td>
                        <td><?= htmlspecialchars($maladie['description']) ?></td>
                        <td><?= htmlspecialchars($maladie['dangerosite']) ?></td>
                        <td>
                            <a href="maladie/edit/<?= $maladie['id_maladie'] ?>">Modifier</a>
                            <a href="maladie/delete/<?= $maladie['id_maladie'] ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
</body>

</html>