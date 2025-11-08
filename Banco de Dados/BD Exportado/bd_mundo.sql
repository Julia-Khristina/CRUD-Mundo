-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/11/2025 às 22:08
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_mundo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidades`
--

CREATE TABLE `cidades` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `populacao` int(11) NOT NULL,
  `pais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cidades`
--

INSERT INTO `cidades` (`id`, `nome`, `populacao`, `pais`) VALUES
(1, 'São Paulo', 12325232, 1),
(2, 'Rio de Janeiro', 6747815, 1),
(3, 'Belo Horizonte', 2523764, 1),
(4, 'Salvador', 2927347, 1),
(5, 'Brasília', 3055149, 1),
(6, 'Fortaleza', 2686612, 1),
(7, 'Curitiba', 1963726, 1),
(8, 'Manaus', 2143555, 1),
(9, 'Buenos Aires', 2890151, 2),
(10, 'Córdoba', 1391000, 2),
(11, 'Rosário', 1205000, 2),
(12, 'Mendoza', 1150000, 2),
(13, 'La Plata', 654324, 2),
(14, 'San Juan', 675000, 2),
(15, 'Mar del Plata', 620000, 2),
(16, 'Tucumán', 1000000, 2),
(17, 'Nova York', 8419600, 3),
(18, 'Los Angeles', 3980400, 3),
(19, 'Chicago', 2716000, 3),
(20, 'Houston', 2328000, 3),
(21, 'Phoenix', 1690000, 3),
(22, 'Filadélfia', 1584200, 3),
(23, 'San Antonio', 1547000, 3),
(24, 'San Diego', 1424000, 3),
(25, 'Paris', 2148327, 4),
(26, 'Marselha', 861635, 4),
(27, 'Lyon', 513275, 4),
(28, 'Toulouse', 479553, 4),
(29, 'Nice', 343629, 4),
(30, 'Nantes', 314138, 4),
(31, 'Estrasburgo', 280965, 4),
(32, 'Bordéus', 257068, 4),
(33, 'Lagos', 14240000, 5),
(34, 'Abuja', 1235880, 5),
(35, 'Kano', 4430000, 5),
(36, 'Ibadan', 3780000, 5),
(37, 'Port Harcourt', 1030000, 5),
(38, 'Benin City', 1140000, 5),
(39, 'Kaduna', 1290000, 5),
(40, 'Aba', 1000000, 5),
(41, 'Pequim', 21516000, 6),
(42, 'Xangai', 24150000, 6),
(43, 'Cantão', 14000000, 6),
(44, 'Shenzhen', 13000000, 6),
(45, 'Chengdu', 16000000, 6),
(46, 'Tianjin', 15500000, 6),
(47, 'Xi’an', 12700000, 6),
(48, 'Hong Kong', 7500000, 6),
(49, 'Sydney', 5312163, 7),
(50, 'Melbourne', 5078193, 7),
(51, 'Brisbane', 2410000, 7),
(52, 'Perth', 2000000, 7),
(53, 'Adelaide', 1360000, 7),
(54, 'Canberra', 431000, 7),
(55, 'Hobart', 222000, 7),
(56, 'Darwin', 147000, 7),
(57, 'Auckland', 1631000, 8),
(58, 'Wellington', 412500, 8),
(59, 'Christchurch', 377000, 8),
(60, 'Hamilton', 176500, 8),
(61, 'Dunedin', 120000, 8),
(62, 'Tauranga', 135000, 8),
(63, 'Napier', 64000, 8),
(64, 'Queenstown', 15000, 8);

-- --------------------------------------------------------

--
-- Estrutura para tabela `paises`
--

CREATE TABLE `paises` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `continente` enum('América','Europa','África','Ásia','Oceania') NOT NULL,
  `populacao` int(11) NOT NULL,
  `idioma` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `paises`
--

INSERT INTO `paises` (`id`, `nome`, `continente`, `populacao`, `idioma`) VALUES
(1, 'Brasil', 'América', 213993437, 'Português'),
(2, 'Argentina', 'América', 45195777, 'Espanhol'),
(3, 'Estados Unidos', 'América', 331002651, 'Inglês'),
(4, 'México', 'América', 128933400, 'Espanhol'),
(5, 'Colômbia', 'América', 50882891, 'Espanhol'),
(6, 'Peru', 'América', 32971854, 'Espanhol'),
(7, 'Chile', 'América', 19116201, 'Espanhol'),
(8, 'Canadá', 'América', 37742154, 'Inglês, Francês'),
(9, 'França', 'Europa', 67391582, 'Francês'),
(10, 'Alemanha', 'Europa', 83783942, 'Alemão'),
(11, 'Reino Unido', 'Europa', 67886011, 'Inglês'),
(12, 'Itália', 'Europa', 60244639, 'Italiano'),
(13, 'Espanha', 'Europa', 46719142, 'Espanhol'),
(14, 'Polônia', 'Europa', 38386000, 'Polonês'),
(15, 'Países Baixos', 'Europa', 17134872, 'Holandês'),
(16, 'Bélgica', 'Europa', 11589623, 'Neerlandês, Francês'),
(17, 'Nigéria', 'África', 211400708, 'Inglês'),
(18, 'África do Sul', 'África', 59308690, 'Africâner, Inglês'),
(19, 'Egito', 'África', 91250000, 'Árabe'),
(20, 'Quênia', 'África', 53771296, 'Inglês, Suaíli'),
(21, 'Gana', 'África', 31072940, 'Inglês'),
(22, 'Etiópia', 'África', 114963588, 'Amárico'),
(23, 'Uganda', 'África', 45741007, 'Inglês, Suaíli'),
(24, 'Tanzânia', 'África', 59734218, 'Suaíli, Inglês'),
(25, 'China', 'Ásia', 1411778724, 'Chinês'),
(26, 'Índia', 'Ásia', 1380004385, 'Hindi, Inglês'),
(27, 'Japão', 'Ásia', 126476461, 'Japonês'),
(28, 'Coreia do Sul', 'Ásia', 51329899, 'Coreano'),
(29, 'Indonésia', 'Ásia', 273523615, 'Indonésio'),
(30, 'Paquistão', 'Ásia', 220892340, 'Urdu, Inglês'),
(31, 'Bangladesh', 'Ásia', 164689383, 'Bengali'),
(32, 'Arábia Saudita', 'Ásia', 34813871, 'Árabe'),
(33, 'Austrália', 'Oceania', 26068792, 'Inglês'),
(34, 'Nova Zelândia', 'Oceania', 4822233, 'Inglês'),
(35, 'Papua Nova Guiné', 'Oceania', 8947024, 'Tok Pisin'),
(36, 'Fiji', 'Oceania', 896444, 'Inglês'),
(37, 'Samoa', 'Oceania', 198414, 'Inglês'),
(38, 'Ilhas Salomão', 'Oceania', 621000, 'Inglês'),
(39, 'Vanuatu', 'Oceania', 307150, 'Bislama'),
(40, 'Tonga', 'Oceania', 105695, 'Tongan, Inglês');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Julia Khristina', 'jkhristina@gmail.com', '$2y$10$.vMWddIPzHqcwhsUuo1fRuBYT/BdkaUuh534vlUtm/BraiiF3QuUy');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pais` (`pais`);

--
-- Índices de tabela `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `paises`
--
ALTER TABLE `paises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cidades`
--
ALTER TABLE `cidades`
  ADD CONSTRAINT `cidades_ibfk_1` FOREIGN KEY (`pais`) REFERENCES `paises` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
