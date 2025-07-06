<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h2>🍽️ Nourrir les Porcs par Enclos</h2>
    </div>
    <?php if (isset($message)): ?>
        <div class="alert alert-<?= htmlspecialchars($message['type']) ?>">
            <?= htmlspecialchars($message['text']); ?>
        </div>
    <?php endif; ?>
    <div class="card-body">
        <form id="form-nourrir" action="/aliments/nourrir/action" method="POST">
            <input type="hidden" name="id_enclos" value="<?= htmlspecialchars($selectedEnclos ?? '') ?>">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="id_enclos_select" class="form-label">Sélectionner un enclos</label>
                    <select class="form-select" id="id_enclos_select" required
                            onchange="window.location.href='/aliments/nourrir?enclos='+this.value">
                        <option value="">-- Sélectionnez un enclos --</option>
                        <?php if (!empty($enclos)): ?>
                            <?php foreach ($enclos as $enclo): ?>
                                <option value="<?= htmlspecialchars($enclo['id_enclos']) ?>" <?= isset($selectedEnclos) && $selectedEnclos == $enclo['id_enclos'] ? 'selected' : '' ?>>
                                    Enclos #<?= htmlspecialchars($enclo['id_enclos']) ?> (Type: <?= htmlspecialchars($enclo['enclos_type']) ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>Aucun enclos disponible</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <?php if (!empty($infosNourrissage)): ?>
                <div class="mb-4">
                    <h5>Porcs dans l'enclos</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Race</th>
                                <th>Total</th>
                                <th>Besoins nutritionnels</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($infosNourrissage as $info): ?>
                                <tr>
                                    <td><?= htmlspecialchars($info['nom_race']) ?></td>
                                    <td><?= htmlspecialchars($info['quantite_total']) ?></td>
                                    <td><?= htmlspecialchars($info['besoins_nutritionnels'] ?? 'N/A') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="aliments-container">
                    <!-- Les blocs d'aliments seront ajoutés ici -->
                </div>

                <button type="button" id="add-aliment" class="btn btn-primary mb-3">
                    ➕ Ajouter un aliment
                </button>

                <button type="submit" class="btn btn-success">
                    ✅ Enregistrer le nourrissage
                </button>
            <?php else: ?>
                <p class="text-warning">Aucun porc dans l'enclos sélectionné.</p>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Template pour un nouvel aliment (caché) -->
<div id="aliment-template" class="d-none">
    <div class="aliment-group mb-4 border p-3 rounded" data-index="0"> <!-- Add data-index attribute -->
        <div class="row mb-3">
            <div class="col-md-5">
                <label class="form-label">Aliment</label>
                <select class="form-select aliment-select" name="aliments[]" required>
                    <option value="">-- Sélectionnez --</option>
                    <?php foreach ($aliments as $aliment): ?>
                        <option value="<?= htmlspecialchars($aliment['id_aliment']) ?>" 
                                data-stock="<?= htmlspecialchars($aliment['stock_kg'] ?? 0) ?>">
                            <?= htmlspecialchars($aliment['nom_aliment']) ?> 
                            (Stock: <?= number_format($aliment['stock_kg'] ?? 0, 2) ?> kg)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Quantité totale (kg)</label>
                <input type="number" class="form-control aliment-quantity" 
                       name="quantites[]" step="0.01" min="0.1" required>
                <div class="form-text stock-disponible">
                    Stock disponible: <span class="fw-bold">0</span> kg
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-aliment mt-4">
                    ❌ Supprimer
                </button>
            </div>
        </div>
        
        <div class="repartition mt-3">
            <h6>Répartition par race</h6>
            <?php foreach ($infosNourrissage as $info): ?>
                <div class="mb-2">
                    <label><?= htmlspecialchars($info['nom_race']) ?> (<?= htmlspecialchars($info['quantite_total']) ?> porcs)</label>
                    <input type="number" class="form-control repartition-input mb-1" 
                           name="repartitions[{index}][<?= htmlspecialchars($info['id_enclos_portee']) ?>]" 
                           step="0.01" min="0" data-index-placeholder="{index}">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let alimentIndex = 0;

    // Ajouter un aliment
    document.getElementById('add-aliment').addEventListener('click', function() {
        const template = document.getElementById('aliment-template').cloneNode(true);
        template.classList.remove('d-none');
        template.removeAttribute('id');
        template.querySelectorAll('[data-index-placeholder]').forEach(element => {
            element.name = element.name.replace('{index}', alimentIndex);
        });
        template.setAttribute('data-index', alimentIndex);
        document.getElementById('aliments-container').appendChild(template);
        
        // Activer les événements pour le nouveau bloc
        initAlimentEvents(template);
        alimentIndex++;
    });

    // Supprimer un aliment
    function initAlimentEvents(element) {
        const index = element.getAttribute('data-index');
        element.querySelector('.remove-aliment').addEventListener('click', function() {
            element.remove();
        });

        // Gestion du stock
        element.querySelector('.aliment-select').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock') || 0;
            element.querySelector('.stock-disponible span').textContent = stock;
        });

        // Calcul automatique de la quantité totale
        element.querySelectorAll('.repartition-input').forEach(input => {
            input.addEventListener('input', function() {
                let total = 0;
                element.querySelectorAll('.repartition-input').forEach(i => {
                    total += parseFloat(i.value) || 0;
                });
                element.querySelector('.aliment-quantity').value = total.toFixed(2);
            });
        });
    }

    // Validation du formulaire
    document.getElementById('form-nourrir').addEventListener('submit', function(e) {
        let isValid = true;
        
        document.querySelectorAll('.aliment-group').forEach(group => {
            const quantite = parseFloat(group.querySelector('.aliment-quantity').value);
            const stock = parseFloat(group.querySelector('.stock-disponible span').textContent);
            
            if (quantite > stock || quantite <= 0) {
                alert('❌ La quantité demandée dépasse le stock disponible ou est invalide !');
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
        }
    });

    // Ajouter un premier aliment automatiquement si des infos sont présentes
    <?php if (!empty($infosNourrissage)): ?>
        document.getElementById('add-aliment').click();
    <?php endif; ?>
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>