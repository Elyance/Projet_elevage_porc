<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h4><?= isset($tache) ? 'Modifier' : 'Créer' ?> une tâche</h4>
            </div>
            
            <div class="basic-form">
                <form method="post" action="<?= BASE_URL ?>/tache/save">
                    <input type="hidden" name="id_tache" value="<?= isset($tache) ? $tache['id_tache'] : '' ?>">
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nom de la tâche:</label>
                        <div class="col-sm-9">
                            <input type="text" name="nom_tache" class="form-control" 
                                   value="<?= isset($tache) ? htmlspecialchars($tache['nom_tache']) : '' ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Pour rôle:</label>
                        <div class="col-sm-9">
                            <select name="id_employe_poste" class="form-control" required>
                                <?php foreach ($postes as $poste): ?>
                                    <option value="<?= $poste['id_employe_poste'] ?>" 
                                        <?= (isset($tache) && $tache['id_employe_poste'] == $poste['id_employe_poste']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($poste['nom_poste']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Description:</label>
                        <div class="col-sm-9">
                            <textarea name="description" class="form-control" rows="4" required><?= 
                                isset($tache) ? htmlspecialchars($tache['description']) : '' 
                            ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date d'attribution:</label>
                        <div class="col-sm-9">
                            <input type="date" name="date_attribution" class="form-control" 
                                   value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Soumettre</button>
                            <a href="<?= BASE_URL ?>/tache" class="btn btn-light">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>