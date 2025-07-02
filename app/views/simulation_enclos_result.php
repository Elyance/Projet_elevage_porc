<?php
?>
<style>
.ferme-plan {
    display: flex;
    flex-direction: row;
    gap: 40px;
    margin-top: 30px;
    justify-content: center;
    align-items: flex-start;
}
.enclos-col {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 18px;
}
.enclos {
    border: 2px solid #4e73df;
    border-radius: 12px;
    background: #f8fafc;
    width: 120px;
    height: 80px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    box-shadow: 0 2px 8px #0001;
    font-size: 15px;
    font-weight: 500;
    position: relative;
}
.enclos.verrat { border-color: #e74a3b; background: #fff5f5; }
.enclos.truie { border-color: #f6c23e; background: #fffbe6; }
.enclos.porc { border-color: #1cc88a; background: #f0fff5; }
.enclos.porcelet { border-color: #36b9cc; background: #f0fcff; }
.enclos .label {
    font-size: 13px;
    color: #888;
    font-weight: 400;
}
.couloir {
    width: 40px;
    min-height: 350px;
    background: repeating-linear-gradient(
        135deg, #e2e3e5, #e2e3e5 10px, #f8fafc 10px, #f8fafc 20px
    );
    border-radius: 8px;
    margin: 0 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #888;
    font-size: 14px;
    writing-mode: vertical-rl;
    text-align: center;
    font-weight: bold;
    border: 1.5px dashed #bbb;
}
.legend {
    margin-top: 30px;
    display: flex;
    gap: 25px;
    justify-content: center;
}
.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}
.legend-color {
    width: 18px; height: 18px; border-radius: 4px; display: inline-block;
    border: 2px solid #888;
}
.legend-porcelet { background: #36b9cc22; border-color: #36b9cc; }
.legend-porc { background: #1cc88a22; border-color: #1cc88a; }
.legend-truie { background: #f6c23e33; border-color: #f6c23e; }
.legend-verrat { background: #e74a3b22; border-color: #e74a3b; }
</style>

<h2>Plan schématique de la ferme</h2>
<div class="ferme-plan">
    <div class="enclos-col">
        <?php for($i=1; $i<=$result['enclos_porcelets']; $i++): ?>
            <div class="enclos porcelet">
                Porcelets<br>
                <span class="label"><?= round($result['surface_porcelets']/$result['enclos_porcelets'],2) ?> m²</span>
            </div>
        <?php endfor; ?>
        <span style="margin-top:8px;font-size:13px;color:#36b9cc">Porcelets</span>
    </div>
    <div class="enclos-col">
        <?php for($i=1; $i<=$result['enclos_porcs']; $i++): ?>
            <div class="enclos porc">
                Porcs<br>
                <span class="label"><?= round($result['surface_porcs']/$result['enclos_porcs'],2) ?> m²</span>
            </div>
        <?php endfor; ?>
        <span style="margin-top:8px;font-size:13px;color:#1cc88a">Porcs</span>
    </div>
    <div class="couloir">
        Couloir<br>(<?= $result['largeur_couloir'] ?> m)
    </div>
    <div class="enclos-col">
        <?php for($i=1; $i<=$result['enclos_truies']; $i++): ?>
            <div class="enclos truie">
                Truies<br>
                <span class="label"><?= round($result['surface_truies']/$result['enclos_truies'],2) ?> m²</span>
            </div>
        <?php endfor; ?>
        <span style="margin-top:8px;font-size:13px;color:#f6c23e">Truies</span>
    </div>
    <div class="enclos-col">
        <?php for($i=1; $i<=$result['enclos_verrats']; $i++): ?>
            <div class="enclos verrat">
                Verrat<br>
                <span class="label"><?= round($result['surface_verrats']/$result['enclos_verrats'],2) ?> m²</span>
            </div>
        <?php endfor; ?>
        <span style="margin-top:8px;font-size:13px;color:#e74a3b">Verrats</span>
    </div>
</div>

<div class="legend">
    <div class="legend-item"><span class="legend-color legend-porcelet"></span>Porcelets</div>
    <div class="legend-item"><span class="legend-color legend-porc"></span>Porcs</div>
    <div class="legend-item"><span class="legend-color legend-truie"></span>Truies</div>
    <div class="legend-item"><span class="legend-color legend-verrat"></span>Verrats</div>
    <div class="legend-item"><span style="border-bottom:2px dashed #bbb;width:18px;display:inline-block"></span> Couloir</div>
</div>

<ul style="margin-top:30px">
    <li>Surface totale à prévoir : <b><?= $result['surface_totale'] ?> m²</b></li>
    <li>Surface couloirs (10%) : <?= $result['surface_couloir'] ?> m²</li>
    <li>Largeur minimale des couloirs : <?= $result['largeur_couloir'] ?> m</li>
</ul>