<div class="content-body">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center" style="font-size: 2rem; margin-bottom: 2rem;">LISTE INSÉMINATION</h4>
                        <form method="POST" class="form-basic">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right" style="font-size: 1.4rem;">Truie:</label>
                                <div class="col-sm-6">
                                    <select name="truie_id" class="form-control form-control-lg" required style="font-size: 1.4rem; height: calc(2.5em + 1rem + 2px);">
                                        <?php foreach ($truies as $truie): ?>
                                            <option value="<?= $truie->id_truie ?>" style="font-size: 1.4rem;">
                                                id: <?= htmlspecialchars($truie->id_truie) ?> (enclos <?= htmlspecialchars($truie->id_enclos) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right" style="font-size: 1.4rem;">Date:</label>
                                <div class="col-sm-6">
                                    <input type="date" name="date_insemination" class="form-control form-control-lg" required style="font-size: 1.4rem; height: calc(2.5em + 1rem + 2px);">
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
    .form-basic .form-control-lg {
        font-size: 1.4rem !important;
        padding: 1rem 1.5rem;
        height: calc(2.5em + 1rem + 2px);
    }
    .form-basic label {
        font-size: 1.4rem;
    }
    .card-title {
        font-size: 2rem;
        margin-bottom: 2rem;
    }
    .btn-lg {
        padding: 0.75rem 2rem;
        font-size: 1.4rem;
    }
    .table {
        font-size: 1.4rem;
    }
    .badge {
        font-size: 1.3rem;
        padding: 0.5rem 1rem;
    }
</style>