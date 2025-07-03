<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h5>📊 Statistiques</h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Aliments en stock :</strong> <?= count($aliments) ?>
                </li>
                <li class="list-group-item">
                    <strong>Stock total :</strong> 
                    <?= number_format(array_sum(array_column($aliments, 'stock_kg')), 2) ?> kg
                </li>
            </ul>
        </div>
    </div>
</div>