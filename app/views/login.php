<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef1f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 300px;
        }
        .message {
            margin-bottom: 1rem;
            font-weight: bold;
            color: red; /* Tu peux changer la couleur selon le type de message */
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 0.6rem;
            margin: 0.5rem 0 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            width: 100%;
            padding: 0.6rem;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<div class="box">
    <h2>Connexion</h2>
    <div id="message" class="message">
        <!-- Message affiché ici (ex : erreur ou confirmation) -->
        <?php if (isset($message)) echo htmlspecialchars($message); ?>
    </div>
    <form method="post" action="login">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
</div>
</body>
</html>
