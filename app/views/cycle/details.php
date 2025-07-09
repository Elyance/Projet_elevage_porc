<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center" style="font-size: 2rem; margin-bottom: 2rem;">DÉTAILS DES CYCLES</h4>
                        
                        <div class="cycle-section" style="margin-bottom: 2rem;">
                            <h3 class="section-title" style="font-size: 1.6rem; color: var(--primary); margin-bottom: 1rem;">Cycle Actuel (ID: <?= htmlspecialchars($currentCycle->id_cycle_reproduction) ?>)</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="font-size: 1.4rem;"><strong>Truie:</strong> <?= htmlspecialchars($currentCycle->truie_poids) ?> kg</p>
                                    <p style="font-size: 1.4rem;"><strong>Date Début:</strong> <?= htmlspecialchars($currentCycle->date_debut_cycle ?? 'N/A') ?></p>
                                    <p style="font-size: 1.4rem;"><strong>Date Fin:</strong> <?= htmlspecialchars($currentCycle->date_fin_cycle ?? 'N/A') ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p style="font-size: 1.4rem;"><strong>Nombre de Mâles:</strong> <?= htmlspecialchars($currentCycle->nombre_males ?? 'N/A') ?></p>
                                    <p style="font-size: 1.4rem;"><strong>Nombre de Femelles:</strong> <?= htmlspecialchars($currentCycle->nombre_femelles ?? 'N/A') ?></p>
                                    <p style="font-size: 1.4rem;"><strong>État:</strong> 
                                        <span class="badge badge-<?= 
                                            $currentCycle->etat === 'actif' ? 'primary' : 
                                            ($currentCycle->etat === 'termine' ? 'success' : 
                                            ($currentCycle->etat === 'en cours' ? 'warning' : 'secondary')) ?>" 
                                            style="font-size: 1.3rem;">
                                            <?= htmlspecialchars($currentCycle->etat) ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cycle-section" style="margin-bottom: 2rem;">
                            <h3 class="section-title" style="font-size: 1.6rem; color: var(--primary); margin-bottom: 1rem;">Précédent Cycle</h3>
                            <?php if ($precedentCycle): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover" style="font-size: 1.4rem;">
                                        <thead>
                                            <tr>
                                                <th>Date Début</th>
                                                <th>Date Fin</th>
                                                <th>Mâles</th>
                                                <th>Femelles</th>
                                                <th>État</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= htmlspecialchars($precedentCycle->date_debut_cycle ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($precedentCycle->date_fin_cycle ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($precedentCycle->nombre_males ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($precedentCycle->nombre_femelles ?? 'N/A') ?></td>
                                                <td>
                                                    <span class="badge badge-<?= 
                                                        $precedentCycle->etat === 'actif' ? 'primary' : 
                                                        ($precedentCycle->etat === 'termine' ? 'success' : 
                                                        ($precedentCycle->etat === 'en cours' ? 'warning' : 'secondary')) ?>" 
                                                        style="font-size: 1.3rem;">
                                                        <?= htmlspecialchars($precedentCycle->etat) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p style="font-size: 1.4rem;">Aucun cycle précédent pour cette truie.</p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="cycle-section" style="margin-bottom: 2rem;">
                            <h3 class="section-title" style="font-size: 1.6rem; color: var(--primary); margin-bottom: 1rem;">Prévision</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="font-size: 1.4rem;"><strong>Durée Moyenne (jours):</strong> <?= number_format($prevision['days'], 2) ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p style="font-size: 1.4rem;"><strong>Nombre de Portées Moyen:</strong> <?= number_format($prevision['portee'], 2) ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="cycle-section" style="margin-bottom: 2rem;">
                            <h3 class="section-title" style="font-size: 1.6rem; color: var(--primary); margin-bottom: 1rem;">Graphiques</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="chart-container" style="height: 300px;">
                                        <canvas id="durationChart"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="chart-container" style="height: 300px;">
                                        <canvas id="litterChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center" style="margin-top: 2rem;">
                            <a href="<?= BASE_URL ?>/naissance/add?cycle_id=<?= htmlspecialchars($currentCycle->id_cycle_reproduction) ?>&truie_id=<?= htmlspecialchars($currentCycle->id_truie) ?>" class="btn btn-primary btn-lg" style="font-size: 1.4rem; padding: 0.75rem 2rem;">Enregistrer une Naissance</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    // Bar chart for cycle duration
    const durationChart = document.getElementById("durationChart").getContext("2d");
    new Chart(durationChart, {
        type: "bar",
        data: {
            labels: ["Cycle Actuel", "Cycle Précédent"],
            datasets: [{
                label: "Durée (jours)",
                data: [
                    <?= ($currentCycle->date_debut_cycle && $currentCycle->date_fin_cycle) ? 
                        (strtotime($currentCycle->date_fin_cycle) - strtotime($currentCycle->date_debut_cycle)) / (60 * 60 * 24) : 0 ?>,
                    <?= ($precedentCycle && $precedentCycle->date_debut_cycle && $precedentCycle->date_fin_cycle) ? 
                        (strtotime($precedentCycle->date_fin_cycle) - strtotime($precedentCycle->date_debut_cycle)) / (60 * 60 * 24) : 0 ?>
                ],
                backgroundColor: ["#4e73df", "#1cc88a"],
                borderColor: ["#4e73df", "#1cc88a"],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true },
                title: { display: true, text: "Durée des Cycles" }
            },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: "Jours" } }
            }
        }
    });

    // Pie chart for litter size
    const litterChart = document.getElementById("litterChart").getContext("2d");
    new Chart(litterChart, {
        type: "pie",
        data: {
            labels: ["Mâles", "Femelles"],
            datasets: [{
                data: [
                    <?= htmlspecialchars($currentCycle->nombre_males ?? 0) ?>,
                    <?= htmlspecialchars($currentCycle->nombre_femelles ?? 0) ?>
                ],
                backgroundColor: ["#4e73df", "#1cc88a"],
                borderColor: "#fff",
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: "bottom" },
                title: { display: true, text: "Répartition des Naissances" }
            }
        }
    });
</script>
<style>
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .card-title {
        color: #4e73df;
        font-weight: 600;
    }

    .table th {
        font-size: 1.4rem;
        font-weight: 600;
        color: #4e73df;
    }

    /* Badges colorés pour les différents états */
    .badge-success {
        background-color: #1cc88a;
        color: white;
    }

    .badge-primary {
        background-color: #4e73df;
        color: white;
    }

    .badge-warning {
        background-color: #f6c23e;
        color: #2e2e2e;
    }

    .badge-danger {
        background-color: #e74a3b;
        color: white;
    }

    .badge-secondary {
        background-color: #858796;
        color: white;
    }

    /* Animation pour les états actifs */
    .badge-success {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(28, 200, 138, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(28, 200, 138, 0); }
        100% { box-shadow: 0 0 0 0 rgba(28, 200, 138, 0); }
    }

    .btn-lg {
        padding: 0.75rem 2rem;
        font-size: 1.4rem;
        border-radius: 0.35rem;
    }

    .form-control-lg {
        font-size: 1.4rem;
        padding: 1rem 1.5rem;
        height: calc(2.5em + 1rem + 2px);
    }

    .section-title {
        border-bottom: 2px solid #f8f9fc;
        padding-bottom: 0.5rem;
    }

    .chart-container {
        position: relative;
        height: 300px;
    }
</style>