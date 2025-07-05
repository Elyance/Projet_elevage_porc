<!-- app/views/naissance/add.php -->
<h1>Ajouter une Naissance</h1>
<?php if ($error): ?>
    <p style="color: red;">Erreur : Données invalides.</p>
<?php endif; ?>
<form method="POST">
    <input type="hidden" name="cycle_id" value="<?= htmlspecialchars($cycle_id) ?>">
    <input type="hidden" name="truie_id" value="<?= htmlspecialchars($truie_id) ?>">
    <label>Date Naissance: <input type="date" name="date_naissance" value="<?= date('Y-m-d') ?>" required></label><br>
    <label>Enclos: 
        <select name="enclos_id" required>
            <?php foreach ($enclos as $e): ?>
                <option value="<?= $e->id_enclos ?>"><?= htmlspecialchars($e->stockage) ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Nombre de Femelles Nées: <input type="number" name="femelle_nait" required min="0"></label><br>
    <label>Nombre de Mâles Nés: <input type="number" name="male_nait" required min="0"></label><br>
    <button type="submit">Ajouter</button>
</form>

<script>
    const femelleInput = document.querySelector('input[name="femelle_nait"]');
    const maleInput = document.querySelector('input[name="male_nait"]');
    const totalInput = document.createElement('input');
    totalInput.type = 'number';
    totalInput.name = 'nombre_porcs';
    totalInput.readOnly = true;
    document.querySelector('form').appendChild(totalInput);

    [femelleInput, maleInput].forEach(input => {
        input.addEventListener('input', () => {
            const femelle = parseInt(femelleInput.value) || 0;
            const male = parseInt(maleInput.value) || 0;
            totalInput.value = femelle + male;
        });
    });
</script>