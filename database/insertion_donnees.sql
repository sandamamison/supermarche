-- =====================================================
-- Base SQLite - Projet : Caisse d'un supermarche
-- Fichier : insertion_donnees.sql
-- Contenu : insertion de 5 produits et 2 caisses
-- =====================================================

PRAGMA foreign_keys = ON;

BEGIN TRANSACTION;

-- Nettoyage des donnees de test
DELETE FROM achat;
DELETE FROM caisse;
DELETE FROM produit;

-- Reinitialiser les identifiants auto-incrementes
DELETE FROM sqlite_sequence WHERE name IN ('achat', 'caisse', 'produit');

-- Insertion de 5 produits
INSERT INTO produit (designation, prix, quantite_stock, description) VALUES
('Riz blanc 1kg', 3500, 100, 'Riz blanc local vendu par paquet de 1kg'),
('Huile alimentaire 1L', 8500, 50, 'Bouteille huile alimentaire 1 litre'),
('Sucre blanc 1kg', 4200, 80, 'Sucre blanc en paquet de 1kg'),
('Savon de menage', 2500, 120, 'Savon solide pour menage'),
('Lait en poudre 400g', 12000, 35, 'Boite de lait en poudre 400g');

-- Insertion de 2 caisses
INSERT INTO caisse (numero_caisse, libelle, statut) VALUES
('CAISSE-01', 'Caisse numero 1', 'ouverte'),
('CAISSE-02', 'Caisse numero 2', 'ouverte');

COMMIT;
