<!-- app/views/cycle/add.php -->
<h1>CYCLES ET PRÉDICTION</h1>
<form method="POST">
    <label>Truie: 
        <select name="truie_id" required>
            <?php foreach ($truies as $truie): ?>
                <option value="<?= htmlspecialchars($truie->id_truie) ?>"><?= htmlspecialchars($truie->poids) ?> kg</option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Date Début Cycle: <input type="date" name="date_debut_cycle" required></label><br>
    <label>Date Fin Cycle: <input type="date" name="date_fin_cycle" required></label><br>
    <label>Nombre de Mâles: <input type="number" name="nombre_males" required min="0"></label><br>
    <label>Nombre de Femelles: <input type="number" name="nombre_femelles" required min="0"></label><br>
    <button type="submit">Ajouter</button>
</form>