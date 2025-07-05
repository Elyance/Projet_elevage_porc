<?php
// views/tache_assign.php
// 1ère étape : sélection de l'employé
?>
<h2>Assigner une tâche</h2>
<?php if (!isset($step) || $step == 1): ?>
<form method="post" action="/tache/assign">
    <label>Sélectionner un employé :</label>
    <select name="id_employe" required>
        <?php foreach ($employes as $emp): ?>
            <option value="<?= $emp['id_employe'] ?>"> <?= htmlspecialchars($emp['nom_employe'].' '.$emp['prenom_employe']) ?> </option>
        <?php endforeach; ?>
    </select>
    <button type="submit" name="continue" value="1">CONTINUE</button>
</form>
<?php elseif ($step == 2): ?>
<form method="post" action="/tache/assign/save">
    <input type="hidden" name="id_employe" value="<?= $id_employe ?>">
    <label>Pour employé :</label>
    <input type="text" value="<?= htmlspecialchars($employe_nom) ?>" disabled><br>
    <label>Sélection de la tâche :</label>
    <select name="id_tache" required>
        <?php foreach ($taches as $tache): ?>
            <option value="<?= $tache['id_tache'] ?>"> <?= htmlspecialchars($tache['nom_tache']) ?> </option>
        <?php endforeach; ?>
    </select><br>
    <label>Date d'échéance :</label>
    <input type="date" name="date_echeance" required><br>
    <button type="submit">Valider</button>
</form>
<?php endif; ?>
