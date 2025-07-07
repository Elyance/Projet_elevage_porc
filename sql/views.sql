CREATE OR REPLACE VIEW bao_view_recette AS
SELECT 
    c.id_commande,
    c.id_race,
    c.nomclient,
    c.date_livraison AS date_recette,
    c.quantite,
    pvp.prix_unitaire,
    c.quantite * pvp.prix_unitaire AS prix_total
FROM 
    bao_commande c
JOIN 
    bao_prix_vente_porc pvp ON c.id_race = pvp.id_race
WHERE 
    c.statut_livraison = 'livre';



SELECT SUM(prix_total) AS total_recette
FROM bao_view_recette
WHERE date_recette BETWEEN '2023-01-01' AND '2023-12-31';



CREATE TABLE reapprovisionnement_aliments (
    id_reappro SERIAL PRIMARY KEY,
    id_aliment INT REFERENCES aliments(id_aliment),
    quantite_kg DECIMAL(10, 2) NOT NULL,
    date_reappro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cout_total DECIMAL(10, 2) NOT NULL
);


CREATE OR REPLACE VIEW bao_view_depenses_totales AS
SELECT 
    'Achats' AS type_depense,
    ra.date_reappro::DATE AS date_depense,
    ra.cout_total AS montant
FROM 
    reapprovisionnement_aliments ra

UNION

SELECT 
    'Salaire' AS type_depense,
    s.date_salaire AS date_depense,
    s.montant
FROM 
    bao_salaire s
WHERE 
    s.statut = 'paye'

UNION

SELECT 
    'Traitement' AS type_depense,
    d.date_diagnostic AS date_depense,
    d.prix_traitement AS montant
FROM 
    bao_diagnostic d
WHERE 
    d.prix_traitement IS NOT NULL;




CREATE OR REPLACE VIEW bao_view_budget AS
WITH Recettes AS (
    SELECT 
        EXTRACT(YEAR FROM date_recette) AS annee,
        EXTRACT(MONTH FROM date_recette) AS mois,
        SUM(prix_total) AS total_recette
    FROM bao_view_recette
    GROUP BY EXTRACT(YEAR FROM date_recette), EXTRACT(MONTH FROM date_recette)
),
Depenses AS (
    SELECT 
        EXTRACT(YEAR FROM date_depense) AS annee,
        EXTRACT(MONTH FROM date_depense) AS mois,
        SUM(montant) AS total_depense
    FROM bao_view_depenses_totales
    GROUP BY EXTRACT(YEAR FROM date_depense), EXTRACT(MONTH FROM date_depense)
)
SELECT 
    COALESCE(r.annee, d.annee) AS annee,
    COALESCE(r.mois, d.mois) AS mois,
    COALESCE(r.total_recette, 0) AS total_recette,
    COALESCE(d.total_depense, 0) AS total_depense,
    COALESCE(r.total_recette, 0) - COALESCE(d.total_depense, 0) AS budget
FROM Recettes r
FULL OUTER JOIN Depenses d
    ON r.annee = d.annee AND r.mois = d.mois
ORDER BY annee, mois;




CREATE OR REPLACE VIEW bao_view_budget_annuel AS
SELECT 
    annee,
    SUM(total_recette) AS total_recette,
    SUM(total_depense) AS total_depense,
    SUM(budget) AS budget
FROM bao_view_budget
GROUP BY annee
ORDER BY annee;