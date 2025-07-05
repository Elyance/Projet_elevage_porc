
<?php
$isCreat = isset($typePorc);
?>


<h2>Formulaire de   
    
<?php
if ($isCreat) {
    echo 'modification';
} else {
    echo 'creation';
}
?>

type porc</h2>


<p><a href="/typePorc">Revenir a la list</a></p>
<form action="" method="post">

    <?php if (isset($typePorc)) { ?>
        <input type="hidden" name="id" value="<?= $typePorc['id'] ?>">
    <?php } ?>

    <div>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?php print ($isCreat ? $typePorc['nom'] : '') ?>"  >
    </div>
    <div>
        <label for="age_min">Age minimum</label>
        <input type="number" name="age_min" id="age_min" value="<?php print ($isCreat ? $typePorc['age_min'] : '') ?>">
    </div>
    <div>
        <label for="age_max">Age max</label>
        <input type="number" name="age_max" id="age_max" value="<?php print ($isCreat ? $typePorc['age_max'] : '') ?>">
    </div>
    <div>
        <label for="poids_min">Poids minimum</label>
        <input type="number" name="poids_min" id="poids_min" value="<?php print ($isCreat ? $typePorc['poids_min'] : '') ?>">
    </div>
    <div>
        <label for="poids_max">Poids maximum</label>
        <input type="number" name="poids_max" id="poids_max" value="<?php print ($isCreat ? $typePorc['poids_max'] : '') ?>">
    </div>
    <div>
        <label for="espace_requis">Espace requis par animal</label>
        <input type="number" name="espace_requis" id="espace_requis" value="<?php print ($isCreat ? $typePorc['espace_requis'] : '') ?>">
    </div>
    <button type="submit">Valider</button>
</form>