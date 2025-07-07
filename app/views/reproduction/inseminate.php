```php
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h1 style="font-size: 1.5rem; margin-bottom: 1rem;">LISTE INSÉMINATION</h1>
    <form method="POST">
        <div class="form-group">
            <label>Truie: 
                <select name="truie_id" required>
                    <?php foreach ($truies as $truie): ?>
                        <option value="<?= $truie->id_truie ?>">id: <?= htmlspecialchars($truie->id_truie) ?> (enclos <?= htmlspecialchars($truie->id_enclos) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="form-group">
            <label>Date: 
                <input type="date" name="date_insemination" required>
            </label>
        </div>
        <button type="submit">Ajouter</button>
    </form>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>