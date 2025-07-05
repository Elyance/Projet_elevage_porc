<h2>✏️ Modifier client</h2>
<form method="POST" action="/clients/update/<?= $client['id_client'] ?>">
    Nom: <input name="nom_client" value="<?= htmlspecialchars($client['nom_client']) ?>"><br>
    Type:
    <select name="type_profil">
        <option value="particulier" <?= $client['type_profil'] === 'particulier' ? 'selected' : '' ?>>Particulier</option>
        <option value="entreprise" <?= $client['type_profil'] === 'entreprise' ? 'selected' : '' ?>>Entreprise</option>
    </select><br>
    Adresse: <input name="adresse" value="<?= $client['adresse'] ?>"><br>
    Téléphone: <input name="contact_telephone" value="<?= $client['contact_telephone'] ?>"><br>
    Email: <input name="contact_email" value="<?= $client['contact_email'] ?>"><br>
    <button type="submit">Mettre à jour</button>
</form>
