<!-- app/views/conge/add.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Congé</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .error { color: red; }
        .success { color: green; }
        label { display: block; margin: 10px 0 5px; }
        input, select, textarea { width: 100%; max-width: 300px; padding: 5px; }
        button { margin-top: 10px; padding: 5px 10px; }
    </style>
</head>
<body>
    <h1>Ajouter un Congé</h1>
    <?php if (isset($_GET['error'])): ?>
        <p class="error">Erreur : Dates invalides. La date de fin doit être postérieure à la date de début.</p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p class="success">Congé ajouté avec succès !</p>
    <?php endif; ?>
    <form method="POST" action="/conge/add">
        <?php if ($selected_employe): ?>
            <input type="hidden" name="id_employe" value="<?= htmlspecialchars($selected_employe) ?>">
            <label>Employé: <?= htmlspecialchars(array_filter($employes, fn($e) => $e->id_employe == $selected_employe)[0]->nom_employe ?? 'Unknown') ?></label>
        <?php else: ?>
            <label>Employé:
                <select name="id_employe" required>
                    <?php foreach ($employes as $employe): ?>
                        <option value="<?= htmlspecialchars($employe->id_employe) ?>" <?= $selected_employe == $employe->id_employe ? 'selected' : '' ?>>
                            <?= htmlspecialchars($employe->nom_employe ?? 'Unknown') ?> (ID: <?= $employe->id_employe ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        <?php endif; ?>
        <label>Date de Début: <input type="date" name="date_debut" required></label>
        <label>Date de Fin: <input type="date" name="date_fin" required></label>
        <label>Motif: <textarea name="motif" required></textarea></label>
        <button type="submit">Valider</button>
    </form>
</body>
</html>