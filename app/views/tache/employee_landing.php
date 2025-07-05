<!-- app/views/tache/employee_landing.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Employé</title>
    <style>
        .calendar { display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; margin: 20px 0; }
        .day { border: 1px solid #ccc; padding: 10px; text-align: center; }
        .task { background-color: #f0f0f0; margin: 5px 0; padding: 5px; }
        .task .precision { font-style: italic; color: #666; }
    </style>
</head>
<body>
    <h1>Tableau de Bord - <?= htmlspecialchars($id_employe) ?></h1>
    <h2><?= date('F Y', mktime(0, 0, 0, $currentMonth, 1, $currentYear)) ?></h2>
    <div class="calendar">
        <?php
        $days = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
        for ($i = 0; $i < 7; $i++) {
            echo "<div class='day'>$days[$i]</div>";
        }
        foreach ($calendar as $cell) {
            echo "<div class='day'>";
            if ($cell['day']) {
                echo $cell['day'];
                foreach ($cell['tasks'] as $task) {
                    echo "<div class='task'>";
                    echo htmlspecialchars($task['nom_tache']);
                    if ($task['precision']) {
                        echo "<div class='precision'>" . htmlspecialchars($task['precision']) . "</div>";
                    }
                    echo "</div>";
                }
            }
            echo "</div>";
        }
        ?>
    </div>
    <a href="/taches/employe/<?= $id_employe ?>/done">Marquer les tâches comme accomplies</a>
</body>
</html>