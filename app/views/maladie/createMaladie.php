<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation d'une maladie</title>
</head>

<body>
    <form method="post">
        <label for="nom_maladie">Nom de la maladie : </label>
        <input type="text" name="nom_maladie" id="nom_maladie">
        <br>
        <label for="description">Description : </label>
        <input type="text" name="description" id="description">
        <br>
        <label for="dangerosite">Dangerosite : </label>
        <select name="dangerosite" id="dangerosite">
            <option value="faible">Faible</option>
            <option value="moderee">Moderee</option>
            <option value="elevee">Elevee</option>
        </select>
        <br>
        <label>Symptômes :</label><br>
        <?php foreach ($symptomes as $symptome): ?>
            <input type="checkbox" name="id_symptomes[]" value="<?= $symptome['id_symptome'] ?>"
                id="symptome_<?= $symptome['id_symptome'] ?>">
            <label for="symptome_<?= $symptome['id_symptome'] ?>"><?= htmlspecialchars($symptome['nom_symptome']) ?></label><br>
        <?php endforeach; ?>
        <br><br>
        <button type="submit">Créer la maladie</button>

    </form>
</body>

</html>