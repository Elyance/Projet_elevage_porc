<h1>Gestion de la Présence</h1>
<form method="get" action="/presence">
    <label>Mois: 
        <select name="mois" onchange="this.form.submit()">
            <?php foreach ($months as $m): ?>
                <option value="<?= $m ?>" <?= $m == $month ? "selected" : "" ?>><?= $m ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>Année: 
        <select name="annee" onchange="this.form.submit()">
            <?php foreach ($years as $y): ?>
                <option value="<?= $y ?>" <?= $y == $year ? "selected" : "" ?>><?= $y ?></option>
            <?php endforeach; ?>
        </select>
    </label>
</form>
<h2>Jours du Mois</h2>
<?php foreach ($days as $day): ?>
    <a href="/presence/detail_jour/<?= sprintf("%04d-%02d-%02d", $year, $month, $day) ?>"><?= $day ?></a> 
<?php endforeach; ?>