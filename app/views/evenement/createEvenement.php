<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation d'un Evenement</title>
</head>

<body>
    <form method="post">
        <label for="id_type_evenement">Evenement : </label>
        <select name="id_type_evenement" id="id_type_evenement">
            <?php if (!empty($santetypevenements)): ?>
                <?php foreach ($santetypevenements as $santetypeevenement): ?>
                    <option value="<?= htmlspecialchars($santetypeevenement['id_type_evenement']) ?>">
                        <?= htmlspecialchars($santetypeevenement['nom_type_evenement']) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <br>
        <label for="id_enclos">Enclos : </label>
        <select name="id_enclos" id="id_enclos">
            <?php if (!empty($enclos)): ?>
                <?php foreach ($enclos as $enclo): ?>
                    <option value="<?= htmlspecialchars($enclo['id_enclos']) ?>">
                        Enclos numero <?= htmlspecialchars($enclo['id_enclos']) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <br>
        <label for="date_evenement">Date : </label>
        <input type="date" name="date_evenement" id="date_evenement">
        <br><br>
        <button type="submit">Créer l'évènement</button>

    </form>
</body>

</html>