<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taches Employé</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .task-row { display: none; }
        .task-row.visible { display: table-row; }
        .date-filter { margin: 20px 0; }
        .actions { white-space: nowrap; }
    </style>
</head>
<body>
    <h1>Taches Employé</h1>
    <a href="<?= BASE_URL ?>/logout">Déconnexion</a>

    <div class="date-filter">
        <label for="task-date">Date des tâches:</label>
        <input type="date" id="task-date" value="<?= htmlspecialchars($selectedDate) ?>">
        <button id="today-btn">Aujourd'hui</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tâche</th>
                <th>Description</th>
                <th>Date d'échéance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="tasks-container">
            <?php if (!empty($tasks)) {
                foreach ($tasks as $task): ?>
                    <tr class="task-row" data-date="<?= htmlspecialchars($task['date_echeance']) ?>">
                        <td><?= htmlspecialchars($task['nom_tache']) ?></td>
                        <td><?= htmlspecialchars($task['description'] ?? '') ?></td>
                        <td><?= htmlspecialchars($task['date_echeance']) ?></td>
                        <td class="actions">
                            <form method="post" action="<?= BASE_URL ?>/taches/done" style="display: inline;">
                                <input type="hidden" name="taches_done[]" value="<?= $task['id_tache'] ?>">
                                <button type="submit">Confirmer</button>
                            </form>
                            
                            <?php if ($task['nom_tache'] === 'Peser les porcs'): ?>
                                <a href="<?= BASE_URL ?>/tache_peser" class="action-btn">Peser</a>
                            <?php elseif ($task['nom_tache'] === 'Nourrir les animaux'): ?>
                                <a href="<?= BASE_URL ?>/nourrir" class="action-btn">Nourrir</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; 
            } else { echo '<tr><td colspan="4">Aucune tâche disponible.</td></tr>'; } ?>
        </tbody>
    </table>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('task-date');
        const todayBtn = document.getElementById('today-btn');
        const taskRows = document.querySelectorAll('.task-row');
        
        function filterTasks() {
            const selectedDate = dateInput.value;
            taskRows.forEach(row => {
                if (row.dataset.date === selectedDate) {
                    row.classList.add('visible');
                } else {
                    row.classList.remove('visible');
                }
            });
        }
        
        function showToday() {
            dateInput.value = new Date().toISOString().split('T')[0];
            filterTasks();
        }
        
        dateInput.addEventListener('change', filterTasks);
        todayBtn.addEventListener('click', showToday);
        
        filterTasks();
    });
</script>
</body>
</html>