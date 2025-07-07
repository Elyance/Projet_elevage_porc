<h2>Ajouter une commande</h2>
<form method="post" action="/commande/add">
    <div>
        <label for="nomClient">Client</label>
        <input type="text" name="nomClient" placeholder="Entrez le nom du client">
    </div>

    <div>
        <label for="id_enclos_portee">Enclos Numéro :</label>
        <select name="id_enclos_portee" id="id_enclos_portee">
            <?php foreach ($enclos_portees as $enclos_portee): ?>
                <option value="<?= $enclos_portee['id_enclos_portee'] ?>"><?= $enclos_portee['id_enclos_portee'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="id_race">Race :</label>
        <select name="id_race" id="id_race" required>
            <?php foreach ($races as $race): ?>
                <option value="<?= $race['id_race'] ?>"><?= htmlspecialchars($race['nom_race']) ?></option>
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
        <label for="statut_livraison">Statut Livraison</label>
        <select name="statut_livraison" id="statut_livraison">
            <option value="en attente">En attente</option>
            <option value="en cours">En cours</option>
            <option value="livre">Livré</option>
            <option value="annule">Annulé</option>
        </select>
    </div>

    <button type="submit">Ajouter</button>
</form>
