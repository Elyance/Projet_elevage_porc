-- Déjà créé : enclos type
-- Créer des enclos
INSERT INTO bao_enclos(enclos_type, stockage) VALUES
(1, 5), -- Truie
(2, 20), -- Portee
(3, 0); -- Quarantaine

INSERT INTO races_porcs (nom_race, description, besoins_nutritionnels, duree_engraissement_jours) VALUES
('Large White', 'Race très répandue, à croissance rapide.', 'Aliment riche en protéines, complément minéral.', 180),
('Landrace', 'Race réputée pour sa prolificité.', 'Besoin en céréales et protéines végétales.', 170),
('Duroc', 'Race robuste, viande de bonne qualité.', 'Ration équilibrée, riche en énergie.', 190),
('Pietrain', 'Race très musclée.', 'Aliment protéiné, supplément minéral.', 185),
('Berkshire', 'Race traditionnelle, chair savoureuse.', 'Nutrition modérée, aliments naturels.', 200);

INSERT INTO aliments (
    nom_aliment,
    prix_kg,
    stock_kg,
    apports_nutritionnels,
    contact_fournisseur,
    conso_journaliere_kg_par_porc
) VALUES (
    'Maïs',
    1500.00,
    2000.00,
    'Riche en amidon, source principale d energie pour les porcs.',
    '0341234567',
    1.50
);

INSERT INTO aliments (
    nom_aliment,
    prix_kg,
    stock_kg,
    apports_nutritionnels,
    contact_fournisseur,
    conso_journaliere_kg_par_porc
) VALUES (
    'Son de riz',
    1200.00,
    1500.00,
    'Fibres alimentaires, améliore la digestion et équilibre la ration.',
    '0347654321',
    1.20
);

INSERT INTO aliments (
    nom_aliment,
    prix_kg,
    stock_kg,
    apports_nutritionnels,
    contact_fournisseur,
    conso_journaliere_kg_par_porc
) VALUES (
    'Tourteau de soja',
    2500.00,
    800.00,
    'Apport en protéines végétales, favorise la croissance musculaire.',
    '0339876543',
    0.80
);

INSERT INTO aliments (
    nom_aliment,
    prix_kg,
    stock_kg,
    apports_nutritionnels,
    contact_fournisseur,
    conso_journaliere_kg_par_porc
) VALUES (
    'Farine de poisson',
    3500.00,
    500.00,
    'Protéine animale de haute qualité, stimule la prise de poids.',
    '0321122334',
    0.50
);



-- Créer des truies
INSERT INTO bao_truie(id_enclos, poids, date_entree) VALUES
(1, 200.50, '2024-06-01'),
(1, 195.00, '2024-06-05');

-- Créer une portee
INSERT INTO bao_portee(id_truie, nombre_porcs, date_naissance) VALUES
(1, 8, '2024-07-01'),
(2, 10, '2024-07-05');

-- Associer portee à un enclos
INSERT INTO bao_enclos_portee(id_enclos, id_portee, quantite_portee, poids_estimation, nombre_jour_ecoule, statut_vente)
VALUES 
(2, 1, 8, 25.0, 10, 'possible'),
(2, 2, 10, 20.0, 5, 'non possible');






INSERT INTO bao_aliment_type(nom_aliment_type, prix) VALUES
('Croissance', 1.50),
('Finition', 1.80);

INSERT INTO bao_stockage_mouvement(id_aliment_type, quantite, date_mouvement, type_mouvement, raison_mouvement) VALUES
(1, 200.00, '2024-07-01', 'ajout', 'Achat stock initial'),
(1, 20.00, '2024-07-02', 'retrait', 'Consommation truie'),
(2, 150.00, '2024-07-01', 'ajout', 'Achat stock initial'),
(2, 30.00, '2024-07-03', 'retrait', 'Consommation portee');





INSERT INTO bao_client(nom_client, type_profil, adresse, contact_telephone, contact_email) VALUES
('Ando SARL', 'entreprise', 'Lot II A 45', '0321234567', 'contact@ando.mg'),
('Rasoanaivo', 'particulier', 'Fianarantsoa', '0347654321', 'rasoanaivo@gmail.com');

INSERT INTO bao_commande(id_client, id_enclos_portee, quantite, date_commande, adresse_livraison, date_livraison, statut_livraison) VALUES
(1, 1, 4, '2024-07-10', 'Lot II A 45', NULL, 'en attente'),
(2, 2, 2, '2024-07-12', 'Fianarantsoa', NULL, 'en attente');





-- Déjà inséré les postes
-- Employés
INSERT INTO bao_employe(nom_employe, prenom_employe, id_employe_poste, adresse, contact_telephone, date_recrutement, statut) VALUES
('Rakoto', 'Jean', 1, 'Analakely', '0341122334', '2024-01-10', 'actif'),
('Rasoanaivo', 'Lala', 2, 'Ambatonakanga', '0345566778', '2024-03-15', 'actif');

-- Salaires
INSERT INTO bao_salaire(id_employe, date_salaire, montant, statut) VALUES
(1, '2024-07-01', 1200.00, 'paye'),
(2, '2024-07-01', 1100.00, 'paye');

-- Présence
INSERT INTO bao_presence(id_employe, date_presence, statut) VALUES
(1, '2024-07-04', 'present'),
(2, '2024-07-04', 'absent');

-- Congé
INSERT INTO bao_conge(id_employe, date_debut, date_fin, motif, statut) VALUES
(2, '2024-07-15', '2024-07-20', 'Vacances', 'approuve');

-- Tâches
INSERT INTO bao_tache(id_employe_poste, nom_tache, description) VALUES
(1, 'Suivi reproduction', 'Suivre cycle reproduction'),
(2, 'Suivi alimentation', 'Distribution aliments');

INSERT INTO bao_tache_employe(id_tache, id_employe, date_attribution, statut) VALUES
(1, 1, '2024-07-01', 'non commencer'),
(2, 2, '2024-07-02', 'terminee');





INSERT INTO bao_sante_evenement(id_type_evenement, id_enclos, date_evenement) VALUES
(1, 1, '2024-07-03'), -- Vaccination truie
(2, 2, '2024-07-04'); -- Consultation portee

INSERT INTO bao_sante_calendrier(id_sante_evenement) VALUES
(1),
(2);

INSERT INTO bao_deces(id_enclos, nombre_deces, date_deces, cause_deces) VALUES
(2, 1, '2024-07-05', 'Maladie');






INSERT INTO bao_symptome(nom_symptome, description) VALUES
('Fièvre', 'Température corporelle élevée'),
('Toux', 'Toux fréquente');

INSERT INTO bao_maladie(nom_maladie, description, dangerosite) VALUES
('Peste porcine', 'Maladie virale grave', 'elevee');

INSERT INTO bao_maladie_symptome(id_maladie, id_symptome) VALUES
(1, 1),
(1, 2);

INSERT INTO bao_diagnostic(id_maladie, id_enclos, nombre_infecte, date_apparition, date_diagnostic, desc_traitement, statut, prix_traitement)
VALUES (1, 2, 5, '2024-07-02', '2024-07-03', 'Antibiotiques + isolement', 'en traitement', 200.00);






INSERT INTO bao_insemination(id_truie, date_insemination, resultat) VALUES
(1, '2024-06-01', 'succes'),
(2, '2024-06-10', 'en cours');

INSERT INTO bao_cycle_reproduction(id_truie, date_debut_cycle, date_fin_cycle, nombre_portee, id_insemination) VALUES
(1, '2024-06-01', '2024-09-01', 1, 1),
(2, '2024-06-10', NULL, 0, 2);

UPDATE bao_portee SET id_cycle_reproduction = 1 WHERE id_portee = 1;
UPDATE bao_portee SET id_cycle_reproduction = 2 WHERE id_portee = 2;
