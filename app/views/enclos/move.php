<!-- views/enclos/move.php -->
<div class="container-fluid">
    <h1>Déplacer une Portée</h1>
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['type'] ?>">
            <?= $_SESSION['flash']['message'] ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    <form method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="id_enclos_portee_source" class="form-label">Source (Enclos - Portée)</label>
            <select class="form-select" name="id_enclos_portee_source" id="id_enclos_portee_source" required>
                <option value="">Sélectionner une source</option>
                <?php foreach ($enclosPortees as $ep): ?>
                    <option value="<?= $ep['id_enclos_portee'] ?>">
                        Enclos <?= $ep['id_enclos'] ?> (<?= $ep['nom_type'] ?>) - Portée du <?= $ep['date_naissance'] ?> (<?= $ep['quantite_total'] ?> porcs)
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Veuillez sélectionner une source.</div>
        </div>
        <div class="mb-3">
            <label for="id_enclos_portee_source" class="form-label">Destination (Enclos)</label>
            <select class="form-select" name="id_enclos_destination" id="id_enclos_destination" required>
                <option value="">Sélectionner une destination</option>
                <?php foreach ($enclosPortees as $ep): ?>
                    <option value="<?= $ep['id_enclos'] ?>">
                        Enclos <?= $ep['id_enclos'] ?> (<?= $ep['nom_type'] ?>) - Portée du <?= $ep['date_naissance'] ?> (<?= $ep['quantite_total'] ?> porcs)
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Veuillez sélectionner une destination.</div>
        </div>
        <div class="mb-3">
            <label for="quantite_males" class="form-label">Quantité de Mâles</label>
            <input type="number" class="form-control" name="quantite_males" id="quantite_males" min="0" required>
            <div class="invalid-feedback">Veuillez entrer une quantité valide.</div>
        </div>
        <div class="mb-3">
            <label for="quantite_femelles" class="form-label">Quantité de Femelles</label>
            <input type="number" class="form-control" name="quantite_femelles" id="quantite_femelles" min="0" required>
            <div class="invalid-feedback">Veuillez entrer une quantité valide.</div>
        </div>
        <button type="submit" class="btn btn-success">Déplacer</button>
        <a href="/enclos" class="btn btn-outline-secondary">Retour</a>
    </form>
</div>

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