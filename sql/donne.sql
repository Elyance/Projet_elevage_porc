
INSERT INTO CATEGORIE (libele) VALUES
('Dépenses'),
('Recettes');

INSERT INTO DEPARTEMENT (nom) VALUES
('Finance'),
('Ressources Humaines'),
('Marketing'),
('Technique');

INSERT INTO Budget (idDep, idT, idN, prevision, realisation, valider) VALUES
(1, 1, 1, 10000.00, 8000.00, TRUE),
(2, 2, 2, 15000.00, 12000.00, FALSE),
(3, 1, 3, 20000.00, 18000.00, TRUE),
(4, 2, 4, 25000.00, 23000.00, FALSE);

INSERT INTO EMPLOYER (idD, nom, mdp) VALUES
(1, 'Alice Dupont', 'password123'),
(2, 'Bob Martin', 'mdp456'),
(3, 'Claire Lemoine', 'secure789'),
(2, 'nam', '1234');



INSERT INTO NATURE (idC, libele) VALUES
(1, 'Publicité en ligne'),
(1, 'Salaires des employés'),
(2, 'Ventes produits A'),
(2, 'Ventes services B');



INSERT INTO TYPE (idC, libele) VALUES
(1, 'Publicité'),
(1, 'Salaires'),
(2, 'Ventes'),
(2, 'Investissements');



INSERT INTO categorie_client VALUES (1, 'Client particulier');
INSERT INTO categorie_client VALUES (2, 'Client professionnel');

INSERT INTO client(nom , email , telephone , id_categorie)  VALUES ('Jean Dupont', 'jean@example.com', '0600000000', 1);
INSERT INTO client(nom , email , telephone , id_categorie)  VALUES ('Société X', 'contact@societex.com', '0123456789', 2);


INSERT INTO categorie_produit (nom_categorie) VALUES ('Voiture neuve');
INSERT INTO categorie_produit (nom_categorie) VALUES ('Voiture d’occasion');

INSERT INTO produit (nom_produit , marque , prix , id_categorie) VALUES ('Peugeot 208', 'Peugeot', 18500.00, 1);
INSERT INTO produit (nom_produit , marque , prix , id_categorie) VALUES ('Renault Clio 2018', 'Renault', 9500.00, 2);


INSERT INTO liste_action (nom_action) VALUES
('Appel téléphonique'),
('Email promotionnel'),
('SMS de relance'),
('Envoi de devis'),
('Rendez-vous commercial'),
('Offre spéciale'),
('Enquête de satisfaction');


INSERT INTO liste_reaction VALUES
(1, 'A répondu positivement', 'positive'),
(2, 'A refusé l’offre', 'negative'),
(3, 'A demandé plus d’informations', 'neutre'),
(4, 'A ignoré l’action', 'negative'),
(5, 'A pris rendez-vous', 'positive'),
(6, 'A effectué un achat', 'positive'),
(7, 'A résilié', 'negative'),
(8, 'A recommandé un ami', 'positive');



-- Une relance téléphonique (id_action = 1)
-- peut provoquer ces réactions :
INSERT INTO action_reaction VALUES (1, 1, 'Le client a répondu positivement');
INSERT INTO action_reaction VALUES (1, 2, 'Le client a refusé l’offre');
INSERT INTO action_reaction VALUES (1, 4, 'Aucune réponse');


-- Réaction : "A effectué un achat" (id_reaction = 6)
-- Peut être déclenchée par plusieurs actions :
INSERT INTO action_reaction VALUES (2, 6, 'Suite à un email promo');
INSERT INTO action_reaction VALUES (3, 6, 'Suite à un SMS');
INSERT INTO action_reaction VALUES (4, 6, 'Suite à un envoi de devis');


INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 3, 28500.00, 1, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 4, 38000.00, 2, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 2, 19000.00, 3, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 5, 47500.00, 4, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 3, 28500.00, 5, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 4, 38000.00, 6, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 6, 57000.00, 7, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 2, 19000.00, 8, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 3, 28500.00, 9, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 4, 38000.00, 10, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 1, 9500.00, 11, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 2, 19000.00, 12, 2024);

INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 2, 37000.00, 1, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 3, 55500.00, 2, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 1, 18500.00, 3, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 4, 74000.00, 4, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 2, 37000.00, 5, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 3, 55500.00, 6, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 5, 92500.00, 7, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 2, 37000.00, 8, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 3, 55500.00, 9, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 4, 74000.00, 10, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 1, 18500.00, 11, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 2, 37000.00, 12, 2024);

INSERT INTO produit (nom_produit, marque, prix, id_categorie) VALUES ('Opel Corsa 2019', 'Opel', 8700.00, 2);
INSERT INTO produit (nom_produit, marque, prix, id_categorie) VALUES ('Fiat 500 2017', 'Fiat', 7600.00, 2);
INSERT INTO produit (nom_produit, marque, prix, id_categorie) VALUES ('Dacia Sandero 2018', 'Dacia', 8300.00, 2);
INSERT INTO produit (nom_produit, marque, prix, id_categorie) VALUES ('Seat Ibiza 2019', 'Seat', 9100.00, 2);
INSERT INTO produit (nom_produit, marque, prix, id_categorie) VALUES ('Kia Rio 2020', 'Kia', 9900.00, 2);
INSERT INTO produit (nom_produit, marque, prix, id_categorie) VALUES ('Toyota Yaris', 'Toyota', 19500.00, 1);
INSERT INTO produit (nom_produit, marque, prix, id_categorie) VALUES ('Volkswagen Golf', 'Volkswagen', 24500.00, 1);
INSERT INTO produit (nom_produit, marque, prix, id_categorie) VALUES ('Citroën C3', 'Citroën', 17900.00, 1);
INSERT INTO produit (nom_produit, marque, prix, id_categorie) VALUES ('Ford Puma', 'Ford', 22900.00, 1);
INSERT INTO produit (nom_produit, marque, prix, id_categorie) VALUES ('Hyundai i20', 'Hyundai', 18200.00, 1);


-- Peugeot 208 (vendue chaque 2 mois uniquement)
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 3, 55500.00, 1, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 2, 37000.00, 3, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 4, 74000.00, 5, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 1, 18500.00, 7, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 2, 37000.00, 9, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (1, 3, 55500.00, 11, 2024);

-- Renault Clio 2018 (non vendue en avril, août, décembre)
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 2, 19000.00, 1, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 3, 28500.00, 2, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 1, 9500.00, 3, 2024);
-- avril : pas de vente
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 2, 19000.00, 5, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 1, 9500.00, 6, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 2, 19000.00, 7, 2024);
-- août : pas de vente
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 3, 28500.00, 9, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 1, 9500.00, 10, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (2, 2, 19000.00, 11, 2024);
-- décembre : pas de vente

-- Toyota Yaris (vendue uniquement en été et fin d’année)
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (3, 2, 39000.00, 6, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (3, 3, 58500.00, 7, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (3, 1, 19500.00, 8, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (3, 1, 19500.00, 11, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (3, 2, 39000.00, 12, 2024);

-- Volkswagen Golf (vendue uniquement les trimestres pairs)
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (4, 1, 24500.00, 2, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (4, 2, 49000.00, 4, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (4, 1, 24500.00, 6, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (4, 3, 73500.00, 8, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (4, 2, 49000.00, 10, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (4, 1, 24500.00, 12, 2024);

-- Fiat 500 2017 (vendue sporadiquement)
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (5, 1, 7600.00, 3, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (5, 2, 15200.00, 6, 2024);
INSERT INTO Ventes (id_produit, quantite, Valeur, mois, annee) VALUES (5, 1, 7600.00, 10, 2024);
