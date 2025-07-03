<?php require_once __DIR__ . '../app/views/aliments/partials/header.php'; ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h2>🍽️ Nourrir les Porcs</h2>
    </div>
    <div class="card-body">
        <form id="form-nourrir" action="/nourrir/action" method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="id_race" class="form-label">Race de porc</label>
                    <select class="form-select" id="id_race" name="id_race" required>
                        <option value="">-- Sélectionnez une race --</option>
                        <?php foreach ($races as $race): ?>
                            <option value="<?= $race['id_race'] ?>">
                                <?= htmlspecialchars($race['nom_race']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="id_aliment" class="form-label">Aliment</label>
                    <select class="form-select" id="id_aliment" name="id_aliment" required>
                        <option value="">-- Sélectionnez un aliment --</option>
                        <?php foreach ($aliments as $aliment): ?>
                            <option 
                                value="<?= $aliment['id_aliment'] ?>" 
                                data-stock="<?= $aliment['stock_kg'] ?>"
                            >
                                <?= htmlspecialchars($aliment['nom_aliment']) ?> 
                                (Stock: <?= number_format($aliment['stock_kg'], 2) ?> kg)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="quantite_kg" class="form-label">Quantité totale (kg)</label>
                <input 
                    type="number" 
                    class="form-control" 
                    id="quantite_kg" 
                    name="quantite_kg" 
                    step="0.01" 
                    min="0.1" 
                    required
                >
                <div class="form-text" id="stock-disponible">
                    Stock disponible: <span class="fw-bold">0</span> kg
                </div>
            </div>

            <button type="submit" class="btn btn-success">
                ✅ Enregistrer le nourrissage
            </button>
        </form>
    </div>
</div>

<script>
    // Affiche le stock disponible quand on sélectionne un aliment
    document.getElementById('id_aliment').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const stock = selectedOption.getAttribute('data-stock') || 0;
        document.querySelector('#stock-disponible span').textContent = stock;
    });

    // Validation avant soumission
    document.getElementById('form-nourrir').addEventListener('submit', function(e) {
        const quantite = parseFloat(document.getElementById('quantite_kg').value);
        const stock = parseFloat(
            document.querySelector('#stock-disponible span').textContent
        );

        if (quantite > stock) {
            e.preventDefault();
            alert('❌ La quantité demandée dépasse le stock disponible !');
        }
    });
</script>

<?php require_once __DIR__ . '../app/views/aliments/partials/footer.php'; ?>