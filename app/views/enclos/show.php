<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Détails de l'enclos</h2>
        <div>
            <a href="/enclos" class="btn btn-outline-secondary me-2">Retour à la liste</a>
            <a href="/enclos/delete/<?php echo $enclos['id_enclos']; ?>" 
               class="btn btn-danger" 
               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enclos ?');">
               Supprimer
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">ID : <?php echo $enclos['id_enclos']; ?></h3>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p class="card-text"><strong>Type :</strong> <?php echo $enclos['nom_enclos_type']; ?></p>
                </div>
                <div class="col-md-6">
                    <p class="card-text"><strong>Stockage :</strong> <?php echo $enclos['stockage']; ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p class="card-text"><strong>Nombre de porc :</strong> <?php echo $enclos['quantite_portee'] ?? 0; ?></p>
                </div>
                <div class="col-md-6">
                    <p class="card-text"><strong>Poids estimé :</strong> <?php echo $enclos['poids_estimation'] ?? 0; ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p class="card-text"><strong>Status :</strong> <?php echo $enclos['statut_vente'] ?? "Aucun"; ?></p>
                </div>
                <div class="col-md-6">
                    <p class="card-text"><strong>Nombre de jours ecoulé :</strong> <?php echo $enclos['nombre_jour_ecoule'] ?? "Aucun"; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>