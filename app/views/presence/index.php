<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Gestion de la Présence</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Gestion de la Présence</h4>
                        
                        <form method="get" action="/presence" class="form-inline mb-4">
                            <div class="form-group mr-3">
                                <label class="mr-2">Mois:</label>
                                <select name="mois" class="form-control" onchange="this.form.submit()">
                                    <?php foreach ($months as $m): ?>
                                        <option value="<?= $m ?>" <?= $m == $month ? "selected" : "" ?>><?= $m ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mr-2">Année:</label>
                                <select name="annee" class="form-control" onchange="this.form.submit()">
                                    <?php foreach ($years as $y): ?>
                                        <option value="<?= $y ?>" <?= $y == $year ? "selected" : "" ?>><?= $y ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </form>

                        <h5 class="mb-3">Jours du Mois</h5>
                        <div class="d-flex flex-wrap">
                            <?php foreach ($days as $day): ?>
                                <a href="<?=BASE_URL?>/presence/detail_jour/<?= sprintf("%04d-%02d-%02d", $year, $month, $day) ?>" 
                                   class="btn btn-outline-primary btn-sm m-1">
                                    <?= $day ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
<!--**********************************
    Content body end
***********************************-->