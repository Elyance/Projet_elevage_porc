<div class="card">
        <div class="card-body">
            <h4 class="card-title">Table Stripped</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped verticle-middle">
                    <thead>
                        <tr>
                            <th scope="col">nom</th>
                            <th scope="col">Type</th>
                            <th scope="col">Superficie</th>
                            <th scope="col">Capacite</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($enclos); $i++) { ?>
                            <tr>
                                <td><?= $enclos[$i]['nom'] ?></td>
                                <td><?= $enclos[$i]['type'] ?></td>
                                <td><?= $enclos[$i]['superficie'] ?></td>
                                <td><?= $enclos[$i]['capacite'] ?></td>
                                <td><span>
                                        <a href="/enclos/edit?id=<?= $enclos[$i]['id'] ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fa fa-pencil color-muted m-r-5"></i>
                                        </a>
                                        <a href="/enclos/delete?id=<?= $enclos[$i]['id'] ?>" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="fa fa-close color-danger"></i>
                                        </a></span>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>