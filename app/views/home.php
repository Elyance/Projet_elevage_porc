<!DOCTYPE html>
<html>
<head>
    <title>Gestion Porc</title>
    <style>
        .menu { display: flex; gap: 10px; }
        .menu a { text-decoration: none; color: blue; }
    </style>
</head>
<body>

    <div class="menu">
        <?php foreach ($links as $title => $url): ?>
            <a href="<?= $url ?>"><?= $title ?></a>
        <?php endforeach; ?>
    </div>
</body>
</html>