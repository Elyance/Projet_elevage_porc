<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Modifier la maladie</h1>
    <form method="post">
        <label for="nom_maladie">Nom de la maladie :</label>
        <input type="text" name="nom_maladie" id="nom_maladie" value="<?= htmlspecialchars($maladie['nom_maladie']) ?>">
        <br>

        <label for="description">Description :</label>
        <input type="text" name="description" id="description" value="<?= htmlspecialchars($maladie['description']) ?>">
        <br>

        <label for="dangerosite">Dangerosité :</label>
        <select name="dangerosite" id="dangerosite">
            <option value="faible" <?= $maladie['dangerosite'] === 'faible' ? 'selected' : '' ?>>Faible</option>
            <option value="moderee" <?= $maladie['dangerosite'] === 'moderee' ? 'selected' : '' ?>>Modérée</option>
            <option value="elevee" <?= $maladie['dangerosite'] === 'elevee' ? 'selected' : '' ?>>Élevée</option>
        </select>
        <br>

        <label>Symptômes :</label><br>
        <?php
        $idsSymptomesAssocies = array_column($symptomes_maladie, 'id_symptome');
        foreach ($symptomes as $symptome):
            $checked = in_array($symptome['id_symptome'], $idsSymptomesAssocies) ? 'checked' : '';
            ?>
            <input type="checkbox" name="id_symptomes[]" value="<?= $symptome['id_symptome'] ?>" id="symptome_<?= $symptome['id_symptome'] ?>"
                <?= $checked ?>>
            <label for="symptome_<?= $symptome['id_symptome'] ?>"><?= htmlspecialchars($symptome['nom_symptome']) ?></label><br>
        <?php endforeach; ?>

        <br>
        <button type="submit">Modifier la maladie</button>
    </form>

</body>

</html>