<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taches Employé</title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= STATIC_URL ?>/assets/images/favicon.png">
    <link href="<?= STATIC_URL ?>/assets/plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= STATIC_URL ?>/assets/plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="<?= STATIC_URL ?>/assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <link href="<?= STATIC_URL ?>/assets/css/style.css" rel="stylesheet">
    <link href="<?= STATIC_URL ?>/assets/css/employee-task-style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h4>Taches Employé</h4>
                    <a href="<?= BASE_URL ?>/logout" class="logout-link">Déconnexion</a>
                    <div class="clearfix"></div>
                </div>

                <div class="example">
                    <div class="date-filter">
                        <label for="task-date">Date des tâches:</label>
                        <div class="input-group">
                            <input type="date" id="task-date" class="form-control" value="<?= htmlspecialchars($selectedDate) ?>">
                            <span class="input-group-append">
                                <span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span>
                            </span>
                        </div>
                        <button id="today-btn" class="btn btn-primary">Aujourd'hui</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tâche</th>
                                <th>Description</th>
                                <th>Date d'échéance</th>
                                <th>Status</th>
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
                                        <td>
                                            <?php if ($task['statut'] === 'en cours'): ?>
                                                <span class="badge badge-warning px-2">En cours</span>
                                            <?php elseif ($task['statut'] === 'terminee'): ?>
                                                <span class="badge badge-success px-2">Terminé</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="actions">
                                            <?php if ($task['statut'] === 'en cours'): ?>
                                                <form method="post" action="<?= BASE_URL ?>/tache/done" style="display: inline;">
                                                    <input type="hidden" name="taches_done[]" value="<?= $task['id_tache'] ?>">
                                                    <button type="submit">Terminer</button>
                                                </form>
                                                <?php if ($task['nom_tache'] === 'Peser les porcs'): ?>
                                                    <a href="<?= BASE_URL ?>/tache_peser" class="action-btn">Peser</a>
                                                <?php elseif ($task['nom_tache'] === 'Nourrir les animaux'): ?>
                                                    <a href="<?= BASE_URL ?>/nourrir" class="action-btn">Nourrir</a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; 
                            } else { echo '<tr><td style="text-align:center;" colspan="5">Aucune tâche disponible.</td></tr>'; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<script src="<?= STATIC_URL ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?= STATIC_URL ?>/assets/plugins/common/common.min.js"></script>
<script src="<?= STATIC_URL ?>/assets/js/custom.min.js"></script>
<script src="<?= STATIC_URL ?>/assets/js/settings.js"></script>
<script src="<?= STATIC_URL ?>/assets/js/gleek.js"></script>
<script src="<?= STATIC_URL ?>/assets/js/styleSwitcher.js"></script>

<!-- Chartjs -->
<script src="<?= STATIC_URL ?>/assets/plugins/chart.js/Chart.bundle.min.js"></script>
<!-- Circle progress -->
<script src="<?= STATIC_URL ?>/assets/plugins/circle-progress/circle-progress.min.js"></script>
<!-- Datamap -->
<script src="<?= STATIC_URL ?>/assets/plugins/d3v3/index.js"></script>
<script src="<?= STATIC_URL ?>/assets/plugins/topojson/topojson.min.js"></script>
<script src="<?= STATIC_URL ?>/assets/plugins/datamaps/datamaps.world.min.js"></script>
<!-- Morrisjs -->
<script src="<?= STATIC_URL ?>/assets/plugins/raphael/raphael.min.js"></script>
<script src="<?= STATIC_URL ?>/assets/plugins/morris/morris.min.js"></script>
<!-- Pignose Calender -->
<script src="<?= STATIC_URL ?>/assets/plugins/moment/moment.min.js"></script>
<script src="<?= STATIC_URL ?>/assets/plugins/pg-calendar/js/pignose.calendar.min.js"></script>
<!-- ChartistJS -->
<script src="<?= STATIC_URL ?>/assets/plugins/chartist/js/chartist.min.js"></script>
<script src="<?= STATIC_URL ?>/assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>

<script src="<?= STATIC_URL ?>/assets/js/dashboard/dashboard-1.js"></script>
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