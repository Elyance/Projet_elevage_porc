<div class="content-body">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center" style="font-size: 2rem; margin-bottom: 2rem;">CYCLES ET PRÉDICTION</h4>
                        <form method="POST" class="form-basic">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right" style="font-size: 1.4rem;">Truie:</label>
                                <div class="col-sm-6">
                                    <select name="truie_id" class="form-control form-control-lg" required style="font-size: 1.4rem;">
                                        <?php foreach ($truies as $truie): ?>
                                            <option value="<?= htmlspecialchars($truie->id_truie) ?>" style="font-size: 1.4rem;">
                                                <?= htmlspecialchars($truie->poids) ?> kg
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right" style="font-size: 1.4rem;">Date Début Cycle:</label>
                                <div class="col-sm-6">
                                    <input type="date" name="date_debut_cycle" class="form-control form-control-lg" required style="font-size: 1.4rem;">
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right" style="font-size: 1.4rem;">Date Fin Cycle:</label>
                                <div class="col-sm-6">
                                    <input type="date" name="date_fin_cycle" class="form-control form-control-lg" required style="font-size: 1.4rem;">
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right" style="font-size: 1.4rem;">Nombre de Mâles:</label>
                                <div class="col-sm-6">
                                    <input type="number" name="nombre_males" class="form-control form-control-lg" required min="0" style="font-size: 1.4rem;">
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right" style="font-size: 1.4rem;">Nombre de Femelles:</label>
                                <div class="col-sm-6">
                                    <input type="number" name="nombre_femelles" class="form-control form-control-lg" required min="0" style="font-size: 1.4rem;">
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg" style="font-size: 1.4rem; padding: 0.75rem 2rem; min-width: 200px;">Ajouter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card {
    border-radius: 0.5rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-title {
    color: #4e73df;
    font-weight: 600;
}

.table th {
    font-size: 1.4rem;
    font-weight: 600;
    color: #4e73df;
}

.badge {
    padding: 0.5rem 1rem;
    font-size: 1.3rem;
    border-radius: 0.35rem;
}

.badge-success {
    background-color: #1cc88a;
}

.badge-primary {
    background-color: #4e73df;
}

.badge-secondary {
    background-color: #858796;
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.4rem;
    border-radius: 0.35rem;
}

.form-control-lg {
    font-size: 1.4rem;
    padding: 1rem 1.5rem;
    height: calc(2.5em + 1rem + 2px);
}

.section-title {
    border-bottom: 2px solid #f8f9fc;
    padding-bottom: 0.5rem;
}

.chart-container {
    position: relative;
    height: 300px;
}
</style>