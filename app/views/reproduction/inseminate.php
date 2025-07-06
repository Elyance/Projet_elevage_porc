<!-- app/views/reproduction/inseminate.php -->
<h1>LISTE INSÉMINATION</h1>
<form method="POST">
    <label>Truie: 
        <select name="truie_id" required>
            <?php foreach ($truies as $truie): ?>
                <option value="<?= $truie->id_truie ?>">id: <?= htmlspecialchars($truie->id_truie) ?> (enclos <?= htmlspecialchars($truie->id_enclos) ?>)</option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Date: <input type="date" name="date_insemination" required></label><br>
    <button type="submit">Ajouter</button>
</form>