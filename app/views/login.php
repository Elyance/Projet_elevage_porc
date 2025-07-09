<!DOCTYPE html>
<html class="h-100" lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Connexion</title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= STATIC_URL ?>/assets/images/favicon.png">
    <link href="<?= STATIC_URL ?>/assets/css/style.css" rel="stylesheet">
    <link href="<?= STATIC_URL ?>/assets/css/login-style.css" rel="stylesheet">
</head>
<body class="h-100">
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="#"><h4>Connexion</h4></a>
        
                                <!-- Message display -->
                                <?php if (isset($message)): ?>
                                    <div class="alert alert-<?= strpos($message, 'erreur') !== false ? 'danger' : 'success' ?> mt-3">
                                        <?= htmlspecialchars($message) ?>
                                    </div>
                                <?php endif; ?>

                                <form method="post" action="login" class="mt-4 mb-4 login-input">
                                    <div class="form-group">
                                        <label for="username">Nom d'utilisateur</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="username" name="username" 
                                                   placeholder="Entrez votre nom d'utilisateur" value="admin" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="password">Mot de passe</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" 
                                                   placeholder="Entrez votre mot de passe" value="admin" required>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn login-form__btn submit w-100 mt-4">
                                        Se connecter
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="<?= STATIC_URL ?>/plugins/common/common.min.js"></script>
<script src="<?= STATIC_URL ?>/js/custom.min.js"></script>
<script src="<?= STATIC_URL ?>/js/settings.js"></script>
<script src="<?= STATIC_URL ?>/js/gleek.js"></script>
<script src="<?= STATIC_URL ?>/js/styleSwitcher.js"></script>
</body>
</html>