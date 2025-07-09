<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Gestion des Tâches</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= isset($tache) ? 'Modifier' : 'Créer' ?> une tâche</a></li>
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
                        <h2><?= isset($tache) ? 'Modifier' : 'Créer' ?> une tâche</h2>
                        <form method="post" action="<?=BASE_URL?>/tache/save">
                            <input type="hidden" name="id_tache" value="<?= isset($tache) ? $tache['id_tache'] : '' ?>">
                            <label>Nom de la tâche :</label>
                            <input type="text" name="nom_tache" value="<?= isset($tache) ? htmlspecialchars($tache['nom_tache']) : '' ?>" required><br>
                            <label>Pour rôle :</label>
                            <select name="id_employe_poste" required>
                                <?php foreach ($postes as $poste): ?>
                                    <option value="<?= $poste['id_employe_poste'] ?>" <?= (isset($tache) && $tache['id_employe_poste'] == $poste['id_employe_poste']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($poste['nom_poste']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select><br>
                            <label>Description :</label><br>
                            <textarea name="description" required><?= isset($tache) ? htmlspecialchars($tache['description']) : '' ?></textarea><br>
                            <label>Date d'attribution :</label>
                            <button type="submit">Soumettre</button>
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
</form>