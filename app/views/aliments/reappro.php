<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Réapprovisionner un Aliment</h4>
                
                <?php if (isset($message)): ?>
                    <div class="alert alert-<?= $message['type'] ?> alert-dismissible fade show">
                        <?= $message['text']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                
                <div class="basic-form">
                    <form id="form-reappro" action="/aliments/reappro/action" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
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
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Quantité à commander (kg)</label>
                                <input 
                                    type="number" 
                                    class="form-control input-default" 
                                    id="quantite_kg" 
                                    name="quantite_kg" 
                                    step="0.01" 
                                    min="0.1" 
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Coût total estimé</label>
                                <input 
                                    type="text" 
                                    class="form-control input-default" 
                                    id="cout_total" 
                                    readonly
                                    value="0.00 MGA"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Enregistrer le réapprovisionnement
                            </button>
                        </div>
                    </form>
                </div>
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