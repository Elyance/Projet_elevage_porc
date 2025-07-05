<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation d'un diagnostic</title>
</head>

<body>
    <form method="post">
        <label for="id_maladie">Maladie : </label>
        <select name="id_maladie" id="id_maladie">
            <?php if(!empty($maladies)) {
                foreach($maladies as $maladie) {?>
                    <option value="<?= htmlspecialchars($maladie['id_maladie']) ?>"><?= htmlspecialchars($maladie['nom_maladie']) ?></option>
            <?php }
            }?>
        </select>
        <br>
        <label for="id_enclos">Enclos : </label>
        <select name="id_enclos" id="id_enclos">
            <?php if(!empty($enclos)) {
                foreach($enclos as $enclo) {?>
                    <option value="<?=$enclo['id_enclos'] ?>"><?= $enclo['id_enclos'] ?></option>
            <?php }
            }?>
        </select>
        <br>
        <label for="nombre_infecte">Nombre d'infecte : </label>
        <input type="number" name="nombre_infecte" id="nombre_infecte">
        <br>
        <label for="date_apparition">Date d'apparition: </label>
        <input type="date" name="date_apparition" id="date_apparition">
        <br>
        <label for="date_diagnostic">Date de diagnostic : </label>
        <input type="date" name="date_diagnostic" id="date_diagnostic">
        <br>
        <label for="desc_traitement">Description : </label>
        <input type="text" name="desc_traitement" id="desc_traitement">
        <br>
        <label for="statut">Statut : </label>
        <select name="statut" id="statut">
            <option value="en quarantaine">En quarantaine</option>
            <option value="en traitement">En traitement</option>
            <option value="reussi">Reussi</option>
            <option value="echec">Echec</option>
        </select>
        <br>
        <label for="prix_traitement">Prix : </label>
        <input type="number" name="prix_traitement" id="prix_traitement">
        <br><br>
        <button type="submit">Créer l'évènement</button>

    </form>
</body>

</html>