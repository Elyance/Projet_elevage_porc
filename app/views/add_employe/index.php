<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout Employé</title>
</head>
<body>
    <h2>Ajouter un nouvel employé</h2>
    <form method="post" action="">
        <label>Nom : <input type="text" name="nom" required></label><br><br>
        <label>Prénom : <input type="text" name="prenom" required></label><br><br>
        <label>Poste :
            <select name="poste" required>
                <option value="">-- Sélectionner un poste --</option>
                <?php foreach ($postes as $poste){  ?>
                    <option value="<?= $poste['id_employe_poste'] ?>"><?= htmlspecialchars($poste['nom_poste']) ?></option>
                <?php } ?>
            </select>
        </label><br><br>
        <label>Adresse : <input type="text" name="adresse"></label><br><br>
        <label>Téléphone : <input type="text" name="telephone"></label><br><br>
        <label>Date de recrutement : <input type="date" name="date_recrutement" required></label><br><br>
        <label>Statut :
            <select name="statut" required>
                <option value="actif">Actif</option>
                <option value="retraiter">Retraité</option>
                <option value="congedier">Congédié</option>
            </select>
        </label><br><br>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>