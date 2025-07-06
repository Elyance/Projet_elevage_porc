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
        .today-tasks { margin: 20px 0; padding: 10px; border: 1px solid #ccc; }
        .today-tasks a { margin-right: 10px; }
    </style>
</head>
<body>
    <h1>Tableau de Bord - <?= htmlspecialchars($id_employe) ?></h1>
    <h2><?= date('F Y', mktime(0, 0, 0, $currentMonth, 1, $currentYear)) ?></h2>

    <!-- Today's Tasks Interface -->
    <div class="today-tasks">
    <h3>Tâches d'Aujourd'hui (<?= date('Y-m-d') ?>)</h3>
    <?php
    $today = date('Y-m-d'); // 2025-07-06 at 07:55 AM EAT
    // Debug output for tasks and today's date
    $taskCount = count($tasks ?? []);
    $dateEcheances = $tasks ? array_column($tasks, 'date_echeance') : [];

    // Filter tasks for today
    $todayTasks = array_filter($tasks ?? [], fn($t) => $t['date_echeance'] == $today);

    if (false) {
        echo "<p>Aucune tâche prévue aujourd'hui.</p>";
    }else {
            foreach ($todayTasks as $task) {
                $href = '/checkbox'; // Default href
                switch ($task['nom_tache']) {
                    case 'Peser les porcs':
                        $href = '/tache_peser';
                        break;
                    // Add more cases as needed
                    case 'Nourrir les animaux':
                        $href = '/nourrir';
                        break;
                    case 'Nettoyer les enclos':
                        $href = '/nettoyer';
                        break;
                    // Add additional cases for other tasks with specific routes
                }
                echo "<a href='" . htmlspecialchars($href) . "'>" . htmlspecialchars($task['nom_tache']) . "</a>";
                if ($task['precision']) {
                    echo " <span class='precision'>" . htmlspecialchars($task['precision']) . "</span>";
                }
                echo "<br>";
            }
        }
        ?>
    </div>

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
                    $href = '#'; // Default href
                    switch ($task['nom_tache']) {
                        case 'Peser les porcs':
                            $href = '/tache_peser';
                            break;
                        case 'Nourrir les animaux':
                            $href = '/nourrir';
                            break;
                        case 'Nettoyer les enclos':
                            $href = '/nettoyer';
                            break;
                        // Add additional cases for other tasks with specific routes
                    }
                    echo "<div class='task'>";
                    echo "<a href='" . htmlspecialchars($href) . "'>" . htmlspecialchars($task['nom_tache']) . "</a>";
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
</body>
</html>