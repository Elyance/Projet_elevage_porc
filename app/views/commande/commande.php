<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Ajouter une commande</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Formulaire d'ajout -->
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Ajouter une commande</h4>
                        <form method="post" action="/commande/add">
                            <div class="form-group">
                                <label for="nomClient">Client</label>
                                <input type="text" class="form-control" name="nomClient" id="nomClient" placeholder="Entrez le nom du client">
                            </div>

                            <div class="form-group">
                                <label for="id_enclos_portee">Enclos Numéro</label>
                                <select class="form-control" name="id_enclos_portee" id="id_enclos_portee">
                                    <?php foreach ($enclos_portees as $enclos_portee): ?>
                                        <option value="<?= $enclos_portee['id_enclos_portee'] ?>">
                                            <?= $enclos_portee['id_enclos_portee'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_race">Race</label>
                                <select class="form-control" name="id_race" id="id_race" required>
                                    <?php foreach ($races as $race): ?>
                                        <option value="<?= $race['id_race'] ?>">
                                            <?= htmlspecialchars($race['nom_race']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="quantite">Quantité</label>
                                <input type="number" class="form-control" name="quantite" id="quantite" required>
                            </div>

                            <div class="form-group">
                                <label for="date_commande">Date Commande</label>
                                <input type="date" class="form-control" name="date_commande" id="date_commande" required>
                            </div>

                            <div class="form-group">
                                <label for="adresse_livraison">Adresse Livraison</label>
                                <input type="text" class="form-control" name="adresse_livraison" id="adresse_livraison" required>
                            </div>

                            <div class="form-group">
                                <label for="date_livraison">Date Livraison</label>
                                <input type="date" class="form-control" name="date_livraison" id="date_livraison">
                            </div>

                            <div class="form-group">
                                <label for="statut_livraison">Statut Livraison</label>
                                <select class="form-control" name="statut_livraison" id="statut_livraison">
                                    <option value="en attente">En attente</option>
                                    <option value="en cours">En cours</option>
                                    <option value="livre">Livré</option>
                                    <option value="annule">Annulé</option>
                                </select>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success">✅ Ajouter la commande</button>
                                <a href="/commande/list" class="btn btn-secondary ml-2">📄 Voir les commandes</a>
                            </div>
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
