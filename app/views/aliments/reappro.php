<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="card">
    <div class="card-header bg-warning text-dark">
        <h2>🔄 Réapprovisionner un Aliment</h2>
    </div>
    <?php if (isset($message)): ?>
        <div class="alert alert-<?= $message['type'] ?>">
            <?= $message['text']; ?>
        </div>
    <?php endif; ?>
    <div class="card-body">
        <form id="form-reappro" action="/aliments/reappro/action" method="POST">
            <div class="mb-3">
                <label for="id_aliment" class="form-label">Aliment</label>
                <select class="form-select" id="id_aliment" name="id_aliment" required>
                    <option value="">-- Sélectionnez un aliment --</option>
                    <?php foreach ($aliments as $aliment): ?>
                        <option 
                            value="<?= $aliment['id_aliment'] ?>" 
                            data-prix="<?= $aliment['prix_kg'] ?>"
                        >
                            <?= htmlspecialchars($aliment['nom_aliment']) ?> 
                            (Prix: <?= number_format($aliment['prix_kg'], 2) ?> MGA/kg)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="quantite_kg" class="form-label">Quantité à commander (kg)</label>
                <input 
                    type="number" 
                    class="form-control" 
                    id="quantite_kg" 
                    name="quantite_kg" 
                    step="0.01" 
                    min="0.1" 
                    required
                >
            </div>

            <div class="mb-3">
                <label for="cout_total" class="form-label">Coût total estimé</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="cout_total" 
                    readonly
                    value="0.00 MGA"
                >
            </div>

            <button type="submit" class="btn btn-primary">
                💾 Enregistrer le réapprovisionnement
            </button>
        </form>
    </div>
</div>

<script>
    // Calcule le coût total en temps réel
    document.getElementById('id_aliment').addEventListener('change', updateCoutTotal);
    document.getElementById('quantite_kg').addEventListener('input', updateCoutTotal);

    function updateCoutTotal() {
        const alimentSelect = document.getElementById('id_aliment');
        const selectedOption = alimentSelect.options[alimentSelect.selectedIndex];
        const prixKg = parseFloat(selectedOption.getAttribute('data-prix')) || 0;
        const quantite = parseFloat(document.getElementById('quantite_kg').value) || 0;
        const coutTotal = (prixKg * quantite).toFixed(2);

        document.getElementById('cout_total').value = coutTotal + ' MGA';
    }
</script>