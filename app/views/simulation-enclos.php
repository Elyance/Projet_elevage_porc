<?php
    $base_url = Flight::get('flight.base_url');
?>
<style>
.simulation-form-container {
    max-width: 430px;
    margin: 48px auto 0 auto;
    background: #f9f6f1;
    border-radius: 18px;
    box-shadow: 0 4px 24px #0001;
    padding: 36px 38px 30px 38px;
    border: 2px solid #d6cfc2;
    font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
}
.simulation-form-container h2 {
    text-align: center;
    color: #7c5e2a;
    margin-bottom: 28px;
    font-weight: 700;
    letter-spacing: 1px;
}
.simulation-form label {
    display: block;
    margin-bottom: 20px;
    color: #4e3f26;
    font-size: 16px;
    font-weight: 500;
}
.simulation-form input[type="number"] {
    width: 100%;
    padding: 10px 14px;
    border-radius: 7px;
    border: 1.5px solid #b6a88a;
    font-size: 15px;
    margin-top: 6px;
    background: #fff;
    transition: border-color 0.2s;
}
.simulation-form input[type="number"]:focus {
    border-color: #7c5e2a;
    outline: none;
}
.simulation-form button[type="submit"] {
    width: 100%;
    background: linear-gradient(90deg, #7c5e2a 60%, #b6a88a 100%);
    color: #fff;
    border: none;
    border-radius: 7px;
    padding: 13px 0;
    font-size: 17px;
    font-weight: 600;
    margin-top: 22px;
    cursor: pointer;
    box-shadow: 0 2px 8px #7c5e2a22;
    transition: background 0.2s;
    letter-spacing: 1px;
}
.simulation-form button[type="submit"]:hover {
    background: linear-gradient(90deg, #b6a88a 0%, #7c5e2a 100%);
}
@media (max-width: 600px) {
    .simulation-form-container {
        padding: 18px 8px 16px 8px;
    }
    .simulation-form label {
        font-size: 15px;
    }
}
</style>

<div class="simulation-form-container">
    <h2>Simulation de dimension d'enclos</h2>
    <form class="simulation-form" method="post" action="<?= $base_url?>/simulation/enclos">
        <label>
            Nombre de porcelets (7–20kg):
            <input type="number" name="porcelets" min="0" required>
        </label>
        <label>
            Nombre de porcs (20–120kg):
            <input type="number" name="porcs" min="0" required>
        </label>
        <label>
            Nombre de truies (&gt;150kg):
            <input type="number" name="truies" min="0" required>
        </label>
        <label>
            Nombre de verrats (&gt;200kg):
            <input type="number" name="verrats" min="0" value="0">
        </label>
        <button type="submit">Simuler</button>
    </form>
</div>