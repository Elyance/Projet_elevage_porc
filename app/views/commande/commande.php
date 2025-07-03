<h2>Ajouter une commande</h2>
<form method="post">
    <div>
        <label for="id_client">Client</label>
        <select name="id_client" id="id_client">
            <?php foreach ($clients as $client): ?>
                <option value="<?= $client['id_client'] ?>"><?= $client['nom_client'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="id_enclos_portee">Enclos Portee</label>
        <select name="id_enclos_portee" id="id_enclos_portee">
            <?php foreach ($enclos_portees as $enclos_portee): ?>
                <option value="<?= $enclos_portee['id_enclos_portee'] ?>"><?= $enclos_portee['id_enclos_portee'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="quantite">Quantité</label>
        <input type="number" name="quantite" id="quantite" required>
    </div>
    <div>
        <label for="date_commande">Date Commande</label>
        <input type="date" name="date_commande" id="date_commande" required>
    </div>
    <div>
        <label for="adresse_livraison">Adresse Livraison</label>
        <input type="text" name="adresse_livraison" id="adresse_livraison" required>
    </div>
    <div>
        <label for="date_livraison">Date Livraison</label>
        <input type="date" name="date_livraison" id="date_livraison">
    </div>
    <div>
        <!-- Mbola exemple ana statut ireto -->
        <label for="statut_livraison">Statut Livraison</label>
        <select name="statut_livraison" id="statut_livraison">
            <option value="en attente">En attente</option>
            <option value="en cours">En cours</option>
            <option value="livré">Livré</option>
            <option value="annule">Annulé</option>
        </select>
    </div>
    <button type="submit">Ajouter</button>
</form>