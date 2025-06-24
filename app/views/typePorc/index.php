<h2>List de type de porc</h2>
<a href="/typePorc/add">ajouter un type de porc</a>

<?php

?>
<table border="1">
    <tr>
        <th>nom</th>
        <th>Age min</th>
        <th>Age max</th>
        <th>Poids minimu</th>
        <th>Poids minimu</th>
        <th>Espace requis par animal</th>
        <th>Action</th>
    </tr>
    <?php for ($i = 0; $i < count($typePorcs); $i++) { ?>
        <tr>
            <td><?= $typePorcs[$i]['nom'] ?></td>
            <td><?= $typePorcs[$i]['age_min'] ?></td>
            <td><?= $typePorcs[$i]['age_max'] ?></td>
            <td><?= $typePorcs[$i]['poids_max'] ?></td>
            <td><?= $typePorcs[$i]['poids_max'] ?></td>
            <td><?= $typePorcs[$i]['espace_requis'] ?></td>
            <td>
                <a href="/typePorc/delete?id=<?= $typePorcs[$i]['id'] ?>">Delete</a>
                <a href="/typePorc/edit?id=<?= $typePorcs[$i]['id'] ?>">Update</a>
            </td>
        </tr>
    <?php } ?>
</table>