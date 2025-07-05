USE bao_gestion_porc;

-- Disable foreign key checks to avoid constraint errors
SET FOREIGN_KEY_CHECKS = 0;

-- Reset data in all tables (ordered to respect foreign key constraints)
TRUNCATE TABLE bao_cycle_reproduction;
TRUNCATE TABLE bao_portee;
TRUNCATE TABLE bao_insemination;
TRUNCATE TABLE bao_diagnostic;
TRUNCATE TABLE bao_maladie_symptome;
TRUNCATE TABLE bao_maladie;
TRUNCATE TABLE bao_symptome;
TRUNCATE TABLE bao_deces;
TRUNCATE TABLE bao_sante_calendrier;
TRUNCATE TABLE bao_sante_evenement;
TRUNCATE TABLE bao_sante_type_evenement;
TRUNCATE TABLE bao_tache_employe;
TRUNCATE TABLE bao_tache;
TRUNCATE TABLE bao_conge;
TRUNCATE TABLE bao_presence;
TRUNCATE TABLE bao_salaire;
TRUNCATE TABLE bao_employe;
TRUNCATE TABLE bao_employe_poste;
TRUNCATE TABLE bao_stockage_mouvement;
TRUNCATE TABLE bao_aliment_type;
TRUNCATE TABLE bao_commande;
TRUNCATE TABLE bao_client;
TRUNCATE TABLE bao_enclos_portee;
TRUNCATE TABLE bao_enclos;
TRUNCATE TABLE bao_truie;
TRUNCATE TABLE bao_enclos_type;
TRUNCATE TABLE bao_utilisateur;
TRUNCATE TABLE bao_utilisateur_role;

-- Re-insert essential reference data
INSERT INTO bao_utilisateur_role (nom_role) VALUES ('admin'), ('emp');
INSERT INTO bao_utilisateur (nom_utilisateur, mot_de_passe, id_utilisateur_role) 
VALUES ('admin', 'admin', 1), ('emp', 'emp', 2);

INSERT INTO bao_enclos_type (nom_enclos_type) 
VALUES ('Truie'), ('Portee'), ('Quarantaine');

INSERT INTO bao_employe_poste (nom_poste, salaire_base) 
VALUES 
  ('Technicien en reproduction', 1200), 
  ('Technicien en alimentation', 1100), 
  ('Technicien en santé animale', 1500),
  ('Agent entretien enclos', 1000),
  ('Agent clientèle', 1100),
  ('Agent administratif', 1300);

INSERT INTO bao_sante_type_evenement (nom_type_evenement, prix)
VALUES 
  ('Vaccination', 50.00),
  ('Consultation vétérinaire', 100.00),
  ('Insemination', 75.00);

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

SELECT 'Database reset complete. All data cleared and reference data reinserted.' AS message;