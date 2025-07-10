<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tâches</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Peser les porcs</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Peser les porcs</h4>
                        
                        <?php if (isset($_GET['message'])): ?>
                            <div class="alert alert-success"><?= htmlspecialchars($_GET['message']) ?></div>
                        <?php endif; ?>
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                        <?php endif; ?>

                        <div class="basic-form">
                            <form method="post" action="<?= BASE_URL ?>/tache_peser_submit">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Enclos</label>
                                    <div class="col-sm-9">
                                        <select name="enclos_id" class="form-control" required>
                                            <option value="1">Enclos 1 (Truies)</option>
                                            <option value="2">Enclos 2 (Portées)</option>
                                            <!-- Add more enclosures dynamically if needed -->
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Poids (kg)</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="weight" class="form-control" 
                                               min="1" max="200" step="0.1" required
                                               placeholder="Entrez le poids">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="date" class="form-control" 
                                               value="<?= date('Y-m-d') ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <a href="<?= BASE_URL ?>/histo_peser" class="btn btn-primary">Voir l'historique</a>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>