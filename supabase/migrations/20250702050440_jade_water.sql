-- Script de création des tables
CREATE TABLE IF NOT EXISTS service (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    manager_id INTEGER REFERENCES employe(id)
);

CREATE TABLE IF NOT EXISTS employe (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    type VARCHAR(50) NOT NULL,
    prime DECIMAL(10,2) DEFAULT 0,
    login VARCHAR(100),
    password VARCHAR(255),
    specialite VARCHAR(50)
);

-- Index pour améliorer les performances
CREATE INDEX IF NOT EXISTS idx_employe_type ON employe(type);
CREATE INDEX IF NOT EXISTS idx_service_manager ON service(manager_id);