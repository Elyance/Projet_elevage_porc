INSERT INTO races_porcs (nom_race, description, besoins_nutritionnels, duree_engraissement_jours) VALUES
('Large White', 'Race blanche très répandue, croissance rapide', 'Besoin élevé en protéines (16-18%)', 180),
('Landrace', 'Race blanche allongée, bonne qualité de viande', 'Nécessite des acides aminés équilibrés', 190),
('Duroc', 'Race rouge, viande persillée de qualité', 'Alimentation riche en énergie', 210),
('Piétrain', 'Race musclée, rendement carcasse élevé', 'Attention au stress alimentaire', 170),
('Gascon', 'Race rustique locale', 'Adaptée au pâturage', 240);

INSERT INTO aliments (nom_aliment, prix_kg, stock_kg, apports_nutritionnels, contact_fournisseur, conso_journaliere_kg_par_porc) VALUES
('Maïs grain', 0.35, 500.00, 'Energie: 3300 kcal/kg, Protéines: 8%', '0601020304', 0.8),
('Tourteau de soja', 0.55, 300.00, 'Protéines: 45%, Lysine: 2.8%', '0602030405', 0.3),
('Orge', 0.30, 400.00, 'Energie: 2800 kcal/kg, Fibres: 5%', '0603040506', 0.6),
('Son de blé', 0.25, 200.00, 'Fibres: 12%, Energie modérée', '0604050607', 0.4),
('Mélange complet', 0.60, 350.00, 'Equilibré: 16% protéines, vitamines', '0605060708', 1.0);


INSERT INTO porcs (id_race, date_naissance, poids_actuel_kg, date_mise_en_engraissement, est_en_engraissement) VALUES
(1, '2023-01-15', 85.5, '2023-06-01', TRUE),
(1, '2023-02-20', 78.2, '2023-06-10', TRUE),
(2, '2023-03-10', 92.0, '2023-07-01', TRUE),
(3, '2023-01-30', 88.7, '2023-06-15', TRUE),
(5, '2022-12-25', 102.5, '2023-05-20', FALSE);

INSERT INTO historique_alimentation (id_porc, id_aliment, quantite_kg, date_nourrissage) VALUES
(1, 1, 2.5, '2023-10-01 08:30:00'),
(1, 2, 1.0, '2023-10-01 08:30:00'),
(2, 3, 3.0, '2023-10-01 09:15:00'),
(3, 5, 2.8, '2023-10-01 10:00:00'),
(4, 1, 2.0, '2023-10-01 10:45:00');

INSERT INTO reapprovisionnement_aliments (id_aliment, quantite_kg, date_reappro, cout_total) VALUES
(1, 200.00, '2023-09-15 14:00:00', 70.00),
(2, 150.00, '2023-09-20 11:30:00', 82.50),
(3, 100.00, '2023-09-25 10:00:00', 30.00),
(5, 80.00, '2023-09-28 16:45:00', 48.00);

