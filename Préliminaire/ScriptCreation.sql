--Ajouter un utilisateur:

CREATE USER adminBase IDENTIFIED BY 'V3ryS3cur3edP@ssw0rd';

--Création de la base de donnée:

CREATE DATABASE base_garage;

--Ajout des droits pour l'admin:

GRANT SELECT, UPDATE, DELETE, INSERT ON base_garage.* TO adminBase;


CREATE TABLE 
