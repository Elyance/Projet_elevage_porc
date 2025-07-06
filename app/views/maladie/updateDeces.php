<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Modifier un deces</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="id_enclos">Id enclos</label>
        <select name="id_enclos" id="id_enclos">
        <?php foreach ($enclos as $enclo):?>
            <option value="<?= $enclo['id_enclos'] ?>"<?php if($enclo['id_enclos']==$deces['id_enclos']) {?>
                selected <?php }?>><?= $enclo['id_enclos'] ?></option>
        <?php  endforeach?>
        </select>
        <br>
        <label for="nombre_deces">Nombre de décès : </label>
        <input type="number" name="nombre_deces" id="nombre_deces" value="<?= htmlspecialchars($deces['nombre_deces']) ?>" required>
        <br>
        <label for="date_deces">Date : </label>
        <input type="date" name="date_deces" value="<?= htmlspecialchars($deces['date_deces']) ?>" required>
        <br>
        <label for="cause_deces">Date : </label>
        <input type="text" name="cause_deces" value="<?= htmlspecialchars($deces['cause_deces']) ?>" required>
        <br><br>
        <button type="submit">Mettre à jour</button>
    </form>
</body>

</html>