<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <h1 class="mt-3 mb-4">Conversion des Femelles en Truies</h1>

            <!-- Flash message -->
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-<?= $_SESSION['flash']['type'] ?>">
                    <?= $_SESSION['flash']['message'] ?>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <?php if (!empty($females)): ?>
                <?php foreach ($females as $female): ?>
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            Portée ID: <?= $female['id_portee'] ?> – Enclos <?= $female['id_enclos'] ?>
                        </div>
                        <div class="card-body">
                            <p>
                                Quantité Totale: <?= $female['quantite_total'] ?> | Femelles Disponibles: <?= $female['nombre_femelles'] ?? 0 ?> <br>
                                Date Naissance: <?= $female['date_naissance'] ?> | Jours Écoulés: <?= $female['nombre_jour_ecoule'] ?? 'N/A' ?>
                            </p>

                            <form method="post" class="form-validation needs-validation" novalidate>
                                <input type="hidden" name="id_portee" value="<?= $female['id_portee'] ?>">

                                <!-- Quantité à convertir -->
                                <div class="form-group row mb-4">
                                    <label class="col-lg-4 col-form-label" for="quantity_<?= $female['id_portee'] ?>">
                                        Nombre de Femelles à Convertir <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="number"
                                            class="form-control"
                                            name="quantity"
                                            id="quantity_<?= $female['id_portee'] ?>"
                                            min="1"
                                            max="<?= $female['nombre_femelles'] ?? $female['quantite_total'] ?>"
                                            required>
                                        <div class="invalid-feedback">
                                            Veuillez entrer un nombre valide (1 à <?= $female['nombre_femelles'] ?? $female['quantite_total'] ?>).
                                        </div>
                                    </div>
                                </div>

                                <!-- Sélection de l'enclos -->
                                <div class="form-group row mb-4">
                                    <label class="col-lg-4 col-form-label" for="id_enclos_<?= $female['id_portee'] ?>">
                                        Sélectionner un Enclos Truie <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <select class="form-control" name="id_enclos" id="id_enclos_<?= $female['id_portee'] ?>" required>
                                            <option value="">Choisir un enclos</option>
                                            <?php foreach ($enclosTrie as $enclo): ?>
                                                <option value="<?= $enclo['id_enclos'] ?>">
                                                    Enclos <?= $enclo['id_enclos'] ?> (<?= $enclo['nom_type'] ?>) – Surface: <?= $enclo['surface'] ?> m²
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Veuillez sélectionner un enclos.</div>
                                    </div>
                                </div>

                                <!-- Bouton -->
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-success">Convertir en Truies</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning">
                    Aucune femelle éligible (334 jours ou plus) trouvée.
                </div>
            <?php endif; ?>

            <!-- Bouton retour -->
            <div class="text-end mt-3">
                <a href="<?= BASE_URL ?>/enclos" class="btn btn-outline-secondary">Retour</a>
            </div>
        </div>
    </div>
</div>

<!-- Validation JS -->
<script>
(function () {
    'use strict';
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>
