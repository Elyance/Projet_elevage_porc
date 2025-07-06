<?php
// views/tache_form.php
// Formulaire de création/modification de tâche
?>
<h2><?= isset($tache) ? 'Modifier' : 'Créer' ?> une tâche</h2>
<form method="post" action="/tache/save">
    <input type="hidden" name="id_tache" value="<?= isset($tache) ? $tache['id_tache'] : '' ?>">
    <label>Nom de la tâche :</label>
    <input type="text" name="nom_tache" value="<?= isset($tache) ? htmlspecialchars($tache['nom_tache']) : '' ?>" required><br>
    <label>Pour rôle :</label>
    <select name="id_employe_poste" required>
        <?php foreach ($postes as $poste): ?>
            <option value="<?= $poste['id_employe_poste'] ?>" <?= (isset($tache) && $tache['id_employe_poste'] == $poste['id_employe_poste']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($poste['nom_poste']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <label>Description :</label><br>
    <textarea name="description" required><?= isset($tache) ? htmlspecialchars($tache['description']) : '' ?></textarea><br>
    <label>Date d'attribution :</label>
    <button type="submit">Soumettre</button>
</form>