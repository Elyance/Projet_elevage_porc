-- Tabe regle gestion temporaire
CREATE TABLE bao_regle_gestion (
    id SERIAL PRIMARY KEY,
    nom_regle VARCHAR(50) UNIQUE,
    valeur DECIMAL(10,2)
);


-- Table de recette prenant les valeurs venant de regle_gestion
CREATE VIEW bao_recette AS
SELECT 
    c.id_commande,
    cl.nom_client,
    c.date_livraison AS date_recette,
    c.quantite,
    (SELECT valeur FROM bao_regle_gestion WHERE nom_regle = 'prix_vente_porc') AS prix_unitaire,
    c.quantite * (SELECT valeur FROM bao_regle_gestion WHERE nom_regle = 'prix_vente_porc') AS prix_total
FROM 
    bao_commande c
JOIN 
    bao_client cl ON c.id_client = cl.id_client
WHERE 
    c.statut_livraison = 'livré';



SELECT SUM(prix_total) AS total_recette
FROM bao_recette
WHERE date_recette BETWEEN '2023-01-01' AND '2023-12-31';



CREATE OR REPLACE VIEW depenses_totales AS
SELECT 
    'achat_aliment' AS type_depense,
    sm.date_mouvement AS date_depense,
    sm.quantite * (SELECT valeur FROM bao_regle_gestion WHERE nom_regle = 'prix_achat_aliment') AS montant
FROM 
    bao_stockage_mouvement sm
WHERE 
    sm.type_mouvement = 'ajout'
UNION
SELECT 
    'salaire' AS type_depense,
    s.date_salaire AS date_depense,
    s.montant
FROM 
    bao_salaire s
WHERE 
    s.statut = 'paye'
UNION
SELECT 
    'traitement' AS type_depense,
    d.date_diagnostic AS date_depense,
    d.prix_traitement AS montant
FROM 
    bao_diagnostic d
WHERE 
    d.prix_traitement IS NOT NULL;