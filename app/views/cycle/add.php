<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h4>CYCLES ET PRÉDICTION</h4>
            </div>
            <div class="basic-form">
                <form method="POST">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Truie:</label>
                        <div class="col-sm-6">
                            <select name="truie_id" class="form-control" required>
                                <?php foreach ($truies as $truie): ?>
                                    <option value="<?= htmlspecialchars($truie->id_truie) ?>">
                                        <?= htmlspecialchars($truie->poids) ?> kg
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date Début Cycle:</label>
                        <div class="col-sm-6">
                            <input type="date" name="date_debut_cycle" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date Fin Cycle:</label>
                        <div class="col-sm-6">
                            <input type="date" name="date_fin_cycle" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre de Mâles:</label>
                        <div class="col-sm-6">
                            <input type="number" name="nombre_males" class="form-control" required min="0">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre de Femelles:</label>
                        <div class="col-sm-6">
                            <input type="number" name="nombre_femelles" class="form-control" required min="0">
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