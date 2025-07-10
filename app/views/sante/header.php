<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="<?= STATIC_URL ?>/assets/css/sante-style.css    " rel="stylesheet">
    <style>
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .navbar-nav {
            padding: 0 15px;
            display: flex;
            flex-direction: row;
            align-items: center;
        }
        
        .nav-item {
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/diagnostic" class="nav-link">
                        <i class="fas fa-disease"></i> Gestion maladie
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/typeevenement" class="nav-link">
                        <i class="fas fa-list"></i> Liste type evenement
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/evenement/add" class="nav-link">
                        <i class="fas fa-plus"></i> Ajouter evenement
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/deces" class="nav-link">
                        <i class="fas fa-cross"></i> Gestion décès
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>/soin" class="nav-link">
                        <i class="fas fa-band-aid"></i> Soin
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">