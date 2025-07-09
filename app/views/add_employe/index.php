<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Gestion des Employés</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Ajouter un Employé</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ajouter un nouvel employé</h4>
                        
                        <!-- Votre formulaire original avec classes Bootstrap -->
                        <form method="post" action="">
                            <div class="form-group">
                                <label>Nom :</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Prénom :</label>
                                <input type="text" name="prenom" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Poste :</label>
                                <select name="poste" class="form-control" required>
                                    <option value="">-- Sélectionner un poste --</option>
                                    <?php foreach ($postes as $poste): ?>
                                        <option value="<?= $poste['id_employe_poste'] ?>">
                                            <?= htmlspecialchars($poste['nom_poste']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Adresse :</label>
                                <input type="text" name="adresse" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label>Téléphone :</label>
                                <input type="text" name="telephone" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label>Date de recrutement :</label>
                                <input type="date" name="date_recrutement" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Statut :</label>
                                <select name="statut" class="form-control" required>
                                    <option value="actif">Actif</option>
                                    <option value="retraiter">Retraité</option>
                                    <option value="congedier">Congédié</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->