/* ! =========================================== !  */
/* === === RAW SQL USED TO CREATE MIGRATIONS ====== */
/* ! =========================================== !  */


-- admins table
CREATE TABLE admins (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password_admin VARCHAR(255) NOT NULL
);

-- gender (male, female)
CREATE TABLE genre (
    id SERIAL PRIMARY KEY,
    label VARCHAR(255) NOT NULL
);

-- equipes credentials
CREATE TABLE equipes (
    id SERIAL PRIMARY KEY,
    name_equipe VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password_equipe VARCHAR(255) NOT NULL
);

-- coureurs 
CREATE TABLE coureurs (
    id SERIAL PRIMARY KEY,
    id_genre INT NOT NULL REFERENCES genre(id),
    id_equipe INT NOT NULL REFERENCES equipes(id),
    name_coureur VARCHAR(255) NOT NULL,
    numero_dossard VARCHAR(255) NOT NULL UNIQUE,
    date_naissance DATE NOT NULL
);

-- coureurs categorie (rookie, dame, homme, junior, mixte ...)
CREATE TABLE categorie (
    id SERIAL PRIMARY KEY,
    label VARCHAR(255) NOT NULL
);

-- a `coureur` can have several `categorie`
CREATE TABLE coureur_categories (
    id SERIAL PRIMARY KEY,
    id_coureur INT NOT NULL REFERENCES coureurs(id),
    id_categorie INT NOT NULL REFERENCES categorie(id)
);

-- course
CREATE TABLE courses (
    id SERIAL PRIMARY KEY,
    label VARCHAR(255) NOT NULL
);

-- etapes of a course 
CREATE TABLE etapes (
    id SERIAL PRIMARY KEY,
    id_course INT NOT NULL REFERENCES courses(id),
    label VARCHAR(255) NOT NULL,
    longueur_km DECIMAL(10, 2) NOT NULL,
    nbr_coureur INT NOT NULL,
    date_etape DATE NOT NULL,
    heure_depart TIME NOT NULL -- `heure de depart` is the same for each `coureurs` 
);

-- participant coureurs to this etape
CREATE TABLE etape_coureurs (
    id SERIAL PRIMARY KEY,
    id_etape INT NOT NULL REFERENCES etapes(id),
    id_coureur INT NOT NULL REFERENCES coureurs(id)
);

-- given points for each ranks on this etapes, it can be different on every etapes (given points)
CREATE TABLE etape_rang_points (
    id SERIAL PRIMARY KEY,
    id_etape INT NOT NULL REFERENCES etapes(id),
    rang INT NOT NULL,  
    point_attribue DECIMAL(10, 2) NOT NULL  -- given points for this `etapes` for each `rang`
);  

-- `temps` of a coureurs on a `etape`
CREATE TABLE etape_coureur_temps (
    id SERIAL PRIMARY KEY,
    id_etape_coureur INT NOT NULL REFERENCES etape_coureurs(id),
    temps_depart TIME NOT NULL,
    temps_arrivee TIME NOT NULL    -- `temps arrivee` is different for each `coureurs` 
);