<!-- app/views/naissance/add.php -->
<h1>Ajouter une Naissance</h1>
<?php if ($error): ?>
    <p style="color: red;">Erreur : Données invalides.</p>
<?php endif; ?>
<form method="POST" action="/naissance/add">
    <input type="hidden" name="cycle_id" value="<?= htmlspecialchars($cycle_id) ?>">
    <input type="hidden" name="truie_id" value="<?= htmlspecialchars($truie_id) ?>">
    <label>Date Naissance: <input type="date" name="date_naissance" value="<?= htmlspecialchars($date_naissance ?? date('Y-m-d')) ?>" required></label><br>
    <label>Race: 
        <select name="id_race" required>
            <?php foreach ($races as $race): ?>
                <option value="<?= htmlspecialchars($race->id_race) ?>"><?= htmlspecialchars($race->nom_race) ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Enclos: 
        <select name="enclos_id" required>
            <?php foreach ($enclos as $e): ?>
                <option value="<?= htmlspecialchars($e->id_enclos) ?>">ecnlos:<?= htmlspecialchars($e->id_enclos) ?> <?= htmlspecialchars($e->surface) ?> m²</option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Nombre de Femelles Nées: <input type="number" name="femelle_nait" required min="0"></label><br>
    <label>Nombre de Mâles Nés: <input type="number" name="male_nait" required min="0"></label><br>
    <label>Total (Affichage uniquement): <input type="number" id="total_display" readonly></label><br>
    <button type="submit">Ajouter</button>
</form>

<script>
    const femelleInput = document.querySelector('input[name="femelle_nait"]');
    const maleInput = document.querySelector('input[name="male_nait"]');
    const totalDisplay = document.getElementById('total_display');

    [femelleInput, maleInput].forEach(input => {
        input.addEventListener('input', () => {
            const femelle = parseInt(femelleInput.value) || 0;
            const male = parseInt(maleInput.value) || 0;
            totalDisplay.value = femelle + male;
        });
    });

    // Initialize total on page load
    window.addEventListener('load', () => {
        const femelle = parseInt(femelleInput.value) || 0;
        const male = parseInt(maleInput.value) || 0;
        totalDisplay.value = femelle + male;
    });
</script>