-- Active: 1781683179706@@127.0.0.1@3306
-- =====================================================
-- Base SQLite - Projet : Caisse d'un supermarche
-- Fichier : tables.sql
-- Contenu : creation des tables Produit, Caisse et Achat
-- =====================================================

PRAGMA foreign_keys = ON;

-- Supprimer les tables si elles existent deja
DROP TABLE IF EXISTS achat;
DROP TABLE IF EXISTS caisse;
DROP TABLE IF EXISTS produit;

-- Table des produits vendus dans le supermarche
CREATE TABLE produit (
    id_produit INTEGER PRIMARY KEY AUTOINCREMENT,
    designation TEXT NOT NULL,
    prix REAL NOT NULL CHECK (prix >= 0),
    quantite_stock INTEGER NOT NULL DEFAULT 0 CHECK (quantite_stock >= 0),
    description TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);

-- Table des caisses disponibles
CREATE TABLE caisse (
    id_caisse INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_caisse TEXT NOT NULL UNIQUE,
    libelle TEXT NOT NULL,
    statut TEXT NOT NULL DEFAULT 'ouverte' CHECK (statut IN ('ouverte', 'fermee')),
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);

-- Table des achats saisis a la caisse
-- Un achat correspond a un client.
-- Si le client achete plusieurs produits, on utilise le meme numero_ticket
-- pour regrouper les lignes du meme achat.
CREATE TABLE achat (
    id_achat INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_ticket TEXT NOT NULL,
    id_caisse INTEGER NOT NULL,
    id_produit INTEGER NOT NULL,
    quantite INTEGER NOT NULL CHECK (quantite > 0),
    prix_unitaire REAL NOT NULL CHECK (prix_unitaire >= 0),
    montant_ligne REAL NOT NULL CHECK (montant_ligne >= 0),
    date_achat TEXT DEFAULT CURRENT_TIMESTAMP,
    nom_acheteur TEXT NOT NULL,

    FOREIGN KEY (id_caisse) REFERENCES caisse(id_caisse),
    FOREIGN KEY (id_produit) REFERENCES produit(id_produit)
);

ALTER TABLE achat ADD COLUMN nom_acheteur TEXT;

drop table achat;

-- Index utiles pour accelerer les recherches
CREATE INDEX idx_achat_numero_ticket ON achat(numero_ticket);
CREATE INDEX idx_achat_caisse ON achat(id_caisse);
CREATE INDEX idx_achat_produit ON achat(id_produit);
