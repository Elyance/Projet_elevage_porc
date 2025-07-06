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
        <label for="id_enclos_portee">Enclos Portée : </label>
        <select name="id_enclos_portee" id="id_enclos_portee">
            <?php if(!empty($enclos_portee)) {
                foreach($enclos_portee as $enclo) {?>
                    <option value="<?= htmlspecialchars($enclo['id_enclos_portee']) ?>"><?= htmlspecialchars($enclo['id_enclos_portee']) ?> (Enclos: <?= $enclo['id_enclos'] ?>)</option>
            <?php }
            }?>
        </select>
        <br>
        <label for="id_enclos_portee_original">Enclos Portée Original : </label>
        <select name="id_enclos_portee_original" id="id_enclos_portee_original">
            <?php if(!empty($enclos_portee)) {
                foreach($enclos_portee as $enclo) {?>
                    <option value="<?= htmlspecialchars($enclo['id_enclos_portee']) ?>"><?= htmlspecialchars($enclo['id_enclos_portee']) ?> (Enclos: <?= $enclo['id_enclos'] ?>)</option>
            <?php }
            }?>
        </select>
        <br>
        <label for="nombre_males_infectes">Nombre de mâles infectés : </label>
        <input type="number" name="nombre_males_infectes" id="nombre_males_infectes" min="0" required>
        <br>
        <label for="nombre_femelles_infectes">Nombre de femelles infectées : </label>
        <input type="number" name="nombre_femelles_infectes" id="nombre_femelles_infectes" min="0" required>
        <br>
        <label for="date_apparition">Date d'apparition: </label>
        <input type="date" name="date_apparition" id="date_apparition" required>
        <br>
        <label for="date_diagnostic">Date de diagnostic : </label>
        <input type="date" name="date_diagnostic" id="date_diagnostic" required>
        <br>
        <label for="desc_traitement">Description : </label>
        <input type="text" name="desc_traitement" id="desc_traitement">
        <br>
        <label for="statut">Statut : </label>
        <select name="statut" id="statut">
            <option value="signale">Signalé</option>
            <option value="en quarantaine">En quarantaine</option>
            <option value="en traitement">En traitement</option>
            <option value="reussi">Reussi</option>
            <option value="echec">Echec</option>
        </select>
        <br>
        <label for="prix_traitement">Prix : </label>
        <input type="number" name="prix_traitement" id="prix_traitement" step="0.01" min="0">
        <br><br>
        <button type="submit">Créer l'évènement</button>
    </form>
</body>

</html>