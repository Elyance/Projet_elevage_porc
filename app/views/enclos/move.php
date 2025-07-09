<!-- views/enclos/move.php -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Notification Flash -->
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-<?= $_SESSION['flash']['type'] ?> mt-3">
                    <?= $_SESSION['flash']['message'] ?>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <!-- Formulaire stylisé -->
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Déplacer une Portée</h4>
                </div>
                <div class="card-body">
                    <form method="post" class="form-validation needs-validation" novalidate>
                        <!-- Source -->
                        <div class="form-group row mb-4">
                            <label class="col-lg-4 col-form-label" for="id_enclos_portee_source">
                                Source (Enclos - Portée) <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <select class="form-control" name="id_enclos_portee_source" id="id_enclos_portee_source" required>
                                    <option value="">Sélectionner une source</option>
                                    <?php foreach ($enclosPortees as $ep): ?>
                                        <option value="<?= $ep['id_enclos_portee'] ?>">
                                            Enclos <?= $ep['id_enclos'] ?> (<?= $ep['nom_type'] ?>) - Portée du <?= $ep['date_naissance'] ?> (<?= $ep['quantite_total'] ?> porcs)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Veuillez sélectionner une source.</div>
                            </div>
                        </div>

                        <!-- Destination -->
                        <div class="form-group row mb-4">
                            <label class="col-lg-4 col-form-label" for="id_enclos_destination">
                                Destination (Enclos) <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <select class="form-control" name="id_enclos_destination" id="id_enclos_destination" required>
                                    <option value="">Sélectionner une destination</option>
                                    <?php foreach ($enclosPortees as $ep): ?>
                                        <option value="<?= $ep['id_enclos'] ?>">
                                            Enclos <?= $ep['id_enclos'] ?> (<?= $ep['nom_type'] ?>) - Portée du <?= $ep['date_naissance'] ?> (<?= $ep['quantite_total'] ?> porcs)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Veuillez sélectionner une destination.</div>
                            </div>
                        </div>

                        <!-- Quantité de mâles -->
                        <div class="form-group row mb-4">
                            <label class="col-lg-4 col-form-label" for="quantite_males">
                                Quantité de Mâles <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <input type="number" class="form-control" name="quantite_males" id="quantite_males" min="0" required>
                                <div class="invalid-feedback">Veuillez entrer une quantité valide.</div>
                            </div>
                        </div>

                        <!-- Quantité de femelles -->
                        <div class="form-group row mb-4">
                            <label class="col-lg-4 col-form-label" for="quantite_femelles">
                                Quantité de Femelles <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-6">
                                <input type="number" class="form-control" name="quantite_femelles" id="quantite_femelles" min="0" required>
                                <div class="invalid-feedback">Veuillez entrer une quantité valide.</div>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto">
                                <button type="submit" class="btn btn-success">Déplacer</button>
                                <a href="<?= BASE_URL ?>/enclos" class="btn btn-outline-secondary ms-2">Retour</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div> <!-- .card -->
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
