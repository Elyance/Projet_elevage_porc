```php
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h1 style="font-size: 1.5rem; margin-bottom: 1rem;">CYCLES ET PRÉDICTION</h1>
    <form method="POST">
        <div class="form-group">
            <label>Truie: 
                <select name="truie_id" required>
                    <?php foreach ($truies as $truie): ?>
                        <option value="<?= htmlspecialchars($truie->id_truie) ?>"><?= htmlspecialchars($truie->poids) ?> kg</option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="form-group">
            <label>Date Début Cycle: 
                <input type="date" name="date_debut_cycle" required>
            </label>
        </div>
        <div class="form-group">
            <label>Date Fin Cycle: 
                <input type="date" name="date_fin_cycle" required>
            </label>
        </div>
        <div class="form-group">
            <label>Nombre de Mâles: 
                <input type="number" name="nombre_males" required min="0">
            </label>
        </div>
        <div class="form-group">
            <label>Nombre de Femelles: 
                <input type="number" name="nombre_femelles" required min="0">
            </label>
        </div>
        <button type="submit">Ajouter</button>
    </form>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>