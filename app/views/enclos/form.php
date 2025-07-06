<div class="form-container">
    <h2>Ajouter un enclos</h2>
    
    <form action="" method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="type_enclos" class="form-label">Type d'enclos</label>
            <select class="form-select" name="type_enclos" id="type_enclos" required>
                <option value="">Sélectionner un enclos</option>
                <?php foreach ($enclos_type as $enclo_type) { ?>
                    <option value="<?php echo $enclo_type['id_enclos_type']; ?>">
                        <?php echo $enclo_type['nom_enclos_type']; ?>
                    </option>
                <?php } ?>
            </select>
            <div class="invalid-feedback">
                Veuillez sélectionner un type d'enclos.
            </div>
        </div>
        
        <div class="mb-3">
            <label for="stockage" class="form-label">Stockage</label>
            <input type="number" class="form-control" name="stockage" id="stockage" placeholder="Stockage" min="1" required>
            <div class="invalid-feedback">
                Veuillez entrer une capacité de stockage valide.
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="/enclos" class="btn btn-outline-secondary">Annuler</a>
    </form>
</div>

<script>
// Validation Bootstrap
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
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