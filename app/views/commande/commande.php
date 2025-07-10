<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Ajouter une commande</h4>
                </div>

                <div class="basic-form">
                    <form method="post" action="<?= BASE_URL?>/commande/add">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Client</label>
                            <!-- <div class="col-sm-10">
                                <input type="text" class="form-control" name="nomClient" placeholder="Entrez le nom du client" required>
                            </div> -->
                            <div class="col-sm-10">
                                <select name="id_client" id="id_client" class="form-control" required>
                                    <?php foreach ($clients as $client): ?>
                                        <option value="<?= $client['id_client'] ?>"><?= $client['nom_client'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Enclos Numéro</label>
                            <div class="col-sm-10">
                                <select name="id_enclos_portee" id="id_enclos_portee" class="form-control" required>
                                    <?php foreach ($enclos_portees as $enclos_portee): ?>
                                        <option value="<?= $enclos_portee['id_enclos_portee'] ?>"><?= $enclos_portee['id_enclos_portee'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Race</label>
                            <div class="col-sm-10">
                                <select name="id_race" id="id_race" class="form-control" required>
                                    <?php foreach ($races as $race): ?>
                                        <option value="<?= $race['id_race'] ?>"><?= htmlspecialchars($race['nom_race']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Quantité</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="quantite" id="quantite" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Date Commande</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="date_commande" id="date_commande" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Adresse Livraison</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="adresse_livraison" id="adresse_livraison" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Date Livraison</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="date_livraison" id="date_livraison">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Statut Livraison</label>
                            <div class="col-sm-10">
                                <select name="statut_livraison" id="statut_livraison" class="form-control">
                                    <option value="en attente">En attente</option>
                                    <option value="en cours">En cours</option>
                                    <option value="livre">Livré</option>
                                    <option value="annule">Annulé</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                                <a href="<?= BASE_URL?>/commande/list" class="btn btn-secondary">Voir les commandes</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>