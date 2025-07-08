<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peser les porcs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Peser les porcs</h1>
    
    <?php
    // Vérification si un message d'erreur ou de succès est passé (via session ou GET)
    if (isset($_GET['message'])) {
        echo '<p class="text-green-600 mb-4">' . htmlspecialchars($_GET['message']) . '</p>';
    }
    if (isset($_GET['error'])) {
        echo '<p class="text-red-600 mb-4">' . htmlspecialchars($_GET['error']) . '</p>';
    }
    ?>

    <form method="post" action="/tache_peser_submit" class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="enclos_id" class="block text-sm font-medium text-gray-700">Enclos :</label>
            <select name="enclos_id" id="enclos_id" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="1">Enclos 1 (Truies)</option>
                <option value="2">Enclos 2 (Portées)</option>
                <!-- Ajoutez d'autres enclos dynamiquement via une requête SQL si besoin -->
            </select>
        </div>
        <div class="mb-4">
            <label for="weight" class="block text-sm font-medium text-gray-700">Poids (kg) :</label>
            <input type="number" name="weight" id="weight" min="1" max="200" step="0.1" required
                   class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                   placeholder="Entrez le poids">
        </div>
        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-700">Date :</label>
            <input type="date" name="date" id="date" value="<?= date('Y-m-d') ?>" required
                   class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Enregistrer</button>
    </form>
    <a href="/tache" class="mt-4 inline-block text-blue-500 hover:underline">Retour</a>
</body>
</html>