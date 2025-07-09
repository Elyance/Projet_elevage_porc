INSERT INTO bao_sante_type_evenement(nom_type_evenement, prix)
VALUES ('Vaccination', 50.00),
       ('Consultation vétérinaire', 100.00),
       ('Insemination', 75.00);

INSERT INTO bao_employe_poste (nom_poste, salaire_base) VALUES
('Technicien reproduction', 1200),
('Technicien alimentation', 1100);

INSERT INTO bao_employe (nom_employe, prenom_employe, id_employe_poste, adresse, contact_telephone, date_recrutement, statut)
VALUES
('Rakoto', 'Jean', 1, 'Antananarivo', '0341234567', '2024-01-15', 'actif'),
('Ranaivo', 'Marie', 2, 'Toamasina', '0347654321', '2024-02-10', 'actif');

INSERT INTO bao_client (nom_client, type_profil, adresse, contact_telephone, contact_email) VALUES
('AgriCorp', 'entreprise', 'Tamatave', '0339876543', 'contact@agricorp.com'),
('Rabe', 'particulier', 'Fianarantsoa', '0341112233', 'rabe@email.com');


-- Insert initial data
Insert into bao_enclos_type(nom_enclos_type)
VALUES ('truie'), ('portee');

INSERT INTO bao_type_porc (nom_type, age_min, age_max, poids_min, poids_max, espace_requis)
VALUES 
('Truie', 12, 36, 100.00, 200.00, 10.00),  -- 1 enclosure type for sows
('Portee', 0, 12, 0.50, 50.00, 5.00),      -- 1 enclosure type for litters
('Quarantaine', 0, 12, 0.50, 50.00, 5.00), 
('Porcelet', 0, 60, 1.5, 20.0, 0.5),
('Jeune', 61, 120, 20.1, 50.0, 1.0),
('Engraissement', 121, 180, 50.1, 100.0, 1.5),
('Adulte', 181, 240, 100.1, 150.0, 2.0),
('Reproducteur', 241, 365, 150.1, 250.0, 2.5);-- 1 enclosure type for quarantine (added as per your list)

-- Insert enclosures (1 Truie + 3 Portee)
INSERT INTO bao_enclos (enclos_type, surface)
VALUES 
(1, 20),  -- Enclos 1: Truie type
(2, 15),  -- Enclos 2: Portee type
(2, 15),  -- Enclos 3: Portee type
(2, 15),  -- Enclos 4: Portee type
(3, 15),  -- Enclos 4: Portee type
(3, 15);  -- Enclos 4: Portee type


-- Insertion des races de porcs
INSERT INTO races_porcs (nom_race, description, besoins_nutritionnels, duree_engraissement_jours) VALUES
('Large White', 'Race blanche très répandue, croissance rapide', 'Besoin élevé en protéines (16-18%)', 180),
('Landrace', 'Race blanche allongée, bonne qualité de viande', 'Nécessite des acides aminés équilibrés', 190),
('Duroc', 'Race rouge, viande persillée de qualité', 'Alimentation riche en énergie', 210),
('Piétrain', 'Race musclée, rendement carcasse élevé', 'Attention au stress alimentaire', 170),
('Gascon', 'Race rustique locale', 'Adaptée au pâturage', 240);

-- Insert sows
-- Insert enclos_portee (initialize all Portee enclosures and assign litters to Enclos 2)
INSERT INTO bao_enclos_portee (id_enclos, id_portee, quantite_total, poids_estimation, statut_vente,nombre_jour_ecoule)
VALUES 
(1, NULL, 1, 150.500, 'non possible',334),  -- Enclos 2 with Litter 1 (5 pigs)
(1, NULL, 1, 145.750, 'non possible',334);  -- Enclos 2 with Litter 2 (4 pigs)

INSERT INTO bao_truie (id_enclos, id_race, poids, date_entree)
VALUES 
(1, 1, 150.500, '2025-06-01'),  -- Truie 1
(1, 1, 145.750, '2025-06-05');  -- Truie 2

-- Insert reproduction cycles
INSERT INTO bao_cycle_reproduction (id_truie, date_debut_cycle, date_fin_cycle,nombre_males,nombre_femelles, etat)
VALUES 
(1, '2025-06-10', '2025-07-01',2,3, 'termine'),  -- Cycle for Truie 1
(2, '2025-06-12', '2025-07-03',2,2, 'termine'),  -- Cycle for Truie 2
(2, '2025-06-12', '2025-07-03',0,2, 'termine');  -- Cycle for Truie 2

-- Insert litters
INSERT INTO bao_portee (id_truie, id_race, nombre_males, nombre_femelles, date_naissance, id_cycle_reproduction)
VALUES 
(1, 1, 2, 3, '2025-07-01', 1),  -- Litter 1: 2 males, 3 females
(2, 1, 2, 2, '2025-07-03', 2),  -- Litter 2: 2 males, 2 females
(2, 1, 0, 2, '2025-07-03', 3);  -- Litter 2: 2 males, 2 females

-- Insert enclos_portee (initialize all Portee enclosures and assign litters to Enclos 2)
INSERT INTO bao_enclos_portee (id_enclos, id_portee, quantite_total, poids_estimation, statut_vente,nombre_jour_ecoule)
VALUES 
(2, 1, 5, 125.0, 'non possible',115),  -- Enclos 2 with Litter 1 (5 pigs)
(2, 2, 4, 125.0, 'non possible',336),  -- Enclos 2 with Litter 2 (4 pigs)
(2, 3, 2, 125.0, 'non possible',339),  -- Enclos 2 with Litter 2 (4 pigs)
(3, NULL, 0, 0.0, 'non possible',0), -- Enclos 3 initialized with no litter
(4, NULL, 0, 0.0, 'non possible',0), -- Enclos 4 initialized with no litter
(5, NULL, 0, 0.0, 'non possible',0), -- Enclos 3 initialized with no litter
(6, NULL, 0, 0.0, 'non possible',0); -- Enclos 4 initialized with no litter

-- Insertion des aliments
INSERT INTO aliments (nom_aliment, prix_kg, stock_kg, apports_nutritionnels, contact_fournisseur, conso_journaliere_kg_par_porc) VALUES
('Maïs grain', 0.35, 500.00, 'Energie: 3300 kcal/kg, Protéines: 8%', '0601020304', 0.8),
('Tourteau de soja', 0.55, 300.00, 'Protéines: 45%, Lysine: 2.8%', '0602030405', 0.3),
('Orge', 0.30, 400.00, 'Energie: 2800 kcal/kg, Fibres: 5%', '0603040506', 0.6),
('Son de blé', 0.25, 200.00, 'Fibres: 12%, Energie modérée', '0604050607', 0.4),
('Mélange complet', 0.60, 350.00, 'Equilibré: 16% protéines, vitamines', '0605060708', 1.0);
-- Insertion des réapprovisionnements
INSERT INTO reapprovisionnement_aliments (id_aliment, quantite_kg, date_reappro, cout_total) VALUES
(1, 200.00, '2023-09-15 14:00:00', 70.00),
(2, 150.00, '2023-09-20 11:30:00', 82.50),
(3, 100.00, '2023-09-25 10:00:00', 30.00),
(5, 80.00, '2023-09-28 16:45:00', 48.00);

-- Insert into bao_symptome
INSERT INTO bao_symptome (nom_symptome, description) VALUES
('Fièvre', 'Elévation anormale de la température corporelle'),
('Diarrhée', 'Selles fréquentes et liquides'),
('Toux', 'Rales ou toux persistante'),
('Perte d appétit', 'Réduction ou absence de prise alimentaire'),
('Léthargie', 'Faiblesse ou manque d énergie');

-- Insert into bao_maladie
INSERT INTO bao_maladie (nom_maladie, description, dangerosite) VALUES
('Grippe Porcine', 'Infection respiratoire virale chez les porcs', 'moderee'),
('Dysenterie Porcine', 'Infection bactérienne causant des diarrhées sévères', 'elevee'),
('Peste Porcine', 'Maladie virale hautement contagieuse et mortelle', 'elevee'),
('Anémie Infectieuse', 'Affection causant une anémie due à un parasite', 'faible');

-- Insert into bao_maladie_symptome
INSERT INTO bao_maladie_symptome (id_maladie, id_symptome) VALUES
(1, 1), -- Grippe Porcine -> Fièvre
(1, 3), -- Grippe Porcine -> Toux
(2, 2), -- Dysenterie Porcine -> Diarrhée
(2, 4), -- Dysenterie Porcine -> Perte d'appétit
(3, 1), -- Peste Porcine -> Fièvre
(3, 2), -- Peste Porcine -> Diarrhée
(3, 5), -- Peste Porcine -> Léthargie
(4, 4), -- Anémie Infectieuse -> Perte d'appétit
(4, 5); -- Anémie Infectieuse -> Léthargie

INSERT INTO bao_diagnostic (
    id_diagnostic, id_maladie,
    id_enclos_portee, id_enclos_portee_original,
    nombre_males_infectes, nombre_femelles_infectes,
    date_apparition, date_diagnostic,
    desc_traitement, statut, prix_traitement
) VALUES (
    1, 1,
    3, 3,
    2, 2,
    '2025-07-07', '2025-07-08',
    'sida be', 'signale', 50.00
);


-- Insertion historique d'alimentation
-- INSERT INTO historique_alimentation (id_enclos, id_aliment, quantite_kg, id_enclos_portee) VALUES
-- (1, 1, 25.0, 1),
-- (1, 2, 10.0, 1),
-- (1, 3, 30.0, 2),
-- (2, 5, 28.0, 3),
-- (2, 1, 20.0, 4),
-- (5, 4, 15.0, 5);