```php
<?php require_once __DIR__ . '/partials/header.php'; ?>
<div class="card">
    <h1 style="font-size: 1.5rem; margin-bottom: 1rem;">Ajouter une Naissance</h1>
    <?php if ($error): ?>
        <p style="color: var(--accent1);">Erreur : Données invalides.</p>
    <?php endif; ?>
    <form method="POST" action="/naissance/add">
        <input type="hidden" name="cycle_id" value="<?= htmlspecialchars($cycle_id) ?>">
        <input type="hidden" name="truie_id" value="<?= htmlspecialchars($truie_id) ?>">
        <div class="form-group">
            <label>Date Naissance: 
                <input type="date" name="date_naissance" value="<?= htmlspecialchars($date_naissance ?? date('Y-m-d')) ?>" required>
            </label>
        </div>
        <div class="form-group">
            <label>Race: 
                <select name="id_race" required>
                    <?php foreach ($races as $race): ?>
                        <option value="<?= htmlspecialchars($race->id_race) ?>"><?= htmlspecialchars($race->nom_race) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="form-group">
            <label>Enclos: 
                <select name="enclos_id" required>
                    <?php foreach ($enclos as $e): ?>
                        <option value="<?= htmlspecialchars($e->id_enclos) ?>">Enclos: <?= htmlspecialchars($e->id_enclos) ?> <?= htmlspecialchars($e->surface) ?> m²</option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="form-group">
            <label>Nombre de Femelles Nées: 
                <input type="number" name="femelle_nait" required min="0">
            </label>
        </div>
        <div class="form-group">
            <label>Nombre de Mâles Nés: 
                <input type="number" name="male_nait" required min="0">
            </label>
        </div>
        <div class="form-group">
            <label>Total (Affichage uniquement): 
                <input type="number" id="total_display" readonly>
            </label>
        </div>
        <button type="submit">Ajouter</button>
    </form>
</div>
<script>
    const femelleInput = document.querySelector('input[name="femelle_nait"]');
    const maleInput = document.querySelector('input[name="male_nait"]');
    const totalDisplay = document.getElementById("total_display");

    [femelleInput, maleInput].forEach(input => {
        input.addEventListener("input", () => {
            const femelle = parseInt(femelleInput.value) || 0;
            const male = parseInt(maleInput.value) || 0;
            totalDisplay.value = femelle + male;
        });
    });

    // Initialize total on page load
    window.addEventListener("load", () => {
        const femelle = parseInt(femelleInput.value) || 0;
        const male = parseInt(maleInput.value) || 0;
        totalDisplay.value = femelle + male;
    });
</script>
<?php require_once __DIR__ . '/partials/footer.php'; ?>