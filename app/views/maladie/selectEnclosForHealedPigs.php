<?php
/**
 * View to select a new enclosure for healed pigs after successful treatment
 */
?>
<form method="post" action="/diagnostic/markSuccess/<?php echo $diagnostic['id_diagnostic']; ?>">
    <label for="id_enclos_destination">Select Destination Enclosure:</label>
    <select name="id_enclos_destination" id="id_enclos_destination">
        <?php foreach ($enclosList as $enclos): ?>
            <option value="<?php echo $enclos['id_enclos']; ?>">
                <?php echo $enclos['nom_type'] . ' - ID: ' . $enclos['id_enclos']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Confirm">
</form>