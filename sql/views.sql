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
FROM recette
WHERE date_recette BETWEEN '2023-01-01' AND '2023-12-31';