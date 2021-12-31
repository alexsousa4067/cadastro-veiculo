-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31-Dez-2021 às 15:20
-- Versão do servidor: 10.4.6-MariaDB
-- versão do PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `josealex`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `characteristics`
--

CREATE TABLE `characteristics` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `characteristics`
--

INSERT INTO `characteristics` (`id`, `name`) VALUES
(1, 'ESPORTE'),
(2, 'CLASSICO'),
(3, 'TURBO'),
(4, 'ECONOMICO'),
(5, 'PARA CIDADE'),
(6, 'PARA LONGAS VIAGENS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `characteristic_vehicle`
--

CREATE TABLE `characteristic_vehicle` (
  `id` int(11) NOT NULL,
  `characteristic` int(11) NOT NULL,
  `vehicle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `characteristic_vehicle`
--

INSERT INTO `characteristic_vehicle` (`id`, `characteristic`, `vehicle`) VALUES
(22, 4, 5),
(23, 5, 5),
(24, 6, 5),
(25, 1, 6),
(26, 3, 6),
(27, 4, 7),
(28, 5, 7),
(29, 6, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `chassi_number` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `plate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `vehicle`
--

INSERT INTO `vehicle` (`id`, `chassi_number`, `brand`, `model`, `year`, `plate`) VALUES
(5, 'LSKDJOSJOS84OU84', 'Fiat', 'Palio', '2014', 'abc1234'),
(6, 'S78DF6S897DF687', 'Ford', 'Ferrari', '2021', 'BCA3214'),
(7, '84J983JO84J0J049J', 'Fiat', 'Palio', '2015', 'KDJ1234');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `characteristics`
--
ALTER TABLE `characteristics`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `characteristic_vehicle`
--
ALTER TABLE `characteristic_vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vehicle` (`vehicle`),
  ADD KEY `fk_characteristic` (`characteristic`);

--
-- Índices para tabela `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `characteristics`
--
ALTER TABLE `characteristics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `characteristic_vehicle`
--
ALTER TABLE `characteristic_vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `characteristic_vehicle`
--
ALTER TABLE `characteristic_vehicle`
  ADD CONSTRAINT `fk_characteristic` FOREIGN KEY (`characteristic`) REFERENCES `characteristics` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vehicle` FOREIGN KEY (`vehicle`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
