<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h4>LISTE INSÉMINATION</h4>
            </div>
            <div class="basic-form">
                <form method="POST">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Truie:</label>
                        <div class="col-sm-6">
                            <select name="truie_id" class="form-control" required>
                                <?php foreach ($truies as $truie): ?>
                                    <option value="<?= $truie->id_truie ?>">
                                        id: <?= htmlspecialchars($truie->id_truie) ?> (enclos <?= htmlspecialchars($truie->id_enclos) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date:</label>
                        <div class="col-sm-6">
                            <input type="date" name="date_insemination" class="form-control" required>
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