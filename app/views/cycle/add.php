<!-- app/views/cycle/add.php -->
<h1>CYCLES ET PRÉDICTION</h1>
<form method="POST">
    <label>Truie: 
        <select name="truie_id" required>
            <?php foreach ($truies as $truie): ?>
                <option value="<?= $truie['id_truie'] ?>"><?= htmlspecialchars($truie['poids']) ?> kg</option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Date Début Cycle: <input type="date" name="date_debut_cycle" required></label><br>
    <label>Date Fin Cycle: <input type="date" name="date_fin_cycle" required></label><br>
    <label>Nombre Portée: <input type="number" name="nombre_portee" required></label><br>
    <button type="submit">Ajouter</button>
</form>