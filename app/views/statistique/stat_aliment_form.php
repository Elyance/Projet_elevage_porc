<?php
?>
<div class="container">
    <h2>Statistiques des aliments achetés</h2>
    <form method="post" action="<?= BASE_URL ?>/statistiques/aliments">
        <label>Année :
            <input type="number" name="annee" value="<?= date('Y') ?>" min="2000" max="<?= date('Y') ?>" required>
        </label>
        <button type="submit">Afficher les statistiques</button>
    </form>
</div>