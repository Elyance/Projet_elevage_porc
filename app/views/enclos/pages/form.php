<?php
$isCreat = isset($enclo);
?>

<?php
$type[0] = 'Interieur';
$type[1] = 'Exterieur';
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-validation">
                        <form class="form-valide" action="" method="post">
                            <?php if (isset($enclo)) { ?>
                                <input type="hidden" name="id" value="<?= $enclo['id'] ?>">
                            <?php } ?>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="nom">Nom <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Ex : Enclos A" value="<?php print ($isCreat ? $enclo['nom'] : '') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="type">Type <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <select class="form-control" id="type" name="type">
                                        <option value="">Please select</option>
                                        <?php for ($i = 0; $i < count($type); $i++) { ?>
                                            <option value="<?= $type[$i] ?>"
                                                <?php
                                                if ($isCreat && $enclo['type'] == $type[$i]) {
                                                    echo 'selected';
                                                }
                                                ?>><?= $type[$i] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="superficie">Superficie <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="number" class="form-control" id="superficie" name="superficie" placeholder="5" value="<?php print ($isCreat ? $enclo['superficie'] : '') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="capacite">Capacite <span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="number" class="form-control" id="capacite" name="capacite" placeholder="5" value="<?php print ($isCreat ? $enclo['capacite'] : '') ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>