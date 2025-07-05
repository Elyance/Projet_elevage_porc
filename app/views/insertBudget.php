<form action="/insertionBudget" method="post">
    <select name="" id="">
        <?php foreach ($types as $type) {  ?>
            <option value="<?php echo  $type['id'] ?>"><?php echo  $type['libele'] ?></option>
        <?php } ?>
    </select>
    <select name="" id="">
        <?php foreach ($natures as $nature) {  ?>
            <option value="<?php echo  $nature['id'] ?>"><?php echo  $nature['libele'] ?></option>
        <?php } ?>
    </select>
    <fieldset>
        <legend>Valeur</legend>
        <input type="number" name="" id="" placeholder="prevision">
        <input type="number" name="" id="" placeholder="realisation">
    </fieldset>
    <button type="submit">Envoyer</button>
</form>