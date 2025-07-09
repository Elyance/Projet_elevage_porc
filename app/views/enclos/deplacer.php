<div class="form-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Déplacer des porcs</h2>
        <a href="<?= BASE_URL?>/enclos" class="btn btn-outline-secondary">Retour à la liste</a>
    </div>
    
    <form method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="enclos" class="form-label">Enclos source</label>
            <select class="form-select" name="enclos_source" id="enclos" required>
                <option value="">Sélectionner un enclos</option>
                <?php foreach ($enclos as $enclo) { ?>
                    <option value="<?php echo $enclo['id_enclos']; ?>">
                        <?php echo $enclo['id_enclos']; ?> : <?php echo $enclo['nom_enclos_type']; ?> (<?php echo $enclo['stockage']; ?>)
                    </option>
                <?php } ?>
            </select>
            <div class="invalid-feedback">
                Veuillez sélectionner un enclos source.
            </div>
        </div>
        
        <div class="mb-3">
            <label for="quantite" class="form-label">Quantité</label>
            <input type="number" class="form-control" name="quantite" id="quantite" placeholder="Quantité" min="1" required>
            <div class="invalid-feedback">
                Veuillez entrer une quantité valide.
            </div>
        </div>
        
        <div class="mb-3">
            <label for="destination" class="form-label">Enclos destination</label>
            <select class="form-select" name="enclos_destination" id="destination" required>
                <option value="">Sélectionner un enclos</option>
                <?php foreach ($enclos as $enclo) { ?>
                    <option value="<?php echo $enclo['id_enclos']; ?>">
                        <?php echo $enclo['id_enclos']; ?> : <?php echo $enclo['nom_enclos_type']; ?> (<?php echo $enclo['stockage']; ?>)
                    </option>
                <?php } ?>
            </select>
            <div class="invalid-feedback">
                Veuillez sélectionner un enclos destination.
            </div>
        </div>
        
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Déplacer</button>
        </div>
    </form>
</div>

<script>
// Validation Bootstrap
(function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
})()
</script>