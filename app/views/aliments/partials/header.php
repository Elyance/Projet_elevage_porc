<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                    <a class="nav-link" href="<?= BASE_URL?>/aliments"><i class="fas fa-list  me-1"></i> Liste aliments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL?>/aliments/nourrir"><i class="fas fa-utensils me-1"></i> Nourrir animaux</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL?>/aliments/reappro"><i class="fas fa-truck me-1"></i> Réapprovisionner</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">