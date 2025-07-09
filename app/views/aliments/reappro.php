<?php require_once __DIR__ . '/partials/header.php'; ?>

<style>
    .centered-card {
        max-width: 800px;
        margin: 0 auto;
    }
    .compact-form .form-group {
        margin-bottom: 1rem;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-8 centered-card">
        <div class="card">
            <div class="card-body compact-form">
                <h4 class="card-title">Réapprovisionner un Aliment</h4>
                
                <?php if (isset($message)): ?>
                    <div class="alert alert-<?= ($message['type']) ?> alert-dismissible fade show">
                        <?= ($message['text']); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                
                <form id="form-reappro" action="<?= BASE_URL?>/aliments/reappro/action" method="POST">
                    <div class="form-group">
                        <label>Aliment</label>
                        <select class="form-control" id="id_aliment" name="id_aliment" required>
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

                    <div class="form-group">
                        <label>Quantité à commander (kg)</label>
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

                    <div class="form-group">
                        <label>Coût total estimé</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="cout_total" 
                            readonly
                            value="0.00 MGA"
                        >
                    </div>

                    <div class="form-group text-center mt-4"> <!-- Added text-center and mt-4 -->
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>