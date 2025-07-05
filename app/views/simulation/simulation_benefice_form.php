<?php
?>
<style>
.container {
    background-color: #fff;
    padding: 32px 36px 28px 36px;
    border-radius: 14px;
    box-shadow: 0 4px 24px #0001;
    max-width: 900px;
    margin: 48px auto 0 auto;
    font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
}
.container h1 {
    text-align: center;
    color: #4e73df;
    margin-bottom: 28px;
    font-weight: 700;
    letter-spacing: 1px;
}
.container h3 {
    color: #7c5e2a;
    margin-top: 24px;
    margin-bottom: 12px;
    font-size: 20px;
}
.row {
    display: flex;
    gap: 18px;
    margin-bottom: 10px;
}
.col {
    flex: 1;
}
.form-group {
    margin-bottom: 12px;
}
label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: #2d3748;
    font-size: 15px;
}
input[type="number"], select {
    width: 100%;
    padding: 8px 12px;
    border-radius: 7px;
    border: 1.5px solid #b6c2d1;
    font-size: 15px;
    background: #f8fafc;
    transition: border-color 0.2s;
}
input[type="number"]:focus, select:focus {
    border-color: #4e73df;
    outline: none;
}
button[type="submit"] {
    width: 100%;
    background: linear-gradient(90deg, #4e73df 60%, #36b9cc 100%);
    color: #fff;
    border: none;
    border-radius: 7px;
    padding: 13px 0;
    font-size: 17px;
    font-weight: 600;
    margin-top: 22px;
    cursor: pointer;
    box-shadow: 0 2px 8px #4e73df22;
    transition: background 0.2s;
    letter-spacing: 1px;
}
button[type="submit"]:hover {
    background: linear-gradient(90deg, #36b9cc 0%, #4e73df 100%);
}
@media (max-width: 700px) {
    .container { padding: 18px 8px 16px 8px; }
    .row { flex-direction: column; gap: 0; }
}
.details {
    margin-top: 32px;
    background: #f8fafc;
    border-radius: 10px;
    padding: 18px 22px;
    color: #444;
    font-size: 15px;
    border-left: 4px solid #4e73df;
}
.details ul { margin: 0 0 0 18px; }
</style>
<div class="container">
    <h1>🐷 Simulateur d'élevage de porcs</h1>
    <form method="post" action="<?= Flight::get('flight.base_url') ?>/simulation/benefice">
        <h3>Paramètres de départ</h3>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Nombre de truies de départ:</label>
                    <input type="number" name="nbTruies" value="5" min="1" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Nombre de porcs de départ:</label>
                    <input type="number" name="nbPorcs" value="10" min="0" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Nombre de porcelets de départ:</label>
                    <input type="number" name="nbPorcelets" value="0" min="0" required>
                </div>
            </div>
        </div>

        <h3>Paramètres de reproduction et vente</h3>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Porcelets par truie par an:</label>
                    <input type="number" name="porceletsParAn" value="12" min="1" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Mois de naissance:</label>
                    <select name="moisNaissance" required>
                        <option value="1">Janvier</option>
                        <option value="2">Février</option>
                        <option value="3">Mars</option>
                        <option value="4">Avril</option>
                        <option value="5">Mai</option>
                        <option value="6">Juin</option>
                        <option value="7">Juillet</option>
                        <option value="8">Août</option>
                        <option value="9">Septembre</option>
                        <option value="10" selected>Octobre</option>
                        <option value="11">Novembre</option>
                        <option value="12">Décembre</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Mois pour maturation (porcelet → porc):</label>
                    <input type="number" name="moisMaturation" value="6" min="1" max="12" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Vente automatique:</label>
                    <select name="venteAutomatique">
                        <option value="true" selected>Oui - Vendre dès maturation</option>
                        <option value="false">Non - Garder les porcs</option>
                    </select>
                </div>
            </div>
        </div>

        <h3>Prix et coûts (en Ariary)</h3>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Prix aliment truie/mois:</label>
                    <input type="number" name="prixAlimentTruie" value="78000" min="0" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Prix aliment porc/mois:</label>
                    <input type="number" name="prixAlimentPorc" value="78000" min="0" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Prix aliment porcelet/mois:</label>
                    <input type="number" name="prixAlimentPorcelet" value="7800" min="0" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Prix de vente d'un porc:</label>
                    <input type="number" name="prixVentePorc" value="1200000" min="0" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Nombre de mois à simuler:</label>
                    <input type="number" name="nbMoisSimulation" value="24" min="12" max="60" required>
                </div>
            </div>
        </div>

        <button type="submit">🚀 Lancer la simulation</button>
    </form>
    <div class="details">
        <b>Détails de la simulation :</b>
        <ul>
            <li>Vous pouvez ajuster tous les paramètres avant de lancer la simulation.</li>
            <li>Le simulateur prend en compte la reproduction annuelle, la maturation, la vente automatique ou non, et tous les coûts d’alimentation.</li>
            <li>Le résultat affichera mois par mois les effectifs, les ventes, les coûts, les revenus et le bénéfice cumulé.</li>
            <li>Les valeurs par défaut sont adaptées à un élevage classique, mais vous pouvez les personnaliser selon votre exploitation.</li>
        </ul>
    </div>
</div>