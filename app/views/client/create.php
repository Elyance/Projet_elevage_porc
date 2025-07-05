<h2>➕ Nouveau client</h2>
<form method="POST" action="/clients/store">
    Nom: <input name="nom_client" required><br>
    Type:
    <select name="type_profil">
        <option value="particulier">Particulier</option>
        <option value="entreprise">Entreprise</option>
    </select><br>
    Adresse: <input name="adresse"><br>
    Téléphone: <input name="contact_telephone"><br>
    Email: <input name="contact_email"><br>
    <button type="submit">Créer</button>
</form>
