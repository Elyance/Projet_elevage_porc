-- Connexion à la base de données
\c bao_gestion_porc;

-- Insérer des données dans bao_regle_gestion pour le prix des aliments
INSERT INTO bao_regle_gestion (nom_regle, valeur) 
VALUES ('prix_achat_aliment', 3000.00)
ON CONFLICT (nom_regle) DO NOTHING;

-- Insérer des données dans bao_stock pour les mouvements d'aliments
INSERT INTO bao_stock (nom_stock, type_stock, stockage_actuel)
VALUES 
    ('Aliment Porc', 'aliment', 300)
ON CONFLICT DO NOTHING;

-- Insérer des données dans bao_stockage_mouvement (achats d'aliments)
    INSERT INTO bao_stockage_mouvement (id_aliment_type, date_mouvement, type_mouvement, quantite)
    VALUES 
        (1, '2025-06-01', 'ajout', 100), -- 100 * 5.00 = 500.00 €
        (1, '2025-06-15', 'ajout', 200); -- 200 * 5.00 = 1000.00 €

-- Insérer des données dans bao_employe pour les salaires
INSERT INTO bao_employe (nom_employe, prenom_employe, poste)
VALUES 
    ('Dupont', 'Paul', 'Ouvrier'),
    ('Martin', 'Sophie', 'Vétérinaire')
ON CONFLICT DO NOTHING;

-- Insérer des données dans bao_salaire
INSERT INTO bao_salaire (id_employe, montant, date_salaire, statut)
VALUES 
    (1, 2000.00, '2025-06-01', 'paye'),
    (2, 2500.00, '2025-06-01', 'paye');

-- Insérer des données dans bao_maladie pour les diagnostics
INSERT INTO bao_maladie (nom_maladie, description_maladie)
VALUES 
    ('Grippe porcine', 'Infection virale')
ON CONFLICT DO NOTHING;

-- Insérer des données dans bao_truie pour les diagnostics
INSERT INTO bao_truie (id_enclos, poids, date_entree)
VALUES 
    (1, 150.500000, '2025-01-01'),
    (1, 145.750000, '2025-02-01')
ON CONFLICT DO NOTHING;

-- Insérer des données dans bao_diagnostic
INSERT INTO bao_diagnostic (id_animal, id_maladie, date_diagnostic, prix_traitement)
VALUES 
    (1, 1, '2025-06-02', 150.00),
    (2, 1, '2025-06-03', 200.00);

-- Afficher les données de la vue depenses_totales
SELECT 
    type_depense,
    date_depense,
    ROUND(montant, 2) AS montant
FROM 
    depenses_totales
ORDER BY 
    date_depense;