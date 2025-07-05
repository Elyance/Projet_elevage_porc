<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h5>📊 Statistiques</h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Aliments en stock :</strong> 
                    <?= isset($aliments) ? count($aliments) : '0' ?>
                </li>
                <li class="list-group-item">
                    <strong>Stock total :</strong> 
                    <?= isset($aliments) ? number_format(array_sum(array_column($aliments, 'stock_kg')), 2) : '0.00' ?> kg
                </li>
            </ul>
        </div>
    </div>
</div>