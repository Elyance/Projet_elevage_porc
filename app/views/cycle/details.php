```php
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h1 style="font-size: 1.5rem; margin-bottom: 1rem;">Détails des Cycles</h1>

    <h2 style="font-size: 1.25rem; margin-bottom: 0.5rem;">Cycle Actuel (ID: <?= htmlspecialchars($currentCycle->id_cycle_reproduction) ?>)</h2>
    <p><strong>Truie:</strong> <?= htmlspecialchars($currentCycle->truie_poids) ?> kg</p>
    <p><strong>Date Début:</strong> <?= htmlspecialchars($currentCycle->date_debut_cycle) ?></p>
    <p><strong>Date Fin:</strong> <?= htmlspecialchars($currentCycle->date_fin_cycle) ?></p>
    <p><strong>Nombre de Mâles:</strong> <?= htmlspecialchars($currentCycle->nombre_males ?? 'N/A') ?></p>
    <p><strong>Nombre de Femelles:</strong> <?= htmlspecialchars($currentCycle->nombre_femelles ?? 'N/A') ?></p>
    <p><strong>État:</strong> <?= htmlspecialchars($currentCycle->etat) ?></p>

    <h2 style="font-size: 1.25rem; margin: 1rem 0 0.5rem;">Précédent Cycle</h2>
    <?php if ($precedentCycle): ?>
        <table>
            <tr>
                <th>Date Début</th>
                <th>Date Fin</th>
                <th>Nombre de Mâles</th>
                <th>Nombre de Femelles</th>
                <th>État</th>
            </tr>
            <tr>
                <td><?= htmlspecialchars($precedentCycle->date_debut_cycle) ?></td>
                <td><?= htmlspecialchars($precedentCycle->date_fin_cycle) ?></td>
                <td><?= htmlspecialchars($precedentCycle->nombre_males ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($precedentCycle->nombre_femelles ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($precedentCycle->etat) ?></td>
            </tr>
        </table>
    <?php else: ?>
        <p>Aucun cycle précédent dont la truie.</p>
    <?php endif; ?>

    <h2 style="font-size: 1.25rem; margin: 1rem 0 0.5rem;">Prévision</h2>
    <p><strong>Durée Moyenne (jours):</strong> <?= number_format($prevision['days'], 2) ?></p>
    <p><strong>Nombre de Portées Moyen:</strong> <?= number_format($prevision['portee'], 2) ?></p>

    <h2 style="font-size: 1.25rem; margin: 1rem 0 0.5rem;">Graphiques</h2>
    <div style="margin-bottom: 1.5rem;">
        <canvas id="durationChart" style="max-width: 600px;"></canvas>
    </div>
    <div>
        <canvas id="litterChart" style="max-width: 400px;"></canvas>
    </div>

    <h2 style="font-size: 1.25rem; margin: 1rem 0 0.5rem;">Action</h2>
    <a href="<?php echo Flight::get('flight.base_url')?>/naissance/add?cycle_id=<?= htmlspecialchars($currentCycle->id_cycle_reproduction) ?>&truie_id=<?= htmlspecialchars($currentCycle->id_truie) ?>">Naissance</a>
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
                    <?php
                        $currentDuration = (strtotime($currentCycle->date_fin_cycle) - strtotime($currentCycle->date_debut_cycle)) / (60 * 60 * 24);
                        echo $currentDuration;
                    ?>,
                    <?php
                        $previousDuration = $precedentCycle ? (strtotime($precedentCycle->date_fin_cycle) - strtotime($precedentCycle->date_debut_cycle)) / (60 * 60 * 24) : 0;
                        echo $previousDuration;
                    ?>
                ],
                backgroundColor: ["var(--secondary)", "var(--accent1)"],
                borderColor: ["var(--secondary)", "var(--accent1)"],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                title: { display: true, text: "Durée des Cycles", color: "var(--light)" }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: "Jours", color: "var(--light)" },
                    ticks: { color: "var(--light)" }
                },
                x: { ticks: { color: "var(--light)" } }
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
                    <?php echo htmlspecialchars($currentCycle->nombre_males ?? 0); ?>,
                    <?php echo htmlspecialchars($currentCycle->nombre_femelles ?? 0); ?>
                ],
                backgroundColor: ["var(--accent1)", "var(--secondary)"],
                borderColor: ["var(--light)", "var(--light)"],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: "bottom", labels: { color: "var(--light)" } },
                title: { display: true, text: "Répartition des Naissances", color: "var(--light)" }
            }
        }
    });
</script>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>