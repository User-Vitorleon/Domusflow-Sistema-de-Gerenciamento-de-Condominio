-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Mar-2026 às 15:00
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `domusflow_bd`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `locais_festivos`
--

CREATE TABLE `locais_festivos` (
  `id_local` int(11) NOT NULL,
  `local` varchar(40) DEFAULT NULL,
  `capacidade` int(11) DEFAULT NULL,
  `disp_uso` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `morador`
--

CREATE TABLE `morador` (
  `id_user` int(11) NOT NULL,
  `identificador` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `apto` varchar(20) DEFAULT NULL,
  `bloco` varchar(5) DEFAULT NULL,
  `CPF` varchar(14) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telefone` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservas`
--

CREATE TABLE `reservas` (
  `id_reserv` int(11) NOT NULL,
  `id_local` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `data_reserva` date NOT NULL,
  `hora_reserva` time NOT NULL,
  `status` varchar(1) DEFAULT 'P',
  `id_user_aprov` int(11) DEFAULT NULL,
  `nome_user_aprov` varchar(100) DEFAULT NULL,
  `data_aprov` date DEFAULT NULL,
  `hora_aprov` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `locais_festivos`
--
ALTER TABLE `locais_festivos`
  ADD PRIMARY KEY (`id_local`);

--
-- Índices para tabela `morador`
--
ALTER TABLE `morador`
  ADD PRIMARY KEY (`id_user`);

--
-- Índices para tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserv`),
  ADD KEY `fk_reserva_usuario` (`id_user`),
  ADD KEY `fk_reserva_local` (`id_local`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `locais_festivos`
--
ALTER TABLE `locais_festivos`
  MODIFY `id_local` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `morador`
--
ALTER TABLE `morador`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserv` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reserva_local` FOREIGN KEY (`id_local`) REFERENCES `locais_festivos` (`id_local`),
  ADD CONSTRAINT `fk_reserva_usuario` FOREIGN KEY (`id_user`) REFERENCES `morador` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
