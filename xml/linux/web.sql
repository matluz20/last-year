CREATE DATABASE ETUDIANT;
USE ETUDIANT;
CREATE TABLE Utilisateurs(
 `id_users` int(15) NOT NULL AUTO_INCREMENT,
 `nom` varchar(15) NOT NULL,
 `prenom` varchar(50) NOT NULL,
 `login` varchar(50) NOT NULL,
 `password` varchar(500) NOT NULL,
 PRIMARY KEY (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;


CREATE TABLE Informations (
 `id_medic` int(15) NOT NULL AUTO_INCREMENT,
 `prenom` varchar(50) NOT NULL,
 `age` int(20) NOT NULL,
 `poids` int(20) NOT NULL,
 PRIMARY KEY (`id_medic`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;
INSERT INTO `Utilisateurs` (`id_users`, `nom`, `prenom`, `login`, `password`) VALUES
(1,'BIDOCHON','Robert','rob_le_ouf','mdrlol'),
(2,'YAU','Tatiana','tatayoyo','mdrlol'),
(3,'OURSON','Winnie','ton_ami','mdrlol'),
(4,'DUPONT','Pierre','pierrot75','mdrlol');
INSERT INTO `Informations` (`id_medic`, `prenom`, `age`, `poids`) VALUES
(1,'BIDOCHON',34,100),
(2,'YAU',47,60),
(3,'OURSON',20,110),
(4,'DUPONT',4,20);
