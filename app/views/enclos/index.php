<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Liste des enclos</h1>
        <div class="action-buttons">
            <a href="/enclos/ajouter" class="btn btn-primary">Ajouter un enclos</a>
            <a href="/enclos/deplacer" class="btn btn-success">Déplacer porc</a>
            <button class="btn btn-secondary">Ajouter commande</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Stockage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enclos as $enclo) { ?>
                    <tr>
                        <td><a href="/enclos/show/<?php echo $enclo['id_enclos']; ?>" class="text-decoration-none"><?php echo $enclo['id_enclos']; ?></a></td>
                        <td><?php echo $enclo['nom_enclos_type']; ?></td>
                        <td><?php echo $enclo['stockage']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>