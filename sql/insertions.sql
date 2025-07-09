--ENCLOS
INSERT INTO bao_enclos_type (nom_enclos_type) VALUES ('Truie'), ('Portee'), ('Quarantaine');

INSERT INTO bao_enclos (enclos_type, stockage) VALUES
(1, 10), -- Truie enclosure
(2, 20), -- Portee enclosure
(3, 5);  -- Quarantine



--TRUIE
INSERT INTO bao_truie (id_enclos, poids, date_entree) VALUES
(1, 150.500, '2025-06-01'),
(1, 145.750, '2025-06-05');



--ENCLOS
INSERT INTO bao_employe (nom_employe, prenom_employe, id_employe_poste, adresse, contact_telephone, date_recrutement, statut) VALUES
('Rakoto', 'Jean', 1, 'Antananarivo', '0341234567', '2024-01-15', 'actif'),
('Ranaivo', 'Marie', 2, 'Toamasina', '0347654321', '2024-02-10', 'actif');



--CLIENT
INSERT INTO bao_client (nom_client, type_profil, adresse, contact_telephone, contact_email) VALUES
('AgriCorp', 'entreprise', 'Tamatave', '0339876543', 'contact@agricorp.com'),
('Rabe', 'particulier', 'Fianarantsoa', '0341112233', 'rabe@email.com');