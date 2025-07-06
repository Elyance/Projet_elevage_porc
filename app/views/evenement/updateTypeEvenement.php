<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Modifier un type d'evenement</h1>
    <form method="post" enctype="multipart/form-data">
        <label>Type d'evenement : </label>
        <input type="text" name="nom_type_evenement" value="<?= htmlspecialchars($typeevenement['nom_type_evenement']) ?>" required>
        <label>Prix : </label>
        <input type="number" name="prix" value="<?= htmlspecialchars($typeevenement['prix']) ?>" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>

</html>