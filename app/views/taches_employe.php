<?php
// views/taches_employe.php
// Liste des tâches assignées à un employé avec cases à cocher
?>
<h2>Tâches assignées à <?= htmlspecialchars($employe_nom) ?></h2>
<form method="post" action="<?= BASE_URL ?>/tache/done">
    <input type="hidden" name="id_employe" value="<?= $id_employe ?>">
    <ul>
        <?php foreach ($taches as $tache): ?>
            <li>
                <input type="checkbox" name="taches_done[]" value="<?= $tache['id_tache_employe'] ?>" <?= $tache['statut']==='terminee' ? 'checked disabled' : '' ?>>
                <?= htmlspecialchars($tache['nom_tache']) ?>
                <?php if ($tache['statut']==='terminee'): ?> <em>(accomplie)</em> <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <button type="submit">DONE</button>
</form>
