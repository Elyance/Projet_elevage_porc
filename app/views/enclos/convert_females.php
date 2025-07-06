<!-- views/enclos/convert_females.php -->
<div class="container-fluid">
    <h1>Conversion des Femelles en Truies</h1>
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['type'] ?>">
            <?= $_SESSION['flash']['message'] ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?php if (!empty($females)): ?>
        <?php foreach ($females as $female): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Portée ID: <?= $female['id_portee'] ?></h5>
                    <p class="card-text">
                        Enclos: <?= $female['id_enclos'] ?> - Quantité Totale: <?= $female['quantite_total'] ?> - 
                        Femelles Disponibles: <?= $female['nombre_femelles'] ?? 0 ?> - 
                        Date Naissance: <?= $female['date_naissance'] ?> - 
                        Jours Écoulés: <?= $female['nombre_jour_ecoule'] ?? 'N/A' ?>
                    </p>
                    <form method="post" class="needs-validation" novalidate>
                        <input type="hidden" name="id_portee" value="<?= $female['id_portee'] ?>">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Nombre de Femelles à Convertir</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" min="1" max="<?= $female['nombre_femelles'] ?? $female['quantite_total'] ?>" required>
                            <div class="invalid-feedback">Veuillez entrer un nombre valide (1 à <?= $female['nombre_femelles'] ?? $female['quantite_total'] ?>).</div>
                        </div>
                        <div class="mb-3">
                            <label for="id_enclos" class="form-label">Sélectionner un Enclos Truie</label>
                            <select class="form-select" name="id_enclos" id="id_enclos" required>
                                <option value="">Choisir un enclos</option>
                                <?php foreach ($enclosTrie as $enclo): ?>
                                    <option value="<?= $enclo['id_enclos'] ?>">
                                        Enclos <?= $enclo['id_enclos'] ?> (<?= $enclo['nom_type'] ?>) - Surface: <?= $enclo['surface'] ?> m²
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Veuillez sélectionner un enclos.</div>
                        </div>
                        <button type="submit" class="btn btn-success">Convertir en Truies</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune femelle éligible (334 jours ou plus) trouvée.</p>
    <?php endif; ?>
    <a href="/enclos" class="btn btn-outline-secondary mt-3">Retour</a>
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