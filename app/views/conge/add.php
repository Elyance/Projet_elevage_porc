<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Gestion des Congés</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Ajouter un Congé</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- VOTRE CODE ORIGINAL COMMENCE ICI -->
                        <h1>Ajouter un Congé</h1>
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger">Erreur : Dates invalides. La date de fin doit être postérieure à la date de début.</div>
                        <?php endif; ?>
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success">Congé ajouté avec succès !</div>
                        <?php endif; ?>
                        
                        <form method="POST" action="<?=BASE_URL?>/conge/add">
                            <?php if ($selected_employe): ?>
                                <input type="hidden" name="id_employe" value="<?= htmlspecialchars($selected_employe) ?>">
                                <div class="form-group">
                                    <label>Employé: <?= htmlspecialchars(array_filter($employes, fn($e) => $e->id_employe == $selected_employe)[0]->nom_employe ?? 'Unknown') ?></label>
                                </div>
                            <?php else: ?>
                                <div class="form-group">
                                    <label>Employé:</label>
                                    <select name="id_employe" class="form-control" required>
                                        <?php foreach ($employes as $employe): ?>
                                            <option value="<?= htmlspecialchars($employe->id_employe) ?>" <?= $selected_employe == $employe->id_employe ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($employe->nom_employe ?? 'Unknown') ?> (ID: <?= $employe->id_employe ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                            
                            <div class="form-group">
                                <label>Date de Début:</label>
                                <input type="date" name="date_debut" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Date de Fin:</label>
                                <input type="date" name="date_fin" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Motif:</label>
                                <textarea name="motif" class="form-control" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </form>
                        <!-- VOTRE CODE ORIGINAL TERMINE ICI -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->