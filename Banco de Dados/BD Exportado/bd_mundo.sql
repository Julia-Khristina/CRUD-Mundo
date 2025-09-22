create database Mundo;
use Mundo;

create table Paises (
id_pais int auto_increment primary key,
nome varchar(100) not null,
continente enum ("América", "Europa", "África", "Ásia", "Oceania") not null,
populacao int not null,
idioma varchar(50)
);

create table Cidades (
id_cidade int auto_increment primary key,
nome varchar(100) not null,
populacao int not null,
id_pais int not null,
foreign key (id_pais) references Paises(id_pais)
);

-- América
INSERT INTO Paises (nome, continente, populacao, idioma) VALUES
('Brasil', 'América', 213993437, 'Português'),
('Argentina', 'América', 45195777, 'Espanhol'),
('Estados Unidos', 'América', 331002651, 'Inglês'),
('México', 'América', 128933400, 'Espanhol'),
('Colômbia', 'América', 50882891, 'Espanhol'),
('Peru', 'América', 32971854, 'Espanhol'),
('Chile', 'América', 19116201, 'Espanhol'),
('Canadá', 'América', 37742154, 'Inglês, Francês');

-- Europa
INSERT INTO Paises (nome, continente, populacao, idioma) VALUES
('França', 'Europa', 67391582, 'Francês'),
('Alemanha', 'Europa', 83783942, 'Alemão'),
('Reino Unido', 'Europa', 67886011, 'Inglês'),
('Itália', 'Europa', 60244639, 'Italiano'),
('Espanha', 'Europa', 46719142, 'Espanhol'),
('Polônia', 'Europa', 38386000, 'Polonês'),
('Países Baixos', 'Europa', 17134872, 'Holandês'),
('Bélgica', 'Europa', 11589623, 'Neerlandês, Francês');

-- África
INSERT INTO Paises (nome, continente, populacao, idioma) VALUES
('Nigéria', 'África', 211400708, 'Inglês'),
('África do Sul', 'África', 59308690, 'Africâner, Inglês'),
('Egito', 'África', 91250000, 'Árabe'),
('Quênia', 'África', 53771296, 'Inglês, Suaíli'),
('Gana', 'África', 31072940, 'Inglês'),
('Etiópia', 'África', 114963588, 'Amárico'),
('Uganda', 'África', 45741007, 'Inglês, Suaíli'),
('Tanzânia', 'África', 59734218, 'Suaíli, Inglês');

-- Ásia
INSERT INTO Paises (nome, continente, populacao, idioma) VALUES
('China', 'Ásia', 1411778724, 'Chinês'),
('Índia', 'Ásia', 1380004385, 'Hindi, Inglês'),
('Japão', 'Ásia', 126476461, 'Japonês'),
('Coreia do Sul', 'Ásia', 51329899, 'Coreano'),
('Indonésia', 'Ásia', 273523615, 'Indonésio'),
('Paquistão', 'Ásia', 220892340, 'Urdu, Inglês'),
('Bangladesh', 'Ásia', 164689383, 'Bengali'),
('Arábia Saudita', 'Ásia', 34813871, 'Árabe');

-- Oceania
INSERT INTO Paises (nome, continente, populacao, idioma) VALUES
('Austrália', 'Oceania', 26068792, 'Inglês'),
('Nova Zelândia', 'Oceania', 4822233, 'Inglês'),
('Papua Nova Guiné', 'Oceania', 8947024, 'Tok Pisin'),
('Fiji', 'Oceania', 896444, 'Inglês'),
('Samoa', 'Oceania', 198414, 'Inglês'),
('Ilhas Salomão', 'Oceania', 621000, 'Inglês'),
('Vanuatu', 'Oceania', 307150, 'Bislama'),
('Tonga', 'Oceania', 105695, 'Tongan, Inglês');

-- Brasil (id_pais = 1)
INSERT INTO Cidades (nome, populacao, id_pais) VALUES
('São Paulo', 12325232, 1),
('Rio de Janeiro', 6747815, 1),
('Belo Horizonte', 2523764, 1),
('Salvador', 2927347, 1),
('Brasília', 3055149, 1),
('Fortaleza', 2686612, 1),
('Curitiba', 1963726, 1),
('Manaus', 2143555, 1);

-- Argentina (id_pais = 2)
INSERT INTO Cidades (nome, populacao, id_pais) VALUES
('Buenos Aires', 2890151, 2),
('Córdoba', 1391000, 2),
('Rosário', 1205000, 2),
('Mendoza', 1150000, 2),
('La Plata', 654324, 2),
('San Juan', 675000, 2),
('Mar del Plata', 620000, 2),
('Tucumán', 1000000, 2);

-- Estados Unidos (id_pais = 3)
INSERT INTO Cidades (nome, populacao, id_pais) VALUES
('Nova York', 8419600, 3),
('Los Angeles', 3980400, 3),
('Chicago', 2716000, 3),
('Houston', 2328000, 3),
('Phoenix', 1690000, 3),
('Filadélfia', 1584200, 3),
('San Antonio', 1547000, 3),
('San Diego', 1424000, 3);

-- França (id_pais = 4)
INSERT INTO Cidades (nome, populacao, id_pais) VALUES
('Paris', 2148327, 4),
('Marselha', 861635, 4),
('Lyon', 513275, 4),
('Toulouse', 479553, 4),
('Nice', 343629, 4),
('Nantes', 314138, 4),
('Estrasburgo', 280965, 4),
('Bordéus', 257068, 4);

-- Nigéria (id_pais = 5)
INSERT INTO Cidades (nome, populacao, id_pais) VALUES
('Lagos', 14240000, 5),
('Abuja', 1235880, 5),
('Kano', 4430000, 5),
('Ibadan', 3780000, 5),
('Port Harcourt', 1030000, 5),
('Benin City', 1140000, 5),
('Kaduna', 1290000, 5),
('Aba', 1000000, 5);

-- China (id_pais = 6)
INSERT INTO Cidades (nome, populacao, id_pais) VALUES
('Pequim', 21516000, 6),
('Xangai', 24150000, 6),
('Cantão', 14000000, 6),
('Shenzhen', 13000000, 6),
('Chengdu', 16000000, 6),
('Tianjin', 15500000, 6),
('Xi’an', 12700000, 6),
('Hong Kong', 7500000, 6);

-- Austrália (id_pais = 7)
INSERT INTO Cidades (nome, populacao, id_pais) VALUES
('Sydney', 5312163, 7),
('Melbourne', 5078193, 7),
('Brisbane', 2410000, 7),
('Perth', 2000000, 7),
('Adelaide', 1360000, 7),
('Canberra', 431000, 7),
('Hobart', 222000, 7),
('Darwin', 147000, 7);

-- Nova Zelândia (id_pais = 8)
INSERT INTO Cidades (nome, populacao, id_pais) VALUES
('Auckland', 1631000, 8),
('Wellington', 412500, 8),
('Christchurch', 377000, 8),
('Hamilton', 176500, 8),
('Dunedin', 120000, 8),
('Tauranga', 135000, 8),
('Napier', 64000, 8),
('Queenstown', 15000, 8);




