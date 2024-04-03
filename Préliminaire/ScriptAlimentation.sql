create database garage;

create user 'GarageAdmin' identified by 'Password';
grant ALL on garage.* to 'GarageAdmin';

use garage;

insert into `user` (nom, prenom, password, username, roles) values (
	'BOGDANOVIC', 'Hugo', '$2y$13$nXQzcDiozJvTQa5oaaIrkePTE/DvBLoldbnaodEKO3aChQMjpwrwu', 'BOGDANOVIC.Hugo','["ROLE_USER", "ROLE_ADMIN"]'
); 

insert into `user` (nom, prenom, password, username, roles) values (
	'PARROT', 'Valentin', '$2y$13$nXQzcDiozJvTQa5oaaIrkePTE/DvBLoldbnaodEKO3aChQMjpwrwu', 'PARROT.Valentin','["ROLE_USER", "ROLE_ADMIN"]'
); 

insert into `user` (nom, prenom, password, username, roles) values (
	'TEST', 'Imonie', '$2y$13$nXQzcDiozJvTQa5oaaIrkePTE/DvBLoldbnaodEKO3aChQMjpwrwu', 'TEST.Imonie', '["ROLE_USER"]'
);
insert into `user` (nom, prenom, password, username, roles) values (
	'CATEUR', 'Inse', '$2y$13$nXQzcDiozJvTQa5oaaIrkePTE/DvBLoldbnaodEKO3aChQMjpwrwu', 'CATEUR.Inse', '["ROLE_USER"]'
);

-- passw0rd


select * from garage;

insert into `garage` (contact_tel, contact_mail, ouverture_semaine,  fermeture_semaine
											   , ouverture_samedi,   fermeture_samedi
											   , ouverture_dimanche, fermeture_dimanche)
values (
	'0101010101', 'contact.garage@poire.com',
	'08:45:00', '18:00:00',
	'08:45:00', '12:00:00',
	'00:00:00', '00:00:00'
);

select * from service;

insert into service (garage_id, nom, description) values(
1,
"Acaht vehicule",
"Nous achetons vos vehicule a des prix raisonables"
);