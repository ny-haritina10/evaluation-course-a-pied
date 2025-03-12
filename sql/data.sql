/* GENRE ################################################### */
INSERT INTO genre (id, label) VALUES (1, 'Masculin');
INSERT INTO genre (id, label) VALUES (2, 'Feminin');

/* CATEGORIE ################################################### */
INSERT INTO categorie (id, label) VALUES (1, 'Homme');
INSERT INTO categorie (id, label) VALUES (2, 'Femme');
INSERT INTO categorie (id, label) VALUES (3, 'Junior');
INSERT INTO categorie (id, label) VALUES (4, 'Senior');
INSERT INTO categorie (id, label) VALUES (5, 'Mixte');

/* EQUIPES ################################################### */
INSERT INTO equipes (id, name_equipe, email, password_equipe)
VALUES (1, 'Equipe A', 'equipeA@gmail.com', 'equipeA');

INSERT INTO equipes (id, name_equipe, email, password_equipe)
VALUES (2, 'Equipe B', 'equipeB@gmail.com', 'equipeB');

INSERT INTO equipes (id, name_equipe, email, password_equipe)
VALUES (3, 'Equipe C', 'equipeC@gmail.com', 'equipeC');


/* COUREURS ################################################### */
INSERT INTO coureurs (id, id_genre, id_equipe, name_coureur, numero_dossard, date_naissance)
VALUES (1, 1, 1, 'Jack', 'DOS-001', '2004-01-01');

INSERT INTO coureurs (id, id_genre, id_equipe, name_coureur, numero_dossard, date_naissance)
VALUES (2, 2, 1, 'Jackie', 'DOS-002', '2002-01-01');

INSERT INTO coureurs (id, id_genre, id_equipe, name_coureur, numero_dossard, date_naissance)
VALUES (3, 2, 1, 'Franck', 'DOS-003', '2005-01-01');

INSERT INTO coureurs (id, id_genre, id_equipe, name_coureur, numero_dossard, date_naissance)
VALUES (4, 1, 2, 'Paul', 'DOS-004', '2004-01-01');

INSERT INTO coureurs (id, id_genre, id_equipe, name_coureur, numero_dossard, date_naissance)
VALUES (5, 2, 2, 'Steve', 'DOS-005', '2002-01-01');

INSERT INTO coureurs (id, id_genre, id_equipe, name_coureur, numero_dossard, date_naissance)
VALUES (6, 2, 2, 'Garry', 'DOS-006', '2005-01-01');

/* COUREUR_CATEGORIE ################################################### */
INSERT INTO coureur_categories (id, id_coureur, id_categorie)
VALUES (1, 1, 1);

INSERT INTO coureur_categories (id, id_coureur, id_categorie)
VALUES (2, 1, 3);

INSERT INTO coureur_categories (id, id_coureur, id_categorie)
VALUES (3, 2, 2);

INSERT INTO coureur_categories (id, id_coureur, id_categorie)
VALUES (4, 3, 3);

INSERT INTO coureur_categories (id, id_coureur, id_categorie)
VALUES (5, 4, 1);

INSERT INTO coureur_categories (id, id_coureur, id_categorie)
VALUES (6, 5, 5);

INSERT INTO coureur_categories (id, id_coureur, id_categorie)
VALUES (7, 6, 1);

INSERT INTO coureur_categories (id, id_coureur, id_categorie)
VALUES (8, 6, 2);

/* COURSES ################################################### */
INSERT INTO courses (id, label) VALUES (1, 'Course A');
INSERT INTO courses (id, label) VALUES (2, 'Course B');

/* ETAPES ################################################### */
INSERT INTO etapes (id, id_course, label, longueur_km, nbr_coureur, date_etape, heure_depart) 
VALUES (1, 1, 'Etape 0', 5.00, 3, '2025-06-10', '08:00:00');

INSERT INTO etapes (id, id_course, label, longueur_km, nbr_coureur, date_etape, heure_depart) 
VALUES (2, 1, 'Etape 1', 120.50, 3, '2025-06-11', '08:00:00');

/* ETAPES RANG POINTS ################################################### */

-- Etape 0
INSERT INTO etape_rang_points (id, id_etape, rang, point_attribue)
VALUES (1, 1, 1, 5);

INSERT INTO etape_rang_points (id, id_etape, rang, point_attribue)
VALUES (2, 1, 2, 3);

INSERT INTO etape_rang_points (id, id_etape, rang, point_attribue)
VALUES (3, 1, 3, 1);


-- Etape 1
INSERT INTO etape_rang_points (id, id_etape, rang, point_attribue)
VALUES (4, 2, 1, 6);

INSERT INTO etape_rang_points (id, id_etape, rang, point_attribue)
VALUES (5, 2, 2, 4);

INSERT INTO etape_rang_points (id, id_etape, rang, point_attribue)
VALUES (6, 2, 3, 2);