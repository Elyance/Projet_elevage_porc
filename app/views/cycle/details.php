<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h4>DÉTAILS DES CYCLES</h4>
            </div>
            
            <div class="cycle-section mb-4">
                <h5 class="section-title">Cycle Actuel (ID: <?= htmlspecialchars($currentCycle->id_cycle_reproduction) ?>)</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Truie:</strong> <?= htmlspecialchars($currentCycle->truie_poids) ?> kg</p>
                        <p><strong>Date Début:</strong> <?= htmlspecialchars($currentCycle->date_debut_cycle ?? 'N/A') ?></p>
                        <p><strong>Date Fin:</strong> <?= htmlspecialchars($currentCycle->date_fin_cycle ?? 'N/A') ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Nombre de Mâles:</strong> <?= htmlspecialchars($currentCycle->nombre_males ?? 'N/A') ?></p>
                        <p><strong>Nombre de Femelles:</strong> <?= htmlspecialchars($currentCycle->nombre_femelles ?? 'N/A') ?></p>
                        <p><strong>État:</strong> 
                            <span class="badge badge-<?= 
                                $currentCycle->etat === 'actif' ? 'primary' : 
                                ($currentCycle->etat === 'termine' ? 'success' : 
                                ($currentCycle->etat === 'en cours' ? 'warning' : 'secondary')) ?>">
                                <?= htmlspecialchars($currentCycle->etat) ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="cycle-section mb-4">
                <h5 class="section-title">Précédent Cycle</h5>
                <?php if ($precedentCycle): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
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
                                            ($precedentCycle->etat === 'en cours' ? 'warning' : 'secondary')) ?>">
                                            <?= htmlspecialchars($precedentCycle->etat) ?>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>Aucun cycle précédent pour cette truie.</p>
                <?php endif; ?>
            </div>
            
            <div class="cycle-section mb-4">
                <h5 class="section-title">Prévision</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Durée Moyenne (jours):</strong> <?= number_format($prevision['days'], 2) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Nombre de Portées Moyen:</strong> <?= number_format($prevision['portee'], 2) ?></p>
                    </div>
                </div>
            </div>
            
            <div class="cycle-section mb-4">
                <h5 class="section-title">Graphiques</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="chart-container">
                            <canvas id="durationChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="chart-container">
                            <canvas id="litterChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <a href="<?= BASE_URL ?>/naissance/add?cycle_id=<?= htmlspecialchars($currentCycle->id_cycle_reproduction) ?>&truie_id=<?= htmlspecialchars($currentCycle->id_truie) ?>" class="btn btn-primary">Enregistrer une Naissance</a>
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