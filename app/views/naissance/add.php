<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h4>Ajouter une Naissance</h4>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    Erreur : Données invalides.
                </div>
            <?php endif; ?>
            
            <div class="basic-form">
                <form method="POST" action="<?= BASE_URL ?>/naissance/add">
                    <input type="hidden" name="cycle_id" value="<?= ($cycle_id) ?>">
                    <input type="hidden" name="truie_id" value="<?= ($truie_id) ?>">
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date Naissance:</label>
                        <div class="col-sm-6">
                            <input type="date" name="date_naissance" class="form-control" 
                                   value="<?= ($date_naissance ?? date('Y-m-d')) ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Race:</label>
                        <div class="col-sm-6">
                            <select name="id_race" class="form-control" required>
                                <?php foreach ($races as $race): ?>
                                    <option value="<?= ($race->id_race) ?>">
                                        <?= ($race->nom_race) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Enclos:</label>
                        <div class="col-sm-6">
                            <select name="enclos_id" class="form-control" required>
                                <?php foreach ($enclos as $e): ?>
                                    <option value="<?= ($e->id_enclos) ?>">
                                        Enclos <?= ($e->id_enclos) ?> (<?= ($e->surface) ?> m²)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre de Femelles Nées:</label>
                        <div class="col-sm-6">
                            <input type="number" name="femelle_nait" class="form-control" required min="0">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre de Mâles Nés:</label>
                        <div class="col-sm-6">
                            <input type="number" name="male_nait" class="form-control" required min="0">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Total (Affichage uniquement):</label>
                        <div class="col-sm-6">
                            <input type="number" id="total_display" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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