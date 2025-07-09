<?php require_once __DIR__ . '/partials/header.php'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Nourrir les Porcs par Enclos</h4>
                
                <?php if (isset($message)): ?>
                    <div class="alert alert-<?= ($message['type']) ?> alert-dismissible fade show">
                        <?= ($message['text']); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                
                <div class="basic-form">
                    <form id="form-nourrir" action="<?= BASE_URL?>/aliments/nourrir/action" method="POST">
                        <input type="hidden" name="enclos" value="<?= htmlspecialchars($selectedEnclos ?? '') ?>">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Sélectionner un enclos</label>
                                <select class="form-control" id="id_enclos_select" required 
                                    onchange="window.location.href='<?= BASE_URL?>/aliments/nourrir?enclos='+this.value">
                                    <option value="">-- Sélectionnez un enclos --</option>
                                    <?php if (!empty($enclos)): ?>
                                        <?php foreach ($enclos as $enclo): ?>
                                            <option value="<?= htmlspecialchars($enclo['id_enclos']) ?>" 
                                                <?= isset($selectedEnclos) && $selectedEnclos == $enclo['id_enclos'] ? 'selected' : '' ?>>
                                                Enclos #<?= htmlspecialchars($enclo['id_enclos']) ?> 
                                                (Type: <?= htmlspecialchars($enclo['type_name'] ?? 'Inconnu') ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="" disabled>Aucun enclos disponible</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <?php if (!empty($infosNourrissage)): ?>
                            <div class="table-responsive mb-4">
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

                            <div id="aliments-container" class="mb-4">
                                <!-- Les blocs d'aliments seront ajoutés ici -->
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <button type="button" id="add-aliment" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Ajouter un aliment
                                    </button>
                                </div>
                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Enregistrer
                                    </button>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                Aucun porc dans l'enclos sélectionné.
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template pour un nouvel aliment (caché) -->
<div id="aliment-template" class="d-none">
    <div class="aliment-group mb-4 border p-3 rounded bg-light">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label>Aliment</label>
                <select class="form-control aliment-select" name="aliments[]" required>
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
            <div class="form-group col-md-5">
                <label>Quantité totale (kg)</label>
                <input type="number" class="form-control input-default aliment-quantity" 
                       name="quantites[]" step="0.01" min="0.1" required>
                <small class="form-text text-muted">
                    Stock disponible: <span class="font-weight-bold stock-value">0</span> kg
                </small>
            </div>
            <div class="form-group col-md-2">
                <button type="button" class="btn btn-danger remove-aliment mt-4">
                    <i class="fa fa-trash"></i> Supprimer
                </button>
            </div>
        </div>
        
        <div class="repartition mt-3">
            <h5>Répartition par race</h5>
            <div class="repartition-inputs">
                <?php foreach ($infosNourrissage as $info): ?>
                    <div class="form-group">
                        <label><?= htmlspecialchars($info['nom_race']) ?> (<?= htmlspecialchars($info['quantite_total']) ?> porcs)</label>
                        <?php if ($info['source_type'] === 'portee'): ?>
                            <input type="number" class="form-control input-default repartition-input" 
                                data-target="portee_<?= htmlspecialchars($info['id_enclos_portee']) ?>" 
                                step="0.01" min="0" placeholder="Quantité en kg">
                        <?php else: ?>
                            <input type="number" class="form-control input-default repartition-input" 
                                data-target="enclos_<?= htmlspecialchars($info['id_race']) ?>" 
                                step="0.01" min="0" placeholder="Quantité en kg">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
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
        template.setAttribute('data-index', alimentIndex);
        
        // Update the repartition inputs with proper names
        const repartitionInputs = template.querySelectorAll('.repartition-input');
        repartitionInputs.forEach(input => {
            const target = input.getAttribute('data-target');
            input.name = `repartitions[${alimentIndex}][${target}]`;
        });
        
        document.getElementById('aliments-container').appendChild(template);
        
        // Activer les événements pour le nouveau bloc
        initAlimentEvents(template);
        alimentIndex++;
    });

    // Supprimer un aliment
    function initAlimentEvents(element) {
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
        let hasAtLeastOneAliment = false;
        
        document.querySelectorAll('.aliment-group').forEach(group => {
            const alimentSelect = group.querySelector('.aliment-select');
            const quantite = parseFloat(group.querySelector('.aliment-quantity').value);
            const stock = parseFloat(group.querySelector('.stock-disponible span').textContent);
            
            if (alimentSelect.value && quantite > 0) {
                hasAtLeastOneAliment = true;
                
                if (quantite > stock) {
                    alert('❌ La quantité demandée dépasse le stock disponible !');
                    isValid = false;
                }
            }
        });

        if (!hasAtLeastOneAliment) {
            alert('❌ Veuillez ajouter au moins un aliment avec une quantité valide !');
            isValid = false;
        }

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