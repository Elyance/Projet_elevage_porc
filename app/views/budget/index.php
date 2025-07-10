<?php
    $moisNoms = [
        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
        5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
        9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
    ];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link rel="stylesheet" href="<?= STATIC_URL ?>/assets/css/budget-index-style.css">
</head>
<body>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL?>/">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Budget</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">

        <!-- Formulaire de filtre -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="get" action="<?= BASE_URL?>/budget/index">
                            <div class="form-group">
                                <label for="annee"><i class="fas fa-calendar-alt mr-2"></i>Filtrer par année</label>
                                <input type="number" class="form-control" name="annee" id="annee"
                                       value="<?= htmlspecialchars($annee) ?>"
                                       min="2000" max="<?= date('Y') ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search mr-2"></i>Filtrer
                            </button>
                            <a href="/budget/index" class="btn btn-secondary ml-2">
                                <i class="fas fa-redo mr-2"></i>Réinitialiser
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="stats-grid">
            <?php if (!empty($budgetParAn)): ?>
                <?php $budget = $budgetParAn[0]; ?>
                <div class="stat-card">
                    <div class="stat-value"><?= number_format($budget['total_recette'], 0, ',', ' ') ?></div>
                    <div class="stat-label">Recettes Totales (Ar)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?= number_format($budget['total_depense'], 0, ',', ' ') ?></div>
                    <div class="stat-label">Dépenses Totales (Ar)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?= number_format($budget['budget'], 0, ',', ' ') ?></div>
                    <div class="stat-label">Budget Net (Ar)</div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Budget mensuel -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title"><i class="fas fa-calendar-alt mr-2"></i>Budget Mensuel</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Année</th>
                                        <th>Mois</th>
                                        <th>Recette Totale (Ar)</th>
                                        <th>Dépense Totale (Ar)</th>
                                        <th>Budget (Ar)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($budgetParMois)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Aucun budget trouvé pour l'année sélectionnée.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($budgetParMois as $budget): ?>
                                            <?php
                                                $annee = $budget['annee'];
                                                $mois = $budget['mois'];
                                                $moisNom = $moisNoms[$mois];
                                                $date_debut = "$annee-" . sprintf("%02d", $mois) . "-01";
                                                $dernier_jour = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
                                                $date_fin = "$annee-" . sprintf("%02d", $mois) . "-$dernier_jour";
                                                $recette_url = BASE_URL."/commande/recette?date_debut=$date_debut&date_fin=$date_fin";
                                                $depense_url = BASE_URL."/depense/list?date_debut=$date_debut&date_fin=$date_fin";
                                            ?>
                                            <tr>
                                                <td><?= htmlspecialchars($annee) ?></td>
                                                <td><?= htmlspecialchars($moisNom) ?></td>
                                                <td>
                                                    <?= number_format($budget['total_recette'], 2, ',', ' ') ?>
                                                    <a href="<?= htmlspecialchars($recette_url) ?>" class="badge badge-info ml-1">Détails</a>
                                                </td>
                                                <td>
                                                    <?= number_format($budget['total_depense'], 2, ',', ' ') ?>
                                                    <a href="<?= htmlspecialchars($depense_url) ?>" class="badge badge-info ml-1">Détails</a>
                                                </td>
                                                <td><?= number_format($budget['budget'], 2, ',', ' ') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Budget annuel -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title"><i class="fas fa-chart-line mr-2"></i>Budget Annuel</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Année</th>
                                        <th>Recette Totale (Ar)</th>
                                        <th>Dépense Totale (Ar)</th>
                                        <th>Budget (Ar)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($budgetParAn)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Aucun budget trouvé pour l'année sélectionnée.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($budgetParAn as $budget): ?>
                                            <?php
                                                $annee = $budget['annee'];
                                                $date_debut = "$annee-01-01";
                                                $date_fin = "$annee-12-31";
                                                $recette_url = BASE_URL."/commande/recette?date_debut=$date_debut&date_fin=$date_fin";
                                                $depense_url = BASE_URL."/depense/list?date_debut=$date_debut&date_fin=$date_fin";
                                            ?>
                                            <tr>
                                                <td><?= htmlspecialchars($budget['annee']) ?></td>
                                                <td>
                                                    <?= number_format($budget['total_recette'], 2, ',', ' ') ?>
                                                    <a href="<?= htmlspecialchars($recette_url) ?>" class="badge badge-info ml-1">Détails</a>
                                                </td>
                                                <td>
                                                    <?= number_format($budget['total_depense'], 2, ',', ' ') ?>
                                                    <a href="<?= htmlspecialchars($depense_url) ?>" class="badge badge-info ml-1">Détails</a>
                                                </td>
                                                <td><?= number_format($budget['budget'], 2, ',', ' ') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Analyse Graphique du Budget</h4>
                        
                        <div class="chart-controls">
                            <button class="chart-btn active" onclick="showChart('monthly')">Vue Mensuelle</button>
                            <button class="chart-btn" onclick="showChart('comparison')">Comparaison</button>
                            <button class="chart-btn" onclick="showChart('trend')">Tendance</button>
                        </div>

                        <div class="loading-spinner" id="loadingSpinner">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Chargement...</span>
                            </div>
                            <p class="mt-3">Génération du graphique...</p>
                        </div>

                        <div class="chart-container">
                            <canvas id="budgetChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>

<script>
// Données PHP converties en JavaScript
const budgetData = <?= json_encode($budgetParMois) ?>;
const moisNoms = <?= json_encode($moisNoms) ?>;

let currentChart = null;

function showChart(type) {
    // Mettre à jour les boutons actifs
    document.querySelectorAll('.chart-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Afficher le spinner
    document.getElementById('loadingSpinner').style.display = 'block';
    
    // Simuler un délai de chargement
    setTimeout(() => {
        document.getElementById('loadingSpinner').style.display = 'none';
        
        // Détruire le graphique existant
        if (currentChart) {
            currentChart.destroy();
        }
        
        // Créer le nouveau graphique
        switch(type) {
            case 'monthly':
                createMonthlyChart();
                break;
            case 'comparison':
                createComparisonChart();
                break;
            case 'trend':
                createTrendChart();
                break;
        }
    }, 800);
}

function createMonthlyChart() {
    const ctx = document.getElementById('budgetChart').getContext('2d');
    
    const labels = budgetData.map(item => moisNoms[item.mois]);
    const recettes = budgetData.map(item => item.total_recette);
    const depenses = budgetData.map(item => item.total_depense);
    const budgets = budgetData.map(item => item.budget);
    
    currentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Recettes',
                data: recettes,
                borderColor: 'rgb(39, 174, 96)',
                backgroundColor: 'rgba(39, 174, 96, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }, {
                label: 'Dépenses',
                data: depenses,
                borderColor: 'rgb(231, 76, 60)',
                backgroundColor: 'rgba(231, 76, 60, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }, {
                label: 'Budget Net',
                data: budgets,
                borderColor: 'rgb(52, 152, 219)',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(52, 152, 219, 0.5)',
                    borderWidth: 1,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + new Intl.NumberFormat('fr-FR').format(context.parsed.y) + ' Ar';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR', {
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value) + ' Ar';
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });
}

function createComparisonChart() {
    const ctx = document.getElementById('budgetChart').getContext('2d');
    
    const labels = budgetData.map(item => moisNoms[item.mois]);
    const recettes = budgetData.map(item => item.total_recette);
    const depenses = budgetData.map(item => item.total_depense);
    
    currentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Recettes',
                data: recettes,
                backgroundColor: 'rgba(39, 174, 96, 0.8)',
                borderColor: 'rgb(39, 174, 96)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }, {
                label: 'Dépenses',
                data: depenses,
                backgroundColor: 'rgba(231, 76, 60, 0.8)',
                borderColor: 'rgb(231, 76, 60)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(52, 152, 219, 0.5)',
                    borderWidth: 1,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + new Intl.NumberFormat('fr-FR').format(context.parsed.y) + ' Ar';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR', {
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value) + ' Ar';
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            }
        }
    });
}

function createTrendChart() {
    const ctx = document.getElementById('budgetChart').getContext('2d');
    
    const labels = budgetData.map(item => moisNoms[item.mois]);
    const budgets = budgetData.map(item => item.budget);
    
    currentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Évolution du Budget',
                data: budgets,
                borderColor: 'rgb(102, 126, 234)',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 4,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(102, 126, 234)',
                pointBorderColor: 'white',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(102, 126, 234, 0.5)',
                    borderWidth: 1,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(context) {
                            return 'Budget: ' + new Intl.NumberFormat('fr-FR').format(context.parsed.y) + ' Ar';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR', {
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value) + ' Ar';
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });
}

// Initialiser le graphique au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    createMonthlyChart();
});

// Animation au scroll
function animateOnScroll() {
    const cards = document.querySelectorAll('.card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });

    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
}

// Lancer l'animation au chargement
document.addEventListener('DOMContentLoaded', animateOnScroll);

// Effet de particules subtil sur le hover des cartes
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.background = 'linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.background = 'white';
        });
    });
});

// Gestion responsive des graphiques
window.addEventListener('resize', function() {
    if (currentChart) {
        currentChart.resize();
    }
});
</script>
</body>
</html>