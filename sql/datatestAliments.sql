-- Insertion des types de porcs
INSERT INTO bao_type_porc (nom_type, age_min, age_max, poids_min, poids_max, espace_requis) VALUES
('Porcelet', 0, 60, 1.5, 20.0, 0.5),
('Jeune', 61, 120, 20.1, 50.0, 1.0),
('Engraissement', 121, 180, 50.1, 100.0, 1.5),
('Adulte', 181, 240, 100.1, 150.0, 2.0),
('Reproducteur', 241, 365, 150.1, 250.0, 2.5);

-- Insertion des enclos (en respectant la structure avec enclos_type et stockage)
INSERT INTO bao_enclos (enclos_type, stockage) VALUES
(3, 30),  -- Engraissement
(3, 25),  -- Engraissement
(4, 20),  -- Adulte
(5, 10),  -- Reproducteur
(1, 40);  -- Porcelet

-- Insertion des races de porcs
INSERT INTO races_porcs (nom_race, description, besoins_nutritionnels, duree_engraissement_jours) VALUES
('Large White', 'Race blanche très répandue, croissance rapide', 'Besoin élevé en protéines (16-18%)', 180),
('Landrace', 'Race blanche allongée, bonne qualité de viande', 'Nécessite des acides aminés équilibrés', 190),
('Duroc', 'Race rouge, viande persillée de qualité', 'Alimentation riche en énergie', 210),
('Piétrain', 'Race musclée, rendement carcasse élevé', 'Attention au stress alimentaire', 170),
('Gascon', 'Race rustique locale', 'Adaptée au pâturage', 240);

-- Insertion des truies (après création des enclos)
INSERT INTO bao_truie (id_enclos, id_race, poids, date_entree) VALUES
(4, 1, 185.5, '2022-11-15'),  -- Reproductrice Large White
(4, 2, 192.0, '2022-10-20'),  -- Reproductrice Landrace
(4, 3, 178.7, '2023-01-10'),  -- Reproductrice Duroc
(4, 1, 182.3, '2022-12-05'),  -- Reproductrice Large White
(4, 5, 175.8, '2023-02-18');   -- Reproductrice Gascon

-- Insertion des portées (après création des truies)
INSERT INTO bao_portee (id_truie, id_race, date_naissance, nombre_males, nombre_femelles) VALUES
(1, 1, '2023-05-15', 6, 5),   -- Portée de Large White
(2, 2, '2023-06-20', 5, 7),   -- Portée de Landrace
(3, 3, '2023-07-10', 7, 6),   -- Portée de Duroc
(1, 1, '2023-08-25', 8, 4),   -- Portée de Large White
(5, 5, '2023-09-05', 4, 5);   -- Portée de Gascon

-- Insertion des porcs dans les enclos (après création des enclos et portées)
INSERT INTO bao_enclos_portee (id_enclos, id_portee, poids_estimation, nombre_jour_ecoule, statut_vente, quantite_males, quantite_femelles) VALUES
(1, 1, 65.5, 120, 'possible', 6, 5),     -- Large White en engraissement
(1, 2, 70.2, 110, 'possible', 5, 7),     -- Landrace en engraissement
(2, 3, 68.7, 100, 'non possible', 7, 6),  -- Duroc en engraissement
(2, 4, 72.0, 90, 'possible', 8, 4),      -- Large White en engraissement
(5, 5, 15.5, 30, 'non possible', 4, 5);   -- Gascon en nurserie

-- Insertion des aliments
INSERT INTO aliments (nom_aliment, prix_kg, stock_kg, apports_nutritionnels, contact_fournisseur, conso_journaliere_kg_par_porc) VALUES
('Maïs grain', 0.35, 500.00, 'Energie: 3300 kcal/kg, Protéines: 8%', '0601020304', 0.8),
('Tourteau de soja', 0.55, 300.00, 'Protéines: 45%, Lysine: 2.8%', '0602030405', 0.3),
('Orge', 0.30, 400.00, 'Energie: 2800 kcal/kg, Fibres: 5%', '0603040506', 0.6),
('Son de blé', 0.25, 200.00, 'Fibres: 12%, Energie modérée', '0604050607', 0.4),
('Mélange complet', 0.60, 350.00, 'Equilibré: 16% protéines, vitamines', '0605060708', 1.0);

-- Insertion historique des truies dans les enclos
INSERT INTO bao_enclos_truie (id_enclos, id_truie) VALUES
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5);

-- Insertion des réapprovisionnements
INSERT INTO reapprovisionnement_aliments (id_aliment, quantite_kg, date_reappro, cout_total) VALUES
(1, 200.00, '2023-09-15 14:00:00', 70.00),
(2, 150.00, '2023-09-20 11:30:00', 82.50),
(3, 100.00, '2023-09-25 10:00:00', 30.00),
(5, 80.00, '2023-09-28 16:45:00', 48.00);

-- Insertion historique d'alimentation
INSERT INTO historique_alimentation (id_enclos, id_aliment, quantite_kg, id_enclos_portee) VALUES
(1, 1, 25.0, 1),
(1, 2, 10.0, 1),
(1, 3, 30.0, 2),
(2, 5, 28.0, 3),
(2, 1, 20.0, 4),
(5, 4, 15.0, 5);