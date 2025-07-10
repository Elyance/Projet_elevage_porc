------------------
-- 0. INITIALIZATION
------------------
INSERT INTO bao_utilisateur_role (nom_role) VALUES ('admin'), ('emp');
INSERT INTO bao_utilisateur (nom_utilisateur, mot_de_passe, id_utilisateur_role)
VALUES ('admin', 'admin', 1);

-- Add these employee to the user table
INSERT INTO bao_utilisateur (nom_utilisateur, mot_de_passe, id_utilisateur_role) VALUES
('e1', 'e', 2),
('e2', 'ee', 2),
('e3', 'eee', 2),
('e4', 'eeee', 2);
-- Password for the emp = when creating emp, in the form add a password field

INSERT INTO bao_employe (nom_employe, prenom_employe, id_employe_poste, adresse, contact_telephone, date_recrutement, statut, id_utilisateur) VALUES
('e1', 'e', 1, 'Lot IIA 32B Tanjombato', '0341234567', '2022-05-15', 'actif', 2),
('e2', 'ee', 2, 'Ivandry', '0329876543', '2021-11-20', 'actif', 3),
('e3', 'eee', 3, 'Ambohidratrimo', '0331122334', '2023-02-10', 'actif', 4),
('e4', 'eeee', 4, 'Analakely', '0345566778', '2020-08-01', 'actif', 5);

INSERT INTO bao_aliments (nom_aliment, prix_kg, stock_kg, apports_nutritionnels, contact_fournisseur, conso_journaliere_kg_par_porc) VALUES
('Maïs grain', 0.35, 500.00, 'Energie: 3300 kcal/kg, Protéines: 8%', '0601020304', 0.8),
('Tourteau de soja', 0.55, 300.00, 'Protéines: 45%, Lysine: 2.8%', '0602030405', 0.3),
('Orge', 0.30, 400.00, 'Energie: 2800 kcal/kg, Fibres: 5%', '0603040506', 0.6),
('Son de blé', 0.25, 200.00, 'Fibres: 12%, Energie modérée', '0604050607', 0.4),
('Mélange complet', 0.60, 350.00, 'Equilibré: 16% protéines, vitamines', '0605060708', 1.0);

INSERT INTO bao_type_porc (nom_type, age_min, age_max, poids_min, poids_max, espace_requis)
VALUES 
('Truie', 12, 36, 100.00, 200.00, 10.00),  -- 1 enclosure type for sows
('Portee', 0, 12, 0.50, 50.00, 5.00),      -- 1 enclosure type for litters
('Quarantaine', 0, 12, 0.50, 50.00, 5.00), 
('Porcelet', 0, 60, 1.5, 20.0, 0.5),
('Jeune', 61, 120, 20.1, 50.0, 1.0),
('Engraissement', 121, 180, 50.1, 100.0, 1.5),
('Adulte', 181, 240, 100.1, 150.0, 2.0),
('Reproducteur', 241, 365, 150.1, 250.0, 2.5);

INSERT INTO bao_client (nom_client, type_profil, adresse, contact_telephone, contact_email) VALUES
('AgriCorp', 'entreprise', 'Tamatave', '0339876543', 'contact@agricorp.com'),
('Rabe', 'particulier', 'Fianarantsoa', '0341112233', 'rabe@email.com');

------------------
-- 1. PIG BREEDS
------------------
INSERT INTO bao_races_porcs (nom_race, description, besoins_nutritionnels, duree_engraissement_jours) VALUES
('Large White', 'Race blanche polyvalente', 'Protéines 16%, Energie 3200 kcal', 180),
('Landrace', 'Race longue et maigre', 'Protéines 17%, Energie 3100 kcal', 170),
('Duroc', 'Race rousse à viande persillée', 'Protéines 15%, Energie 3300 kcal', 190),
('Piétrain', 'Race musculaire hyperprolifique', 'Protéines 18%, Energie 3400 kcal', 160);

------------------
-- 2. ENCLOSURES
------------------
INSERT INTO bao_enclos (enclos_type, surface) VALUES
(1, 15), (1, 12), (1, 18),  -- Sow enclosures (type 1)
(2, 25), (2, 30), (2, 20),  -- Litter enclosures (type 2)
(3, 20), (3, 18),            -- Quarantine enclosures (type 3)
(4, 40), (4, 35),            -- Young pig enclosures
(5, 50), (5, 45);            -- Fattening enclosures

------------------
-- 3. SOWS
------------------
INSERT INTO bao_truie (id_enclos, id_race, poids, date_entree) VALUES
(1, 1, 185.5, '2024-01-15'),
(1, 2, 172.3, '2023-11-20'),
(2, 1, 195.0, '2023-09-10'),
(3, 4, 168.7, '2024-02-01'),
(2, 3, 182.4, '2023-12-05');

------------------
-- 4. REPRODUCTION
------------------
-- Inseminations
INSERT INTO bao_insemination (id_truie, date_insemination, resultat) VALUES
(1, '2024-03-10', 'succes'),
(2, '2024-03-15', 'succes'),
(3, '2024-04-01', 'en cours'),
(4, '2024-03-20', 'succes');

-- Reproduction Cycles
INSERT INTO bao_cycle_reproduction (id_truie, date_debut_cycle, date_fin_cycle, nombre_males, nombre_femelles, id_insemination, etat) VALUES
(1, '2024-03-10', '2024-06-28', 6, 7, 1, 'termine'),
(2, '2024-03-15', '2024-07-03', 5, 8, 2, 'termine'),
(4, '2024-03-20', NULL, NULL, NULL, 4, 'en cours');

------------------
-- 5. LITTERS
------------------
INSERT INTO bao_portee (id_truie, id_race, nombre_males, nombre_femelles, date_naissance, id_cycle_reproduction) VALUES
(1, 1, 6, 7, '2024-06-28', 1),
(2, 2, 5, 8, '2024-07-03', 2);

------------------
-- 6. ENCLOS-LITTER ASSIGNMENTS
------------------
INSERT INTO bao_enclos_portee (id_enclos, id_portee, quantite_total, poids_estimation, nombre_jour_ecoule, statut_vente) VALUES
(4, 1, 13, 5.2, 45, 'non possible'),
(5, 2, 13, 6.1, 40, 'non possible'),
(6, 1, 6, 12.8, 90, 'possible');

------------------
-- 7. LITTER MOVEMENTS
------------------
INSERT INTO bao_mouvement_enclos_portee (id_enclos_portee_source, id_enclos_portee_destination, quantite_males_deplaces, quantite_femelles_deplaces, date_mouvement) VALUES
(1, 3, 3, 3, '2024-08-10'),
(1, 3, 3, 4, '2024-08-15');

------------------
-- 8. EMPLOYEE POSITIONS
------------------
INSERT INTO bao_employe_poste (nom_poste, salaire_base) VALUES
('Responsable élevage', 800000),
('Vétérinaire', 1200000),
('Ouvrier agricole', 500000),
('Comptable', 700000);

------------------
-- 10. EMPLOYEE MANAGEMENT
------------------
-- Salaries
INSERT INTO bao_salaire (id_employe, date_salaire, montant, statut) VALUES
(1, '2024-09-30', 820000, 'payé'),
(2, '2024-09-30', 1230000, 'payé'),
(3, '2024-09-30', 520000, 'payé');

-- Attendance
INSERT INTO bao_presence (id_employe, date_presence, statut) VALUES
(1, '2024-10-01', 'present'),
(1, '2024-10-02', 'present'),
(3, '2024-10-01', 'absent'),
(2, '2024-10-02', 'present');

-- Leave
INSERT INTO bao_conge (id_employe, date_debut, date_fin, motif, statut) VALUES
(3, '2024-12-15', '2024-12-22', 'Vacances annuelles', 'approuvé'),
(1, '2024-11-01', '2024-11-05', 'Formation technique', 'en attente');

------------------
-- 11. TASKS
------------------
-- Task Definitions
INSERT INTO bao_tache (id_employe_poste, nom_tache, description) VALUES
(1, 'Contrôle reproduction', 'Suivi des chaleurs et inséminations'),
(3, 'Nettoyage enclos', 'Nettoyage quotidien des enclos'),
(2, 'Visite sanitaire', 'Contrôle sanitaire hebdomadaire');

-- Employee Tasks
INSERT INTO bao_tache_employe (id_tache, id_employe, date_attribution, date_echeance, statut, precision) VALUES
(1, 1, '2024-10-01', '2024-10-05', 'en cours', 'Suivi truies #1-#5'),
(2, 1, '2024-10-02', '2024-10-02', 'terminé', 'Enclos A1-A5'),
(3, 2, '2024-10-03', '2024-10-04', 'à faire', 'Portée #2 et #3');

------------------
-- 12. HEALTH MANAGEMENT
------------------
-- Health Event Types
INSERT INTO bao_sante_type_evenement (nom_type_evenement, prix) VALUES
('Vaccination', 5000),
('Vermifuge', 3000),
('Examen général', 15000);

-- Health Events
INSERT INTO bao_sante_evenement (id_type_evenement, id_enclos, date_evenement) VALUES
(1, 4, '2024-08-20'),
(2, 5, '2024-08-22'),
(3, 1, '2024-09-01');

-- Symptoms
INSERT INTO bao_symptome (nom_symptome, description) VALUES
('Fièvre', 'Température > 40°C'),
('Perte d''appétit', 'Consommation réduite'),
('Toux', 'Respiration difficile');

-- Diseases
INSERT INTO bao_maladie (nom_maladie, description, dangerosite) VALUES
('Grippe porcine', 'Infection virale respiratoire', 'moderee'),
('Rouget', 'Infection bactérienne cutanée', 'elevee');

-- Disease-Symptoms
INSERT INTO bao_maladie_symptome (id_maladie, id_symptome) VALUES
(1, 1), (1, 2), (1, 3),
(2, 1), (2, 2);

-- Diagnostics
INSERT INTO bao_diagnostic (id_maladie, id_enclos_portee, nombre_males_infectes, nombre_femelles_infectes, date_apparition, date_diagnostic, desc_traitement, statut, prix_traitement) VALUES
(1, 1, 2, 3, '2024-08-25', '2024-08-27', 'Antibiotiques 5 jours', 'en traitement', 120000),
(2, 2, 1, 0, '2024-09-01', '2024-09-02', 'Vaccin d''urgence', 'en quarantaine', 185000);


-- NEKENA ADDITIONS
------------------
-- 13. WEIGHING RECORDS
------------------
-- Sow Weighing
-- INSERT INTO bao_pesee_truie (id_truie, date_pesee, poids) VALUES
-- (1, '2024-07-01', 180.2),
-- (1, '2024-08-01', 178.5),
-- (2, '2024-07-05', 175.8);

-- Litter Weighing
-- INSERT INTO bao_pesee_enclos_portee (id_enclos_portee, date_pesee, poids_total) VALUES
-- (1, '2024-08-15', 68.4),
-- (1, '2024-09-01', 95.2),
-- (2, '2024-08-20', 72.3);

------------------
-- 14. FOOD MANAGEMENT
------------------
-- Enclosure Feeding
-- INSERT INTO bao_alimentation_enclos (id_enclos) VALUES (4), (5), (1);

-- -- Feeding Details
-- INSERT INTO bao_details_alimentation (id_alimentation, id_aliment, quantite_kg, id_enclos_portee) VALUES
-- (1, 1, 25.5, 1),
-- (1, 2, 10.2, 1),
-- (2, 3, 30.0, 2),
-- (3, 5, 15.0, NULL);

-- Food Replenishment
-- INSERT INTO bao_reapprovisionnement_aliments (id_aliment, quantite_kg, cout_total) VALUES
-- (1, 500, 175000),
-- (2, 300, 165000),
-- (5, 200, 120000);

------------------
-- 15. DEATHS RECORD
------------------
-- INSERT INTO bao_deces (id_enclos, male_deces, female_deces, date_deces, cause_deces) VALUES
-- (1, 0, 1, '2024-08-10', 'Complications post-partum'),
-- (4, 2, 1, '2024-09-05', 'Infection respiratoire');

-- ===================================================================
-- 1. INSERT DATA INTO bao_prix_vente_porc (The Price List)
-- We need to define the selling price for each pig race.
-- ===================================================================

-- INSERT INTO bao_prix_vente_porc (id_race, prix_unitaire) VALUES
-- (1, 350000.00), -- Price for 'Large White' (id_race = 1)
-- (2, 340000.00), -- Price for 'Landrace' (id_race = 2)
-- (3, 380000.00), -- Price for 'Duroc' (id_race = 3)
-- (4, 400000.00); -- Price for 'Piétrain' (id_race = 4)