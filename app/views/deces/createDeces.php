<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation d'un diagnostic</title>
</head>

<body>
    <form method="post">
        <label for="id_enclos">Enclos : </label>
        <select name="id_enclos" id="id_enclos">
            <?php if(!empty($enclos)) {
                foreach($enclos as $enclo) {?>
                    <option value="<?=$enclo['id_enclos'] ?>"><?= $enclo['id_enclos'] ?></option>
            <?php }
            }?>
        </select>
        <br>
        <label for="nombre_deces">Nombre de mort : </label>
        <input type="number" name="nombre_deces" id="nombre_deces">
        <br>
        <label for="date_deces">Date: </label>
        <input type="date" name="date_deces" id="date_deces">
        <br>
        <label for="cause_deces">Cause : </label>
        <input type="text" name="cause_deces" id="cause_deces">
        <br><br>
        <button type="submit">Avis de décès</button>

    </form>
</body>

</html>