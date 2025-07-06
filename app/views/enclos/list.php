<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Stockage</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($enclos as $enclo) { ?>
            <tr>
                <td><a href="/enclos/show/<?php echo $enclo['id_enclos']; ?>"><?php echo $enclo['id_enclos']; ?></a></td>
                <td><?php echo $enclo['nom_enclos_type']; ?></td>
                <td><?php echo $enclo['stockage']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>