<?php // Assuming a header partial is included at the top of your page ?>
<?php // require_once __DIR__ . '/partials/header.php'; ?>

<style>
    /* These styles are taken from your example to ensure the look is identical */
    .form-basic .form-control-lg {
        font-size: 1.2rem !important; /* Slightly adjusted for better fit */
        padding: 0.75rem 1.25rem;
        height: calc(2.25em + 1.5rem + 2px); /* Adjusted height */
    }
    .form-basic .col-form-label {
        font-size: 1.2rem;
        font-weight: 500;
    }
    .card-title {
        font-size: 2rem;
        margin-bottom: 2.5rem; /* Increased margin for more space */
        font-weight: 600;
    }
    .btn-lg {
        padding: 0.75rem 2rem;
        font-size: 1.2rem;
        min-width: 200px;
    }
</style>

<div class="content-body">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Ajouter une Commande</h4>

                        <form method="post" action="<?= BASE_URL ?>/commande/add" class="form-basic">
                            <!-- Client -->
                            <div class="form-group row">
                                <label for="nomClient" class="col-sm-3 col-form-label text-right">Client :</label>
                                <div class="col-sm-7">
                                    <input type="text" id="nomClient" name="nomClient" class="form-control form-control-lg" placeholder="Nom du client" required>
                                </div>
                            </div>

                            <!-- Enclos -->
                            <div class="form-group row">
                                <label for="id_enclos_portee" class="col-sm-3 col-form-label text-right">Enclos Numéro :</label>
                                <div class="col-sm-7">
                                    <select name="id_enclos_portee" id="id_enclos_portee" class="form-control form-control-lg" required>
                                        <option value="" disabled selected>Sélectionnez un enclos</option>
                                        <?php foreach ($enclos_portees as $enclos_portee): ?>
                                            <option value="<?= $enclos_portee['id_enclos_portee'] ?>"><?= $enclos_portee['id_enclos_portee'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Race -->
                            <div class="form-group row">
                                <label for="id_race" class="col-sm-3 col-form-label text-right">Race :</label>
                                <div class="col-sm-7">
                                    <select name="id_race" id="id_race" class="form-control form-control-lg" required>
                                        <option value="" disabled selected>Sélectionnez une race</option>
                                        <?php foreach ($races as $race): ?>
                                            <option value="<?= $race['id_race'] ?>"><?= htmlspecialchars($race['nom_race']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Quantité -->
                             <div class="form-group row">
                                <label for="quantite" class="col-sm-3 col-form-label text-right">Quantité :</label>
                                <div class="col-sm-7">
                                    <input type="number" name="quantite" id="quantite" class="form-control form-control-lg" min="1" placeholder="ex: 5" required>
                                </div>
                            </div>

                            <!-- Date Commande -->
                            <div class="form-group row">
                                <label for="date_commande" class="col-sm-3 col-form-label text-right">Date Commande :</label>
                                <div class="col-sm-7">
                                    <input type="date" name="date_commande" id="date_commande" class="form-control form-control-lg" required>
                                </div>
                            </div>
                            
                            <!-- Adresse Livraison -->
                             <div class="form-group row">
                                <label for="adresse_livraison" class="col-sm-3 col-form-label text-right">Adresse Livraison :</label>
                                <div class="col-sm-7">
                                    <input type="text" name="adresse_livraison" id="adresse_livraison" class="form-control form-control-lg" placeholder="123 Rue de l'Exemple..." required>
                                </div>
                            </div>

                            <!-- Date Livraison -->
                             <div class="form-group row">
                                <label for="date_livraison" class="col-sm-3 col-form-label text-right">Date Livraison :</label>
                                <div class="col-sm-7">
                                    <input type="date" name="date_livraison" id="date_livraison" class="form-control form-control-lg">
                                </div>
                            </div>

                            <!-- Statut Livraison -->
                             <div class="form-group row">
                                <label for="statut_livraison" class="col-sm-3 col-form-label text-right">Statut Livraison :</label>
                                <div class="col-sm-7">
                                    <select name="statut_livraison" id="statut_livraison" class="form-control form-control-lg">
                                        <option value="en attente" selected>En attente</option>
                                        <option value="en cours">En cours</option>
                                        <option value="livre">Livré</option>
                                        <option value="annule">Annulé</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group row mt-5">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">Ajouter la Commande</button>
                                    <a href="<?= BASE_URL?>/commande/list" class="btn btn-secondary btn-lg ml-3">Voir la liste</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php // Assuming a footer partial is included at the bottom of your page ?>
<?php // require_once __DIR__ . '/partials/footer.php'; ?>