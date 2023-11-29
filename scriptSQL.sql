DROP DATABASE IF EXISTS dbTv;

CREATE DATABASE dbTv;
USE dbTv;

CREATE TABLE utilisateur (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    pseudonyme VARCHAR(63) NOT NULL,
    mdp VARCHAR(63) NOT NULL,
    courriel VARCHAR(63) NOT NULL,
    nom VARCHAR(63) NOT NULL,
    prenom VARCHAR(63) NOT NULL,
    id_langue INT NOT NULL
);

CREATE TABLE langue (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nom_complet VARCHAR(31) NOT NULL,
    acronyme VARCHAR(3) NOT NULL
);

CREATE TABLE televiseur (
  modele VARCHAR(63) PRIMARY KEY NOT NULL,
  nom VARCHAR(63) NOT NULL,
  id_marque INT NOT NULL,
  prix FLOAT NOT NULL,
  frequence INT NOT NULL,
  id_type_ecran INT NOT NULL,
  hdr BIT NOT NULL,
  id_resolution INT NOT NULL,
  taille INT NOT NULL,
  id_os INT,
  garantie INT NOT NULL,
  lien TEXT NOT NULL
);

CREATE TABLE televiseur_port (
  nb_port INT NOT NULL,
  modele_televiseur VARCHAR(63),
  id_port INT,
  PRIMARY KEY (modele_televiseur, id_port)
);

CREATE TABLE port (
  id INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(31) NOT NULL,
  CONSTRAINT PK_port PRIMARY KEY(id)
);

CREATE TABLE resolution (
    id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(15) NOT NULL,
    hauteur INT NOT NULL,
    largeur INT NOT NULL,
    CONSTRAINT PK_resolution PRIMARY KEY(id)
);

CREATE TABLE favoris (
  modele_televiseur VARCHAR(63) NOT NULL,
  id_utilisateur INT NOT NULL,
  PRIMARY KEY (modele_televiseur, id_utilisateur)
);

CREATE TABLE os (
    id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(31) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE type_ecran (
    id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(15) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE marque (
    id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(15) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE evaluation (
    note INT NOT NULL,
    commentaire VARCHAR(255),
    id_utilisateur INT NOT NULL,
    modele_televiseur VARCHAR(63) NOT NULL,
    titre VARCHAR(127),
    PRIMARY KEY (id_utilisateur, modele_televiseur)
);


ALTER TABLE televiseur 
  ADD CONSTRAINT FK_Marque_Televiseur FOREIGN KEY (id_marque) REFERENCES marque (id),
  ADD CONSTRAINT FK_televiseur_type_ecran FOREIGN KEY (id_type_ecran) REFERENCES type_ecran (id),
  ADD CONSTRAINT FK_televiseur_resolution FOREIGN KEY (id_resolution) REFERENCES resolution (id),
  ADD CONSTRAINT FK_televiseur_os FOREIGN KEY (id_os) REFERENCES os (id);


ALTER TABLE televiseur_port
  ADD CONSTRAINT FK_Televiseur_Port_Modele FOREIGN KEY (modele_televiseur) REFERENCES televiseur (modele),
  ADD CONSTRAINT FK_Televiseur_Port_Port FOREIGN KEY (id_port) REFERENCES port (id);

ALTER TABLE utilisateur
  ADD CONSTRAINT FK_utilisateur_id_langue FOREIGN KEY (id_langue) REFERENCES langue (id);

ALTER TABLE favoris
  ADD CONSTRAINT FK_favoris_modele_televiseur FOREIGN KEY (modele_televiseur) REFERENCES televiseur (modele),
  ADD CONSTRAINT FK_favoris_id_utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id);

ALTER TABLE evaluation 
  ADD CONSTRAINT FK_evaluation_Utilisateur FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id),
  ADD CONSTRAINT FK_evaluation_Televiseur FOREIGN KEY (modele_televiseur) REFERENCES televiseur(modele);


INSERT INTO marque (nom)
VALUES ('Samsung'), 
       ('LG'), 
       ('Philips'),
       ('Sony'), 
       ('Toshiba'); 


INSERT INTO port (nom) 
VALUES ('HDMI'), 
       ('USB'), 
       ('Entrée RF'), 
       ('SPDIF'),  
       ('Ethernet'),  
       ('Sortie casque'), 
       ('Sortie audio numérique'),  
       ('Entrée CVBS et audio stéréo'),  
       ('Optique (TOSLINK)'),  
       ('Connecteur de service'), 
       ('Connecteur satellite'),  
       ('Common Interface Plus'), 
       ('Entrée RS-232C / VGA'), 
       ('Entrée RCA'),
       ('Antenne'), 
       ('Entrée audio composite'),
       ('Sortie composite'); 


INSERT INTO type_ecran (nom)
VALUES ('OLED'), 
       ('LED'),  
       ('Mini-LED'),  
       ('QLED'),  
       ('LCD'),  
       ('QD-OLED'), 
       ('Direct LED'), 
       ('NanoCell');


INSERT INTO resolution (nom, hauteur, largeur) 
VALUES ('HD', '1366', '768'),
       ('FHD', '1920', '1080'),
       ('4K', '3840', '2160');


INSERT INTO os (nom) 
VALUES ('Tizen'),  
       ('WebOS23'),
       ('WebOS22'), 
       ('Roku OS'), 
       ('Android TV'), 
       ('Fire TV'),
       ('Smart TV'); 


INSERT INTO langue (nom_complet, acronyme)
VALUES ('Français', 'FRA'),
       ('English', 'ENG'),  
       ('Italian', 'ITA'), 
       ('Mandarin', 'CMN'),
       ('Polski', 'POL'); 


INSERT INTO televiseur(modele, id_marque, prix, frequence, id_type_ecran, hdr, id_resolution, taille, id_os, garantie, lien, nom)
VALUES ('M4500B', 1, 229.99, 60,  2, 1, 1, 32, NULL, 12,'https://www.samsung.com/ca_fr/tvs/hd-tv/m4500-32-inch-un32m4500bfxzc/','32" HD Smart TV M4500B'),
       ('LS03B', 1, 3349.97, 120, 4, 1, 3, 65, 1, 12,'https://www.samsung.com/ca_fr/lifestyle-tvs/the-frame/the-frame-tv-with-white-bezel-and-hw-s801b-soundbar-f-65ls03s801wt/', 'Téléviseur The Frame avec cadre blanc et barre de son HW-S801B'), 
       ('S90C', 1, 5499.99, 120, 1, 1, 3, 83, 1, 12,'https://www.samsung.com/ca_fr/tvs/oled-tv/83s90c-83-inch-qn83s90caexzc/', 'Téléviseur intelligent OLED 4K S90C de 83 po'),
       ('Q80C', 1, 7999.99, 120, 4, 1, 3, 98, 1, 12,'https://www.samsung.com/ca_fr/tvs/qled-tv/q80c-98-inch-qled-4k-smart-tv-qn98q80cafxzc/', 'QLED 4K Q80C de 98 po'), 

       ('OLED65G3PUA', 2, 3499.99, 120, 1, 1, 3, 65, 2, 60,'https://www.lg.com/ca_fr/teles-barres-de-son/oled-evo/oled65g3pua/', 'LG G3 65" 4K OLED Evo'), 
       ('65QNED85UQA', 2, 1999.99, 120, 3, 1, 3, 65, 3, 12,'https://www.lg.com/ca_en/tv-soundbars/qned/65qned85uqa/#pdp-support-section', 'LG 65" QNED85 4K QNED w/'),
       ('55UQ7570PUJ', 2, 599.99, 60, 2, 1, 3, 55, 3, 12,'https://www.lg.com/ca_en/tv-soundbars/4k-uhd-tvs/55uq7570puj/', 'LG UHD UQ7570 55" 4K LED TV'), 
       ('OLED97G2PUA', 2, 24999.99, 120, 1, 1, 3, 97, 3, 60,'https://www.lg.com/ca_fr/tvs-barres-de-son/oled-evo/oled97g2pua/', 'LG G2 97" 4K OLED evo Gallery Edition w/'),
       ('75NANO75UQA', 2, 1339.99, 60, 8, 1, 3, 75, 3, 12,'https://www.lg.com/ca_en/tv-soundbars/nanocell/75nano75uqa/', 'LG NANO75 75" 4K LED w/'),
       
       ('43PFL6643', 3, 289.98, 60 ,2 ,0, 2, 43, 4, 12, 'https://www.philips.ca/fr/c-p/43PFL6643_F6/roku-tv-televiseur-del-acl-serie-6000', '43PFL6643 DEL ACL série 6000 (FHD)'), 
       ('75PUL6643', 3, 811.75, 120, 5, 1, 3, 75, 4, 12, 'https://www.philips.ca/fr/c-p/75PUL6643_F6/roku-tv-televiseur-del-acl-serie-6600', '75PUL6643 DEL ACL série 6000 (UHD)'), 
       ('75PUL7973', 3, 999.99, 120, 4, 1, 3, 75, 4, 12, 'https://www.philips.ca/fr/c-p/75PUL7973_F6/roku-tv-televiseur-qled-de-la-serie-7900', '75PUL797 QLED de la série 7900'),
       ('77OLED848', 3, 6271.80, 120, 1, 1, 3, 77, 4, 12,'https://www.philips.fr/c-p/77OLED848_12/oled-8-series-televiseur-4k-ambilight', '77OLED848 4K Ambilight'), 
       
       ('KD55X77L', 4, 499.99, 60, 7, 1, 3, 65, 5, 12,'https://www.sony.ca/fr/bravia/products/x77l-series/spec', 'X77L Series'),
       ('XR85X95L', 4, 5499.99, 120, 3, 1, 3, 85, 5, 12,'https://www.sony.ca/fr/bravia/products/x95l-series', 'X95L Series'), 
       ('XR77A95L', 4, 3999.99, 120, 4, 1, 3, 77, 5, 12,'https://www.sony.ca/fr/bravia/products/a95l-series', 'A95L Series'), 
       ('XBR55A9G', 4, 2799.99, 120, 1, 1, 3, 55, 5, 12,'https://www.sony.ca/fr/electronics/televiseurs/xbr-a9g-series', 'XBR A9G Series'),
       
       ('55C350LC', 5, 649.99, 60, 2, 1, 3, 55, 6, 60, 'https://www.amazon.ca/Toshiba-UHD-Fire-Smart-55C350LC/dp/B0CCQB8VJ5?th=1', 'Téléviseur intelligent Fire HDR DEL UHD 4K de 55 po de Toshiba'), 
       ('32V35KC', 5, 185.74, 60, 5, 1, 1, 32, 6, 60, 'https://www.toshibatv-canada.com/fr/tvs/all-tvs/32V35KC_toshiba-32-hd-fire-tv', 'TOSHIBA 32 HD FIRE TV'), 
       ('43V35C', 5, 285.74, 60, 5, 0, 2, 43, 6, 60, 'https://www.amazon.ca/Toshiba-1080p-LED-Smart-43V35C/dp/B09L2FFXQL', 'Téléviseur intelligent DEL HD 1080p de 43 po de Toshiba'), 
       ('55X9863', 5, 729.35, 60, 1, 1, 3, 55, 7, 60, 'https://www.displayspecifications.com/fr/model/1207155d', 'Toshiba 55X9863');

INSERT INTO televiseur_port (modele_televiseur, id_port, nb_port)
VALUES 
     
       
       ('M4500B', 1, 2),
       ('M4500B', 2, 1),
       
       ('LS03B', 1, 4),
       ('LS03B', 2, 2),

       ('S90C', 1, 4),
       
       ('Q80C', 1, 4),
       ('Q80C', 2, 2),
       
    

       ('OLED65G3PUA', 1, 4),
       ('OLED65G3PUA', 2, 3),
       ('OLED65G3PUA', 3, 1),
       ('OLED65G3PUA', 4, 1),
       ('OLED65G3PUA', 5, 1),

       ('65QNED85UQA', 1, 1),
       ('65QNED85UQA', 4, 1),
       ('65QNED85UQA', 5, 1),

       ('55UQ7570PUJ', 1, 1),
       ('55UQ7570PUJ', 4, 1),
       ('55UQ7570PUJ', 5, 1),

       ('OLED97G2PUA', 1, 1),
       ('OLED97G2PUA', 4, 1),
       ('OLED97G2PUA', 5, 1),

       ('75NANO75UQA', 1, 1), 
       ('75NANO75UQA', 4, 1), 
       ('75NANO75UQA', 5, 1), 
       

       
       ('43PFL6643', 1, 3),
       ('43PFL6643', 2, 1),
       ('43PFL6643', 6, 1),
       ('43PFL6643', 7, 1),
       
       ('75PUL6643', 1, 4),
       ('75PUL6643', 2, 1),
       ('75PUL6643', 5, 1),
       ('75PUL6643', 6, 1),
       ('75PUL6643', 7, 2),
       ('75PUL6643', 8, 1),
       ('75PUL6643', 9, 1),

       ('75PUL7973', 1, 4),
       ('75PUL7973', 2, 1),
       ('75PUL7973', 5, 1),
       ('75PUL7973', 6, 1),
       ('75PUL7973', 7, 2),
       ('75PUL7973', 8, 1),
       ('75PUL7973', 9, 1),

       ('77OLED848', 1, 4),
       ('77OLED848', 2, 3),
       ('77OLED848', 5, 1),
       ('77OLED848', 10, 1),
       ('77OLED848', 11, 1),
       ('77OLED848', 6, 1),
       ('77OLED848', 7, 2),
       ('77OLED848', 12, 1),

    
       
       ('KD55X77L', 5, 1),
       ('KD55X77L', 3, 1),
       ('KD55X77L', 17, 1),
       ('KD55X77L', 1, 3),
       ('KD55X77L', 7, 1),
       ('KD55X77L', 2, 2),
       
       ('XR85X95L', 5, 1),
       ('XR85X95L', 3, 1),
       ('XR85X95L', 17, 1),
       ('XR85X95L', 1, 4),
       ('XR85X95L', 7, 1),
       ('XR85X95L', 2, 2),
       ('XR85X95L', 13, 1),

       ('XR77A95L', 5, 1),
       ('XR77A95L', 3, 1),
       ('XR77A95L', 13, 1),

       ('XBR55A9G', 5, 1),
       ('XBR55A9G', 3, 1),
       ('XBR55A9G', 17, 1),
       ('XBR55A9G', 1, 4),
       ('XBR55A9G', 7, 1),
       ('XBR55A9G', 2, 3),
       ('XBR55A9G', 13, 1),
       ('XBR55A9G', 6, 1),

    

       ('55C350LC', 1, 3),
       ('55C350LC', 2, 2),
       ('55C350LC', 5, 1),
       ('55C350LC', 6, 1),
       ('55C350LC', 7, 1),
       ('55C350LC', 14, 1),
       ('55C350LC', 15, 1),
       ('55C350LC', 16, 1),

       ('32V35KC', 1, 3),
       ('32V35KC', 2, 2),
       ('32V35KC', 5, 1),
       ('32V35KC', 6, 1),
       ('32V35KC', 7, 1),
       ('32V35KC', 14, 1),
       ('32V35KC', 15, 1),
       ('32V35KC', 16, 1),

       ('43V35C', 1, 3),
       ('43V35C', 2, 2),
       ('43V35C', 5, 1),
       ('43V35C', 6, 1),
       ('43V35C', 7, 1),
       ('43V35C', 14, 1),
       ('43V35C', 15, 1),
       ('43V35C', 16, 1),
       
       ('55X9863', 1, 4),
       ('55X9863', 2, 3),
       ('55X9863', 5, 1),
       ('55X9863', 6, 1),
       ('55X9863', 13, 1),
       ('55X9863', 15, 1);

INSERT INTO utilisateur (pseudonyme, mdp, courriel, nom, prenom, id_langue)
VALUES ('Bob1234', 'abc123', 'bob1234@courriel.com', 'Bobby', 'Robert', 3),
       ('TeleviseurFan', '12345', 'televiseurfan@courriel.com', 'Pierre', 'Paul', 1);