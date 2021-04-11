CREATE DATABASE "pgsqlsmall" WITH TEMPLATE = template0 ENCODING 'UTF8';
\c pgsqlsmall

BEGIN;

CREATE TABLE "user_" (
  id SERIAL PRIMARY KEY,
  firstname varchar(255) default NULL,
  lastname varchar(255) default NULL,
  age integer NULL,
  sexe varchar(255) default NULL,
  city varchar(255),
  idCategory integer NULL
);

CREATE TABLE "category_" (
  id SERIAL PRIMARY KEY,
  name varchar(255)
);

INSERT INTO "category_" (name) VALUES ('Nibh Incorporated'),('Varius Institute'),('Dictum Incorporated'),('Arcu Imperdiet LLC'),('Dictum Incorporated'),('Non Lobortis Corp.'),('Quam Ltd'),('Mattis Incorporated'),('A Consulting'),('Ipsum Dolor Sit LLP');

INSERT INTO "user_" (firstname,lastname,age,sexe,city,idCategory) VALUES ('Nell','Macias',52,'0','Southaven',10),('Uta','Franco',65,'0','St. Neots',6),('Zena','Cross',29,'1','Gibsons',5),('Sylvia','Walters',30,'0','Épernay',8),('Gareth','Herman',74,'0','Ruisbroek',1),('Samuel','Lane',39,'0','Wolvertem',5),('Brian','Pickett',44,'0','Charters Towers',7),('Upton','Foreman',72,'1','Tavier',10),('Lacy','Stephens',3,'0','Landenne',1),('Lamar','Melendez',93,'1','Campomarino',5);
INSERT INTO "user_" (firstname,lastname,age,sexe,city,idCategory) VALUES ('Nash','Russo',53,'1','Ruette',4),('Carly','Good',85,'0','Kotlas',6),('Lucas','Cash',31,'1','Vagli Sotto',3),('Shelby','Wilder',73,'0','Grande Cache',1),('Maxine','Love',99,'0','Alkmaar',8),('Yvette','Pearson',6,'0','Krasnoznamensk',7),('Thane','Holloway',5,'0','Holman',4),('Hermione','Francis',25,'1','Kopeysk',7),('Erich','Delaney',80,'1','Colombes',6),('Whitney','Sanchez',90,'0','Quinte West',7);
INSERT INTO "user_" (firstname,lastname,age,sexe,city,idCategory) VALUES ('Carter','Horton',41,'0','Cantalupo in Sabina',7),('Colt','Golden',87,'1','Burlington',10),('Nita','Tate',73,'0','Kailua',10),('Yoshi','Parsons',82,'1','Ivanovo',7),('Josephine','Clarke',98,'1','Etobicoke',1),('Ursula','Norman',84,'0','Verona',10),('Cathleen','Ortega',28,'1','Etobicoke',9),('Bree','James',36,'1','Olivar',7),('Teegan','Lopez',52,'1','Lampa',3),('Hilda','Gilliam',58,'1','Dillenburg',3);
INSERT INTO "user_" (firstname,lastname,age,sexe,city,idCategory) VALUES ('Pearl','Mitchell',29,'1','Vigo',1),('Kylie','Lloyd',47,'0','Corby',8),('Elton','Travis',67,'1','Warwick',2),('Marah','Nixon',49,'0','Gyeongju',3),('Evangeline','Herring',71,'1','New Quay',3),('Jason','Bartlett',26,'0','Suncheon',8),('Colby','Mcbride',83,'0','Renlies',8),('Armand','Solis',47,'0','Owensboro',1),('Quynn','Espinoza',16,'0','Tuktoyaktuk',5),('Jamal','Newton',84,'1','Norrköping',2);
INSERT INTO "user_" (firstname,lastname,age,sexe,city,idCategory) VALUES ('Winter','Thornton',79,'1','Rock Springs',7),('Destiny','Sullivan',31,'1','Lago Ranco',10),('Dakota','Carver',68,'0','Acquedolci',3),('Timothy','Hansen',66,'1','Hafizabad',5),('Clarke','Pickett',23,'1','Chennai',8),('Scarlet','Wood',12,'0','Castel Colonna',7),('Dillon','Doyle',59,'1','Spormaggiore',3),('Ashton','Garner',72,'0','Sneek',8),('Kane','Ortiz',13,'0','Bevagna',7),('Sylvia','Phelps',15,'0','Bourges',1);
INSERT INTO "user_" (firstname,lastname,age,sexe,city,idCategory) VALUES ('Clarke','Wiley',87,'0','Saint-L�onard',7),('Nicholas','Franklin',82,'1','Barnstaple',5),('Otto','Barron',22,'0','Sant''Angelo in Pontano',2),('Denise','Miller',26,'1','Bima',3),('Amaya','Vaughan',32,'1','Monte San Pietrangeli',9),('Luke','Allison',51,'0','Cagnes-sur-Mer',2),('Britanni','Contreras',81,'1','Temuka',6),('Yolanda','Vaughn',38,'0','Shillong',3),('Phelan','Wall',16,'0','Liverpool',4),('Ifeoma','Reid',82,'1','Terrance',10);
INSERT INTO "user_" (firstname,lastname,age,sexe,city,idCategory) VALUES ('Upton','Kim',63,'0','Pontboset',5),('Andrew','Gonzalez',87,'1','San Francisco',4),('Judah','Rivera',66,'0','Middlesbrough',9),('Jermaine','Foreman',43,'0','Bevagna',9),('Maggie','Coffey',15,'0','Kozan',1),('Blaze','Vinson',94,'1','Sudhanoti',1),('Oren','Vega',47,'0','Angleur',6),('Remedios','Carey',50,'1','Gatineau',8),('Jocelyn','Ray',68,'1','Cardedu',9),('Oliver','West',33,'1','Pudukkottai',4);
INSERT INTO "user_" (firstname,lastname,age,sexe,city,idCategory) VALUES ('Sarah','Hendrix',46,'1','Solapur',5),('Hoyt','Dickerson',46,'0','Kearney',9),('Pamela','Byrd',31,'1','Mumbai',9),('Xantha','Maldonado',22,'1','Bhilai',1),('Jerry','Kemp',1,'0','Jalna',3),('William','Spence',31,'0','Sete Lagoas',9),('Gil','Logan',8,'0','San Calogero',9),('Minerva','Albert',51,'1','Cannole',1),('Nicole','Perkins',72,'1','Woking',10),('Zephr','Dean',57,'1','FlŽnu',9);
INSERT INTO "user_" (firstname,lastname,age,sexe,city,idCategory) VALUES ('Penelope','Orr',5,'0','Castiglione di Garfagnana',1),('McKenzie','Beasley',95,'0','Maria',9),('Jasper','Cobb',19,'0','Renlies',5),('Jacob','Mueller',49,'0','Fürth',8),('Ryan','Hendrix',88,'0','Dudzele',2),('Teegan','Mayo',69,'1','Pagazzano',2),('Abraham','Hardy',69,'0','Borisovka',2),('Dolan','Dillard',54,'1','Guadalupe',8),('Anika','Wiggins',31,'1','Cardedu',2),('Plato','Bowers',22,'0','Uyo',5);
INSERT INTO "user_" (firstname,lastname,age,sexe,city,idCategory) VALUES ('Griffith','Sanford',80,'0','Sivry',7),('Kyle','Roberts',69,'0','Piringen',9),('Wallace','Sanders',99,'0','Hulste',10),('Nathaniel','Paul',14,'1','Matagami',5),('Evangeline','Rivers',39,'1','Balurghat',5),('Kelly','Navarro',73,'0','Enterprise',6),('Ria','West',48,'1','Bowden',3),('Phillip','Obrien',34,'1','Lusevera',3),('Sawyer','Goff',79,'0','Tonalá',2),('Kaseem','Dominguez',15,'1','Cumaribo',1);

ALTER TABLE "user_" 
ADD CONSTRAINT "fk_user_cat" 
FOREIGN KEY (idcategory) 
REFERENCES "category_" (id);

COMMIT;