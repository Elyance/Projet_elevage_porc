<!-- app/views/naissance/add.php -->
<h1>NAISSANCE</h1>
<p>ID de la Mère: <?= htmlspecialchars($truie_id ?? 'Non spécifié') ?></p>
<p>ID du Cycle: <?= htmlspecialchars($cycle_id ?? 'Non spécifié') ?></p>
<form method="POST">
    <input type="hidden" name="cycle_id" value="<?= htmlspecialchars($cycle_id ?? '') ?>">
    <input type="hidden" name="truie_id" value="<?= htmlspecialchars($truie_id ?? '') ?>">
    
    <label>Nombre de Portées: <input type="number" name="nombre_porcs" required min="1"></label><br>
    
    <label>Enclos: 
        <select name="enclos_id" required>
            <?php foreach ($enclos as $encl): ?>
                <option value="<?= $encl['id_enclos'] ?>"><?= htmlspecialchars($encl['id_enclos']) ?> (Type: <?= htmlspecialchars($encl['enclos_type']) ?>)</option>
            <?php endforeach; ?>
        </select>
    </label><br>
    
    <button type="submit">Ajouter</button>
</form>