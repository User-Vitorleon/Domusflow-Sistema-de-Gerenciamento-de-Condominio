-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Maio-2026 às 15:27
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
-- Estrutura da tabela `faturas`
--

CREATE TABLE `faturas` (
  `id_fatura` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `valor_total` double DEFAULT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `id_user_cad` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `faturas`
--

INSERT INTO `faturas` (`id_fatura`, `id_user`, `data`, `valor_total`, `descricao`, `id_user_cad`, `created_at`) VALUES
(1, 105, '2026-05-07', 59.06, 'Fatura gerada automaticamente', 2, NULL),
(2, 125, '2026-05-08', 89, 'Fatura gerada automaticamente', 2, NULL),
(3, 125, '2026-05-08', 150, 'Fatura gerada automaticamente', 2, NULL),
(4, 75, '2026-05-08', 55, 'Fatura gerada automaticamente', 2, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lancamentos`
--

CREATE TABLE `lancamentos` (
  `modelo` varchar(50) NOT NULL,
  `valor` double NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `data_vencimento` date NOT NULL,
  `status` varchar(1) NOT NULL,
  `data_lancamento` date NOT NULL,
  `id_user_cad` int(11) NOT NULL,
  `id_lancamento` int(11) NOT NULL,
  `id_fatura` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Extraindo dados da tabela `lancamentos`
--

INSERT INTO `lancamentos` (`modelo`, `valor`, `descricao`, `id_user`, `data_vencimento`, `status`, `data_lancamento`, `id_user_cad`, `id_lancamento`, `id_fatura`) VALUES
('taxa', 59.06, 'taxa janeiro', 105, '2026-05-15', 'P', '2026-05-07', 2, 1, 1),
('taxa', 89, 'TAXA DE JANEIRO', 125, '2026-05-15', 'P', '2026-05-08', 2, 2, 3),
('multa', 150, 'TAXA DE TESTE', 125, '2026-05-22', 'P', '2026-05-08', 2, 3, 3),
('taxa', 5.99, 'LIMPEZA DA PISCINA', 38, '2026-05-15', 'P', '2026-05-08', 2, 4, NULL),
('taxa', 55, 'taxa do quadra', 75, '2026-05-20', 'P', '2026-05-08', 2, 5, 4),
('taxa', 2.69, 'play ground', 125, '2026-05-14', 'P', '2026-05-08', 2, 6, NULL),
('taxa', 25, 'Taxa de limpeza', 0, '2026-05-20', 'P', '2026-05-08', 2, 7, NULL),
('multa', 5.6, 'taxa do porteiro ', 0, '2026-05-30', 'P', '2026-05-08', 2, 8, NULL),
('multa', 15.99, 'taxa para pintar os predios', 5, '2026-05-30', 'P', '2026-05-08', 2, 9, NULL),
('multa', 15.99, 'taxa para pintar os predios', 6, '2026-05-30', 'P', '2026-05-08', 2, 10, NULL),
('multa', 15.99, 'taxa para pintar os predios', 7, '2026-05-30', 'P', '2026-05-08', 2, 11, NULL),
('multa', 15.99, 'taxa para pintar os predios', 8, '2026-05-30', 'P', '2026-05-08', 2, 12, NULL),
('multa', 15.99, 'taxa para pintar os predios', 9, '2026-05-30', 'P', '2026-05-08', 2, 13, NULL),
('multa', 15.99, 'taxa para pintar os predios', 10, '2026-05-30', 'P', '2026-05-08', 2, 14, NULL),
('multa', 15.99, 'taxa para pintar os predios', 11, '2026-05-30', 'P', '2026-05-08', 2, 15, NULL),
('multa', 15.99, 'taxa para pintar os predios', 12, '2026-05-30', 'P', '2026-05-08', 2, 16, NULL),
('multa', 15.99, 'taxa para pintar os predios', 13, '2026-05-30', 'P', '2026-05-08', 2, 17, NULL),
('multa', 15.99, 'taxa para pintar os predios', 14, '2026-05-30', 'P', '2026-05-08', 2, 18, NULL),
('multa', 15.99, 'taxa para pintar os predios', 15, '2026-05-30', 'P', '2026-05-08', 2, 19, NULL),
('multa', 15.99, 'taxa para pintar os predios', 16, '2026-05-30', 'P', '2026-05-08', 2, 20, NULL),
('multa', 15.99, 'taxa para pintar os predios', 17, '2026-05-30', 'P', '2026-05-08', 2, 21, NULL),
('multa', 15.99, 'taxa para pintar os predios', 18, '2026-05-30', 'P', '2026-05-08', 2, 22, NULL),
('multa', 15.99, 'taxa para pintar os predios', 19, '2026-05-30', 'P', '2026-05-08', 2, 23, NULL),
('multa', 15.99, 'taxa para pintar os predios', 20, '2026-05-30', 'P', '2026-05-08', 2, 24, NULL),
('multa', 15.99, 'taxa para pintar os predios', 21, '2026-05-30', 'P', '2026-05-08', 2, 25, NULL),
('multa', 15.99, 'taxa para pintar os predios', 22, '2026-05-30', 'P', '2026-05-08', 2, 26, NULL),
('multa', 15.99, 'taxa para pintar os predios', 23, '2026-05-30', 'P', '2026-05-08', 2, 27, NULL),
('multa', 15.99, 'taxa para pintar os predios', 24, '2026-05-30', 'P', '2026-05-08', 2, 28, NULL),
('multa', 15.99, 'taxa para pintar os predios', 25, '2026-05-30', 'P', '2026-05-08', 2, 29, NULL),
('multa', 15.99, 'taxa para pintar os predios', 26, '2026-05-30', 'P', '2026-05-08', 2, 30, NULL),
('multa', 15.99, 'taxa para pintar os predios', 27, '2026-05-30', 'P', '2026-05-08', 2, 31, NULL),
('multa', 15.99, 'taxa para pintar os predios', 28, '2026-05-30', 'P', '2026-05-08', 2, 32, NULL),
('multa', 15.99, 'taxa para pintar os predios', 29, '2026-05-30', 'P', '2026-05-08', 2, 33, NULL),
('multa', 15.99, 'taxa para pintar os predios', 30, '2026-05-30', 'P', '2026-05-08', 2, 34, NULL),
('multa', 15.99, 'taxa para pintar os predios', 31, '2026-05-30', 'P', '2026-05-08', 2, 35, NULL),
('multa', 15.99, 'taxa para pintar os predios', 32, '2026-05-30', 'P', '2026-05-08', 2, 36, NULL),
('multa', 15.99, 'taxa para pintar os predios', 33, '2026-05-30', 'P', '2026-05-08', 2, 37, NULL),
('multa', 15.99, 'taxa para pintar os predios', 34, '2026-05-30', 'P', '2026-05-08', 2, 38, NULL),
('multa', 15.99, 'taxa para pintar os predios', 35, '2026-05-30', 'P', '2026-05-08', 2, 39, NULL),
('multa', 15.99, 'taxa para pintar os predios', 36, '2026-05-30', 'P', '2026-05-08', 2, 40, NULL),
('multa', 15.99, 'taxa para pintar os predios', 37, '2026-05-30', 'P', '2026-05-08', 2, 41, NULL),
('multa', 15.99, 'taxa para pintar os predios', 38, '2026-05-30', 'P', '2026-05-08', 2, 42, NULL),
('multa', 15.99, 'taxa para pintar os predios', 39, '2026-05-30', 'P', '2026-05-08', 2, 43, NULL),
('multa', 15.99, 'taxa para pintar os predios', 40, '2026-05-30', 'P', '2026-05-08', 2, 44, NULL),
('multa', 15.99, 'taxa para pintar os predios', 41, '2026-05-30', 'P', '2026-05-08', 2, 45, NULL),
('multa', 15.99, 'taxa para pintar os predios', 42, '2026-05-30', 'P', '2026-05-08', 2, 46, NULL),
('multa', 15.99, 'taxa para pintar os predios', 43, '2026-05-30', 'P', '2026-05-08', 2, 47, NULL),
('multa', 15.99, 'taxa para pintar os predios', 44, '2026-05-30', 'P', '2026-05-08', 2, 48, NULL),
('multa', 15.99, 'taxa para pintar os predios', 45, '2026-05-30', 'P', '2026-05-08', 2, 49, NULL),
('multa', 15.99, 'taxa para pintar os predios', 46, '2026-05-30', 'P', '2026-05-08', 2, 50, NULL),
('multa', 15.99, 'taxa para pintar os predios', 47, '2026-05-30', 'P', '2026-05-08', 2, 51, NULL),
('multa', 15.99, 'taxa para pintar os predios', 48, '2026-05-30', 'P', '2026-05-08', 2, 52, NULL),
('multa', 15.99, 'taxa para pintar os predios', 49, '2026-05-30', 'P', '2026-05-08', 2, 53, NULL),
('multa', 15.99, 'taxa para pintar os predios', 50, '2026-05-30', 'P', '2026-05-08', 2, 54, NULL),
('multa', 15.99, 'taxa para pintar os predios', 51, '2026-05-30', 'P', '2026-05-08', 2, 55, NULL),
('multa', 15.99, 'taxa para pintar os predios', 52, '2026-05-30', 'P', '2026-05-08', 2, 56, NULL),
('multa', 15.99, 'taxa para pintar os predios', 53, '2026-05-30', 'P', '2026-05-08', 2, 57, NULL),
('multa', 15.99, 'taxa para pintar os predios', 54, '2026-05-30', 'P', '2026-05-08', 2, 58, NULL),
('multa', 15.99, 'taxa para pintar os predios', 55, '2026-05-30', 'P', '2026-05-08', 2, 59, NULL),
('multa', 15.99, 'taxa para pintar os predios', 56, '2026-05-30', 'P', '2026-05-08', 2, 60, NULL),
('multa', 15.99, 'taxa para pintar os predios', 57, '2026-05-30', 'P', '2026-05-08', 2, 61, NULL),
('multa', 15.99, 'taxa para pintar os predios', 58, '2026-05-30', 'P', '2026-05-08', 2, 62, NULL),
('multa', 15.99, 'taxa para pintar os predios', 59, '2026-05-30', 'P', '2026-05-08', 2, 63, NULL),
('multa', 15.99, 'taxa para pintar os predios', 60, '2026-05-30', 'P', '2026-05-08', 2, 64, NULL),
('multa', 15.99, 'taxa para pintar os predios', 61, '2026-05-30', 'P', '2026-05-08', 2, 65, NULL),
('multa', 15.99, 'taxa para pintar os predios', 62, '2026-05-30', 'P', '2026-05-08', 2, 66, NULL),
('multa', 15.99, 'taxa para pintar os predios', 63, '2026-05-30', 'P', '2026-05-08', 2, 67, NULL),
('multa', 15.99, 'taxa para pintar os predios', 64, '2026-05-30', 'P', '2026-05-08', 2, 68, NULL),
('multa', 15.99, 'taxa para pintar os predios', 65, '2026-05-30', 'P', '2026-05-08', 2, 69, NULL),
('multa', 15.99, 'taxa para pintar os predios', 66, '2026-05-30', 'P', '2026-05-08', 2, 70, NULL),
('multa', 15.99, 'taxa para pintar os predios', 67, '2026-05-30', 'P', '2026-05-08', 2, 71, NULL),
('multa', 15.99, 'taxa para pintar os predios', 68, '2026-05-30', 'P', '2026-05-08', 2, 72, NULL),
('multa', 15.99, 'taxa para pintar os predios', 69, '2026-05-30', 'P', '2026-05-08', 2, 73, NULL),
('multa', 15.99, 'taxa para pintar os predios', 70, '2026-05-30', 'P', '2026-05-08', 2, 74, NULL),
('multa', 15.99, 'taxa para pintar os predios', 71, '2026-05-30', 'P', '2026-05-08', 2, 75, NULL),
('multa', 15.99, 'taxa para pintar os predios', 72, '2026-05-30', 'P', '2026-05-08', 2, 76, NULL),
('multa', 15.99, 'taxa para pintar os predios', 73, '2026-05-30', 'P', '2026-05-08', 2, 77, NULL),
('multa', 15.99, 'taxa para pintar os predios', 74, '2026-05-30', 'P', '2026-05-08', 2, 78, NULL),
('multa', 15.99, 'taxa para pintar os predios', 75, '2026-05-30', 'P', '2026-05-08', 2, 79, NULL),
('multa', 15.99, 'taxa para pintar os predios', 76, '2026-05-30', 'P', '2026-05-08', 2, 80, NULL),
('multa', 15.99, 'taxa para pintar os predios', 77, '2026-05-30', 'P', '2026-05-08', 2, 81, NULL),
('multa', 15.99, 'taxa para pintar os predios', 78, '2026-05-30', 'P', '2026-05-08', 2, 82, NULL),
('multa', 15.99, 'taxa para pintar os predios', 79, '2026-05-30', 'P', '2026-05-08', 2, 83, NULL),
('multa', 15.99, 'taxa para pintar os predios', 80, '2026-05-30', 'P', '2026-05-08', 2, 84, NULL),
('multa', 15.99, 'taxa para pintar os predios', 81, '2026-05-30', 'P', '2026-05-08', 2, 85, NULL),
('multa', 15.99, 'taxa para pintar os predios', 82, '2026-05-30', 'P', '2026-05-08', 2, 86, NULL),
('multa', 15.99, 'taxa para pintar os predios', 83, '2026-05-30', 'P', '2026-05-08', 2, 87, NULL),
('multa', 15.99, 'taxa para pintar os predios', 84, '2026-05-30', 'P', '2026-05-08', 2, 88, NULL),
('multa', 15.99, 'taxa para pintar os predios', 85, '2026-05-30', 'P', '2026-05-08', 2, 89, NULL),
('multa', 15.99, 'taxa para pintar os predios', 86, '2026-05-30', 'P', '2026-05-08', 2, 90, NULL),
('multa', 15.99, 'taxa para pintar os predios', 87, '2026-05-30', 'P', '2026-05-08', 2, 91, NULL),
('multa', 15.99, 'taxa para pintar os predios', 88, '2026-05-30', 'P', '2026-05-08', 2, 92, NULL),
('multa', 15.99, 'taxa para pintar os predios', 89, '2026-05-30', 'P', '2026-05-08', 2, 93, NULL),
('multa', 15.99, 'taxa para pintar os predios', 90, '2026-05-30', 'P', '2026-05-08', 2, 94, NULL),
('multa', 15.99, 'taxa para pintar os predios', 91, '2026-05-30', 'P', '2026-05-08', 2, 95, NULL),
('multa', 15.99, 'taxa para pintar os predios', 92, '2026-05-30', 'P', '2026-05-08', 2, 96, NULL),
('multa', 15.99, 'taxa para pintar os predios', 93, '2026-05-30', 'P', '2026-05-08', 2, 97, NULL),
('multa', 15.99, 'taxa para pintar os predios', 94, '2026-05-30', 'P', '2026-05-08', 2, 98, NULL),
('multa', 15.99, 'taxa para pintar os predios', 95, '2026-05-30', 'P', '2026-05-08', 2, 99, NULL),
('multa', 15.99, 'taxa para pintar os predios', 96, '2026-05-30', 'P', '2026-05-08', 2, 100, NULL),
('multa', 15.99, 'taxa para pintar os predios', 97, '2026-05-30', 'P', '2026-05-08', 2, 101, NULL),
('multa', 15.99, 'taxa para pintar os predios', 98, '2026-05-30', 'P', '2026-05-08', 2, 102, NULL),
('multa', 15.99, 'taxa para pintar os predios', 99, '2026-05-30', 'P', '2026-05-08', 2, 103, NULL),
('multa', 15.99, 'taxa para pintar os predios', 100, '2026-05-30', 'P', '2026-05-08', 2, 104, NULL),
('multa', 15.99, 'taxa para pintar os predios', 101, '2026-05-30', 'P', '2026-05-08', 2, 105, NULL),
('multa', 15.99, 'taxa para pintar os predios', 102, '2026-05-30', 'P', '2026-05-08', 2, 106, NULL),
('multa', 15.99, 'taxa para pintar os predios', 103, '2026-05-30', 'P', '2026-05-08', 2, 107, NULL),
('multa', 15.99, 'taxa para pintar os predios', 104, '2026-05-30', 'P', '2026-05-08', 2, 108, NULL),
('multa', 15.99, 'taxa para pintar os predios', 105, '2026-05-30', 'P', '2026-05-08', 2, 109, NULL),
('multa', 15.99, 'taxa para pintar os predios', 124, '2026-05-30', 'P', '2026-05-08', 2, 110, NULL),
('multa', 15.99, 'taxa para pintar os predios', 125, '2026-05-30', 'P', '2026-05-08', 2, 111, NULL),
('multa', 15.99, 'taxa para pintar os predios', 125, '2026-05-30', 'P', '2026-05-08', 2, 112, NULL),
('multa', 15.99, 'taxa para pintar os predios', 125, '2026-05-30', 'P', '2026-05-08', 2, 113, NULL),
('multa', 15.99, 'taxa para pintar os predios', 125, '2026-05-30', 'P', '2026-05-08', 2, 114, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `locais_festivos`
--

CREATE TABLE `locais_festivos` (
  `id_local` int(11) NOT NULL,
  `local` varchar(60) NOT NULL,
  `capacidade` int(11) NOT NULL DEFAULT 0,
  `disp_uso` char(1) NOT NULL DEFAULT 'S',
  `id_user_cad` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `locais_festivos`
--

INSERT INTO `locais_festivos` (`id_local`, `local`, `capacidade`, `disp_uso`, `id_user_cad`, `created_at`) VALUES
(1, 'Churrasqueira', 100, 'S', 1, '2026-04-09 18:34:39'),
(2, 'Parquinho de Diversão', 10, 'N', 1, '2026-04-09 18:34:39'),
(3, 'Salão de Festa Pequeno', 50, 'S', 1, '2026-04-09 18:34:39');

-- --------------------------------------------------------

--
-- Estrutura da tabela `morador`
--

CREATE TABLE `morador` (
  `id_user` int(11) NOT NULL,
  `identificador` int(11) NOT NULL DEFAULT 1,
  `nome` varchar(100) NOT NULL,
  `apto` varchar(20) NOT NULL,
  `bloco` varchar(5) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `tell_recado` varchar(15) DEFAULT NULL,
  `sexo` char(1) NOT NULL DEFAULT 'M',
  `senha` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'P',
  `privilegio` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `morador`
--

INSERT INTO `morador` (`id_user`, `identificador`, `nome`, `apto`, `bloco`, `cpf`, `email`, `telefone`, `tell_recado`, `sexo`, `senha`, `status`, `privilegio`, `created_at`) VALUES
(1, 1, 'Admin Root', '00', '0', '00000000000', 'admin@domusflow.com', '(11) 00000-0000', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 4, '2026-04-09 18:34:39'),
(2, 1, 'Vitor Leon', '10', '1', '43209957835', 'sindico@domusflow.com.br', '(11) 98522-9900', '(11) 959073260', 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 2, '2026-04-09 18:34:39'),
(3, 1, 'Porteiro Padrão', '00', '0', '11111111111', 'porteiro@domusflow.com', '(11) 00000-0001', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 3, '2026-04-09 18:34:39'),
(5, 1, 'Carlos Silva', '2', 'A', '10433218196', 'carlossilva5@email.com', '(11) 94582-4811', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(6, 1, 'João Oliveira', '1', 'D', '89083863794', 'joaooliveira6@email.com', '(11) 96574-5552', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(7, 1, 'Pedro Santos', '2B', 'D', '23511615594', 'pedrosantos7@email.com', '(11) 99785-3045', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(8, 1, 'Lucas Ferreira', '10', 'B', '61849593103', 'lucasferreira8@email.com', '(11) 92654-7227', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(9, 1, 'Marcos Costa', '18B', 'B', '47525534192', 'marcoscosta9@email.com', '(11) 93677-8573', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(10, 1, 'Rafael Souza', '3', 'E', '64835030564', 'rafaelsouza10@email.com', '(11) 96155-4483', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(11, 1, 'Bruno Lima', '14B', 'D', '76724238849', 'brunolima11@email.com', '(11) 96930-4593', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(12, 1, 'Felipe Pereira', '13A', 'E', '28710122691', 'felipepereira12@email.com', '(11) 98668-9669', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(13, 1, 'Thiago Alves', '15', 'C', '48018451462', 'thiagoalves13@email.com', '(11) 99201-3927', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(14, 1, 'Diego Rocha', '1B', 'C', '81489325288', 'diegorocha14@email.com', '(11) 99005-1319', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(15, 1, 'André Mendes', '18', 'B', '15430391171', 'andremendes15@email.com', '(11) 98787-3705', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(16, 1, 'Gustavo Martins', '17A', 'A', '48963834657', 'gustavomartins16@email.com', '(11) 95061-4681', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(17, 1, 'Ricardo Carvalho', '8', 'A', '15098393010', 'ricardocarvalho17@email.com', '(11) 96413-2160', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(18, 1, 'Leandro Dias', '16A', 'B', '83473829973', 'leandrodias18@email.com', '(11) 92545-2588', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(19, 1, 'Fernando Ribeiro', '8', 'B', '65667010651', 'fernandoribeiro19@email.com', '(11) 99786-8350', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(20, 1, 'Rodrigo Gomes', '18', 'A', '26247317810', 'rodrigogomes20@email.com', '(11) 94872-3724', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(21, 1, 'Fabian Torres', '15A', 'D', '67736026064', 'fabiantorres21@email.com', '(11) 98973-3536', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(22, 1, 'Henrique Nunes', '16B', 'E', '34309805009', 'henriquenunes22@email.com', '(11) 93579-1931', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(23, 1, 'Vinicius Castro', '19B', 'A', '81219136193', 'viniciuscastro23@email.com', '(11) 92343-7868', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(24, 1, 'Eduardo Moreira', '10A', 'C', '99854353462', 'eduardomoreira24@email.com', '(11) 92188-1152', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(25, 1, 'Alexandre Barbosa', '3', 'C', '79911838425', 'alexandrebarbosa25@email.com', '(11) 95669-3584', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(26, 1, 'Mateus Campos', '4', 'E', '78498084124', 'mateuscampos26@email.com', '(11) 93546-5462', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(27, 1, 'Leonardo Cardoso', '14A', 'A', '49353487401', 'leonardocardoso27@email.com', '(11) 91058-6464', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(28, 1, 'Caio Correia', '18', 'C', '24278680112', 'caiocorreia28@email.com', '(11) 93426-8041', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(29, 1, 'Renato Freitas', '14B', 'B', '20450533158', 'renatofreitas29@email.com', '(11) 94878-3662', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(30, 1, 'Daniel Teixeira', '2A', 'B', '26025634216', 'danielteixeira30@email.com', '(11) 94269-8541', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(31, 1, 'Julio Nascimento', '12B', 'E', '54330365414', 'julionascimento31@email.com', '(11) 97548-9785', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(32, 1, 'Sergio Moura', '12B', 'C', '50142940196', 'sergiomoura32@email.com', '(11) 98149-9379', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(33, 1, 'Paulo Andrade', '12A', 'A', '16934060883', 'pauloandrade33@email.com', '(11) 96409-6143', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(34, 1, 'Nelson Viana', '14B', 'D', '14846564823', 'nelsonviana34@email.com', '(11) 93851-5930', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(35, 1, 'Ana Lima', '15A', 'B', '68044369957', 'analima35@email.com', '(11) 99375-8752', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(36, 1, 'Maria Santos', '5', 'A', '21489513433', 'mariasantos36@email.com', '(11) 95011-8784', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(37, 1, 'Carla Oliveira', '1', 'D', '91769367632', 'carlaoliveira37@email.com', '(11) 94585-3881', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(38, 1, 'Juliana Costa', '20A', 'D', '87083172788', 'julianacosta38@email.com', '(11) 99270-7991', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(39, 1, 'Fernanda Silva', '9A', 'A', '87277434873', 'fernandasilva39@email.com', '(11) 95681-4841', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(40, 1, 'Patricia Rocha', '3A', 'D', '45581223623', 'patriciarocha40@email.com', '(11) 96421-9890', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(41, 1, 'Amanda Ferreira', '1A', 'C', '76036690967', 'amandaferreira41@email.com', '(11) 97389-7865', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(42, 1, 'Camila Souza', '11B', 'D', '88937346706', 'camilasouza42@email.com', '(11) 93704-8657', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(43, 1, 'Isabela Pereira', '15', 'A', '29806990162', 'isabelapereira43@email.com', '(11) 95262-7211', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(44, 1, 'Leticia Alves', '1B', 'E', '53755646417', 'leticiaalves44@email.com', '(11) 91853-6733', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(45, 1, 'Gabriela Martins', '16B', 'A', '31003309232', 'gabrielamartins45@email.com', '(11) 94571-8619', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(46, 1, 'Beatriz Gomes', '10B', 'D', '45299124190', 'beatrizgomes46@email.com', '(11) 97498-4249', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(47, 1, 'Larissa Cardoso', '14B', 'C', '19314919058', 'larissacardoso47@email.com', '(11) 92129-9289', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(48, 1, 'Natalia Dias', '17B', 'C', '50671657262', 'nataliadias48@email.com', '(11) 99817-8921', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(49, 1, 'Priscila Ribeiro', '19B', 'D', '76945314737', 'priscilaribeiro49@email.com', '(11) 96511-1470', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(50, 1, 'Tatiana Nunes', '18', 'E', '75273545494', 'tatiananunes50@email.com', '(11) 94130-2402', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(51, 1, 'Vanessa Castro', '8A', 'B', '36783777014', 'vanessacastro51@email.com', '(11) 96016-7046', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(52, 1, 'Renata Moreira', '9', 'A', '78856855744', 'renatamoreira52@email.com', '(11) 94155-6169', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(53, 1, 'Luciana Torres', '4', 'C', '18233749894', 'lucianatorres53@email.com', '(11) 94727-6912', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(54, 1, 'Aline Correia', '16', 'A', '24082400842', 'alinecorreia54@email.com', '(11) 95658-8690', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(55, 1, 'Bruna Freitas', '3B', 'A', '77520471167', 'brunafreitas55@email.com', '(11) 93485-3444', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(56, 1, 'Debora Teixeira', '17A', 'D', '94131869993', 'deborateixeira56@email.com', '(11) 98253-5871', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(57, 1, 'Fabiana Nascimento', '3', 'B', '96499091334', 'fabiananascimento57@email.com', '(11) 93847-2229', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(58, 1, 'Livia Moura', '15', 'B', '20679740344', 'liviamoura58@email.com', '(11) 95334-4241', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(59, 1, 'Paula Andrade', '20B', 'E', '61832421024', 'paulaandrade59@email.com', '(11) 95728-8195', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(60, 1, 'Claudia Viana', '2A', 'C', '17464887719', 'claudiaviana60@email.com', '(11) 95102-1423', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(61, 1, 'Mariana Barbosa', '15A', 'B', '13990490278', 'marianabarbosa61@email.com', '(11) 98141-9056', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(62, 1, 'Simone Campos', '10B', 'D', '17565512567', 'simonecampos62@email.com', '(11) 91601-8451', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(63, 1, 'Viviane Carvalho', '2', 'E', '15451680876', 'vivianecarvalho63@email.com', '(11) 96927-9167', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(64, 1, 'Helena Mendes', '20', 'B', '70348247710', 'helenamendes64@email.com', '(11) 96091-1224', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(65, 1, 'Carlos Silva 60', '9A', 'D', '86131712748', 'carlossilva6065@email.com', '(11) 98736-4993', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(66, 1, 'João Oliveira 61', '11B', 'C', '78263982146', 'joaooliveira6166@email.com', '(11) 91042-5634', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(67, 1, 'Pedro Santos 62', '18A', 'D', '49972787558', 'pedrosantos6267@email.com', '(11) 96272-4090', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(68, 1, 'Lucas Ferreira 63', '16', 'B', '39636057662', 'lucasferreira6368@email.com', '(11) 99229-6439', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(69, 1, 'Marcos Costa 64', '9A', 'E', '17187026217', 'marcoscosta6469@email.com', '(11) 97512-2315', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(70, 1, 'Rafael Souza 65', '8B', 'A', '58657809134', 'rafaelsouza6570@email.com', '(11) 98110-2612', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(71, 1, 'Bruno Lima 66', '14', 'B', '17240050455', 'brunolima6671@email.com', '(11) 99702-7751', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(72, 1, 'Felipe Pereira 67', '5', 'D', '92221969379', 'felipepereira6772@email.com', '(11) 95161-8529', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(73, 1, 'Thiago Alves 68', '14B', 'C', '40748217594', 'thiagoalves6873@email.com', '(11) 98484-5949', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(74, 1, 'Diego Rocha 69', '1B', 'D', '36713695944', 'diegorocha6974@email.com', '(11) 95497-1132', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(75, 1, 'André Mendes 70', '9B', 'B', '90974395339', 'andremendes7075@email.com', '(11) 92591-1645', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(76, 1, 'Gustavo Martins 71', '7', 'E', '47095214562', 'gustavomartins7176@email.com', '(11) 96994-9697', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(77, 1, 'Ricardo Carvalho 72', '8B', 'D', '84247451712', 'ricardocarvalho7277@email.com', '(11) 96992-2479', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(78, 1, 'Leandro Dias 73', '4B', 'B', '60481754965', 'leandrodias7378@email.com', '(11) 98724-1410', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(79, 1, 'Fernando Ribeiro 74', '2', 'C', '98593174612', 'fernandoribeiro7479@email.com', '(11) 99071-2902', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(80, 1, 'Rodrigo Gomes 75', '14B', 'A', '13826758692', 'rodrigogomes7580@email.com', '(11) 99017-7686', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(81, 1, 'Fabian Torres 76', '12', 'D', '40537735158', 'fabiantorres7681@email.com', '(11) 95520-4109', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(82, 1, 'Henrique Nunes 77', '7', 'E', '17139005329', 'henriquenunes7782@email.com', '(11) 94394-4538', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(83, 1, 'Vinicius Castro 78', '4B', 'A', '35290422842', 'viniciuscastro7883@email.com', '(11) 93159-1243', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(84, 1, 'Eduardo Moreira 79', '4B', 'A', '53950240268', 'eduardomoreira7984@email.com', '(11) 98802-8344', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(85, 1, 'Alexandre Barbosa 80', '15B', 'A', '58917839084', 'alexandrebarbosa8085@email.com', '(11) 91996-8847', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(86, 1, 'Mateus Campos 81', '5A', 'E', '66177115921', 'mateuscampos8186@email.com', '(11) 99984-6327', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(87, 1, 'Leonardo Cardoso 82', '7A', 'D', '69847896118', 'leonardocardoso8287@email.com', '(11) 94743-7779', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(88, 1, 'Caio Correia 83', '16', 'A', '57661565452', 'caiocorreia8388@email.com', '(11) 92398-2527', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(89, 1, 'Renato Freitas 84', '14A', 'D', '61528098851', 'renatofreitas8489@email.com', '(11) 91842-5712', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(90, 1, 'Daniel Teixeira 85', '12B', 'C', '94519832731', 'danielteixeira8590@email.com', '(11) 92882-5564', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(91, 1, 'Julio Nascimento 86', '6A', 'C', '93689980940', 'julionascimento8691@email.com', '(11) 96567-6751', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(92, 1, 'Sergio Moura 87', '13A', 'D', '02296120183', 'sergiomoura8792@email.com', '(11) 96585-3578', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(93, 1, 'Paulo Andrade 88', '3A', 'D', '54599102290', 'pauloandrade8893@email.com', '(11) 97947-8957', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(94, 1, 'Nelson Viana 89', '19A', 'E', '97643815614', 'nelsonviana8994@email.com', '(11) 96053-1744', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(95, 1, 'Ana Lima 90', '11', 'A', '36900343244', 'analima9095@email.com', '(11) 99149-8055', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(96, 1, 'Maria Santos 91', '14', 'D', '22683885160', 'mariasantos9196@email.com', '(11) 92275-6129', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(97, 1, 'Carla Oliveira 92', '20A', 'C', '96966416052', 'carlaoliveira9297@email.com', '(11) 92443-8155', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(98, 1, 'Juliana Costa 93', '11', 'A', '13696816453', 'julianacosta9398@email.com', '(11) 99363-2868', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(99, 1, 'Fernanda Silva 94', '6B', 'B', '88355231243', 'fernandasilva9499@email.com', '(11) 92234-3902', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(100, 1, 'Patricia Rocha 95', '3A', 'D', '77997995527', 'patriciarocha95100@email.com', '(11) 95961-5500', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(101, 1, 'Amanda Ferreira 96', '10', 'A', '90581477005', 'amandaferreira96101@email.com', '(11) 99307-7299', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(102, 1, 'Camila Souza 97', '5', 'D', '79807935978', 'camilasouza97102@email.com', '(11) 92695-6626', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(103, 1, 'Isabela Pereira 98', '12A', 'C', '18203778892', 'isabelapereira98103@email.com', '(11) 97347-7697', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(104, 1, 'Leticia Alves 99', '20', 'C', '59051518644', 'leticiaalves99104@email.com', '(11) 92335-3317', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:31:40'),
(105, 1, 'aaa', '11', '1', '15151651515', '2222222@gmail.com', '(11) 15456-4848', '', 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-22 09:54:50'),
(106, 1, 'Roberto Farias', '17B', 'E', '66392332146', 'robertofarias200@email.com', '(11) 92471-9016', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(107, 1, 'Camila Duarte', '19A', 'A', '36993563272', 'camiladuarte201@email.com', '(11) 99662-2438', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(108, 1, 'Felipe Azevedo', '3A', 'E', '75604806358', 'felipeazevedo202@email.com', '(11) 94245-8580', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(109, 1, 'Larissa Pinto', '4', 'B', '05232792820', 'larissapinto203@email.com', '(11) 98761-7865', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(110, 1, 'Gustavo Henrique', '13', 'A', '16124906528', 'gustavohenrique204@email.com', '(11) 94464-8257', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(111, 1, 'Natalia Borges', '14', 'A', '48625702929', 'nataliaborges205@email.com', '(11) 92945-3353', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(112, 1, 'Thiago Monteiro', '4A', 'B', '42262385734', 'thiagomonteiro206@email.com', '(11) 92186-9212', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(113, 1, 'Beatriz Lopes', '14A', 'E', '40905366566', 'beatrizlopes207@email.com', '(11) 92518-3969', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(114, 1, 'Anderson Silva', '8A', 'C', '05673434153', 'andersonsilva208@email.com', '(11) 98178-2312', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'B', 1, '2026-04-22 10:05:44'),
(115, 1, 'Priscila Melo', '14A', 'D', '76418457824', 'priscilamelo209@email.com', '(11) 93611-5625', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(116, 1, 'Rodrigo Batista', '10', 'B', '69973653505', 'rodrigobatista210@email.com', '(11) 95275-7827', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(117, 1, 'Viviane Araujo', '10B', 'B', '36560188308', 'vivianearaujo211@email.com', '(11) 99374-8276', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(118, 1, 'Leonardo Cunha', '4A', 'A', '34678899430', 'leonardocunha212@email.com', '(11) 91523-1955', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(119, 1, 'Debora Nogueira', '6A', 'D', '64589943166', 'deboranogueira213@email.com', '(11) 96391-3104', NULL, 'F', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(120, 1, 'Caio Marques', '19B', 'D', '27668254347', 'caiomarques214@email.com', '(11) 94009-8850', NULL, 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'P', 1, '2026-04-22 10:05:44'),
(124, 1, 'Vitor Leon', '20E', 'F', '43200000000', 'vitor.leon465@gmail.com', '(11) 98522-6649', '', 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-04-24 10:07:40'),
(125, 1, 'AAA', 'AA', 'A', '12121212121', 'AAAAAA@GMAIL.COM', '(11) 98565-9595', '', 'M', '$2y$10$OxGG./OPCNycEDy2WZ3MoOv.FZ2N1u2G6YPjtzmbadiKogGulnvxu', 'L', 1, '2026-05-08 08:37:33');

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_local` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `data_reserva` date NOT NULL,
  `hora_ini` time NOT NULL,
  `hora_fim` time NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'P',
  `id_user_aprov` int(11) DEFAULT NULL,
  `nome_user_aprov` varchar(100) DEFAULT NULL,
  `data_aprov` date DEFAULT NULL,
  `hora_aprov` time DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_local`, `id_user`, `data_reserva`, `hora_ini`, `hora_fim`, `status`, `id_user_aprov`, `nome_user_aprov`, `data_aprov`, `hora_aprov`, `created_at`) VALUES
(1, 1, 20, '2026-02-07', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-02-07', '10:00:00', '2026-04-22 09:31:40'),
(2, 1, 33, '2025-01-24', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(3, 3, 97, '2026-01-24', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-01-24', '10:00:00', '2026-04-22 09:31:40'),
(4, 1, 49, '2025-10-10', '13:00:00', '16:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(5, 1, 97, '2025-02-02', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(6, 1, 7, '2025-07-31', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-07-31', '10:00:00', '2026-04-22 09:31:40'),
(7, 3, 9, '2025-02-19', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(8, 3, 56, '2025-08-28', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-08-28', '10:00:00', '2026-04-22 09:31:40'),
(9, 1, 104, '2025-05-24', '20:00:00', '23:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(10, 3, 34, '2025-11-25', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(11, 1, 23, '2026-02-28', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-02-28', '10:00:00', '2026-04-22 09:31:40'),
(12, 1, 76, '2026-03-14', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(13, 3, 49, '2026-06-22', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(14, 1, 57, '2025-11-04', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-11-04', '10:00:00', '2026-04-22 09:31:40'),
(15, 3, 73, '2025-09-04', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(16, 1, 95, '2026-04-20', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(17, 1, 58, '2026-02-02', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-02-02', '10:00:00', '2026-04-22 09:31:40'),
(18, 1, 47, '2026-04-06', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2026-04-06', '10:00:00', '2026-04-22 09:31:40'),
(19, 1, 97, '2025-02-22', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(20, 1, 82, '2025-03-16', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(21, 1, 80, '2026-05-06', '13:00:00', '16:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(22, 3, 47, '2025-01-16', '13:00:00', '16:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(23, 1, 99, '2026-05-06', '13:00:00', '16:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(24, 1, 95, '2026-02-11', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(25, 3, 104, '2026-01-25', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(26, 3, 50, '2025-09-25', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(27, 3, 68, '2025-04-11', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(28, 1, 45, '2026-01-15', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(29, 1, 77, '2025-05-30', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-05-30', '10:00:00', '2026-04-22 09:31:40'),
(30, 3, 79, '2025-10-30', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-10-30', '10:00:00', '2026-04-22 09:31:40'),
(31, 3, 34, '2025-09-09', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(32, 3, 92, '2025-09-21', '19:00:00', '22:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(33, 3, 87, '2026-04-17', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(34, 1, 50, '2025-05-24', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(35, 1, 74, '2026-06-21', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(36, 1, 14, '2025-01-07', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-01-07', '10:00:00', '2026-04-22 09:31:40'),
(37, 1, 85, '2025-03-11', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-03-11', '10:00:00', '2026-04-22 09:31:40'),
(38, 3, 69, '2026-01-18', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(39, 3, 90, '2026-05-15', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-05-15', '10:00:00', '2026-04-22 09:31:40'),
(40, 3, 75, '2025-01-13', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(41, 3, 40, '2025-01-18', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(42, 3, 91, '2025-07-03', '09:00:00', '12:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(43, 1, 72, '2025-09-04', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(44, 3, 37, '2025-10-01', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-10-01', '10:00:00', '2026-04-22 09:31:40'),
(45, 3, 56, '2025-09-07', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-09-07', '10:00:00', '2026-04-22 09:31:40'),
(46, 1, 15, '2025-04-06', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(47, 3, 75, '2025-02-27', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(48, 3, 15, '2026-03-21', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(49, 1, 17, '2025-08-24', '13:00:00', '16:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(50, 3, 93, '2025-10-05', '08:00:00', '11:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(51, 3, 92, '2025-02-03', '10:00:00', '13:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(52, 1, 45, '2025-08-01', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(53, 3, 96, '2025-03-20', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-03-20', '10:00:00', '2026-04-22 09:31:40'),
(54, 3, 35, '2025-12-06', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(55, 1, 22, '2026-05-28', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2026-05-28', '10:00:00', '2026-04-22 09:31:40'),
(56, 1, 60, '2025-03-19', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(57, 3, 83, '2025-12-01', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(58, 3, 62, '2025-08-22', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(59, 3, 53, '2025-07-10', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-07-10', '10:00:00', '2026-04-22 09:31:40'),
(60, 3, 84, '2025-09-10', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-09-10', '10:00:00', '2026-04-22 09:31:40'),
(61, 3, 24, '2025-06-07', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(62, 1, 18, '2025-01-06', '14:00:00', '17:00:00', 'L', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(63, 3, 102, '2025-04-15', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-04-15', '10:00:00', '2026-04-22 09:31:40'),
(64, 3, 60, '2026-06-09', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-06-09', '10:00:00', '2026-04-22 09:31:40'),
(65, 3, 16, '2025-04-06', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(66, 3, 6, '2026-02-28', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(67, 1, 97, '2026-06-18', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(68, 1, 26, '2025-10-03', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-10-03', '10:00:00', '2026-04-22 09:31:40'),
(69, 1, 23, '2025-06-21', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-06-21', '10:00:00', '2026-04-22 09:31:40'),
(70, 3, 43, '2025-03-20', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-03-20', '10:00:00', '2026-04-22 09:31:40'),
(71, 3, 36, '2025-07-20', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-07-20', '10:00:00', '2026-04-22 09:31:40'),
(72, 1, 43, '2026-02-10', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(73, 3, 53, '2026-03-27', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(74, 1, 88, '2025-11-04', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(75, 1, 93, '2026-05-06', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2026-05-06', '10:00:00', '2026-04-22 09:31:40'),
(76, 3, 55, '2025-10-26', '19:00:00', '22:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(77, 3, 36, '2026-01-21', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(78, 3, 55, '2025-04-27', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(79, 1, 74, '2025-01-28', '19:00:00', '22:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(80, 3, 31, '2025-10-26', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(81, 3, 57, '2025-05-23', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-05-23', '10:00:00', '2026-04-22 09:31:40'),
(82, 1, 89, '2026-03-10', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-03-10', '10:00:00', '2026-04-22 09:31:40'),
(83, 3, 81, '2026-02-15', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(84, 3, 93, '2025-02-07', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(85, 1, 73, '2025-04-22', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(86, 1, 50, '2025-02-15', '18:00:00', '21:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(87, 3, 47, '2025-04-19', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-04-19', '10:00:00', '2026-04-22 09:31:40'),
(88, 1, 33, '2026-04-02', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(89, 1, 103, '2025-12-20', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(90, 3, 42, '2025-03-29', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(91, 1, 98, '2025-12-23', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(92, 3, 31, '2025-12-23', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-12-23', '10:00:00', '2026-04-22 09:31:40'),
(93, 3, 97, '2025-11-23', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(94, 1, 95, '2025-01-24', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(95, 1, 91, '2025-09-07', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-09-07', '10:00:00', '2026-04-22 09:31:40'),
(96, 3, 25, '2026-03-13', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-03-13', '10:00:00', '2026-04-22 09:31:40'),
(97, 1, 56, '2025-07-10', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(98, 1, 99, '2026-04-06', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(99, 1, 95, '2025-07-30', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(100, 1, 13, '2025-07-11', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(101, 1, 63, '2025-09-26', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(102, 3, 86, '2026-02-02', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(103, 3, 49, '2026-04-14', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(104, 3, 95, '2025-03-28', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(105, 3, 35, '2025-04-30', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(106, 3, 23, '2026-03-05', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(107, 1, 59, '2026-05-14', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(108, 1, 87, '2025-06-20', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-06-20', '10:00:00', '2026-04-22 09:31:40'),
(109, 3, 28, '2026-04-07', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(110, 3, 6, '2025-05-20', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(111, 3, 76, '2026-02-23', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(112, 3, 61, '2025-06-21', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(113, 1, 102, '2025-10-27', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-10-27', '10:00:00', '2026-04-22 09:31:40'),
(114, 3, 73, '2025-06-22', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(115, 3, 103, '2026-06-08', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(116, 3, 39, '2025-02-12', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(117, 1, 59, '2025-09-11', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(118, 3, 9, '2025-09-27', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(119, 3, 16, '2025-05-01', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-05-01', '10:00:00', '2026-04-22 09:31:40'),
(120, 3, 99, '2026-03-15', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(121, 1, 31, '2025-03-02', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(122, 1, 81, '2025-11-28', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-11-28', '10:00:00', '2026-04-22 09:31:40'),
(123, 1, 39, '2025-05-19', '18:00:00', '21:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(124, 1, 40, '2025-05-16', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-05-16', '10:00:00', '2026-04-22 09:31:40'),
(125, 1, 46, '2026-02-07', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-02-07', '10:00:00', '2026-04-22 09:31:40'),
(126, 3, 85, '2026-03-01', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(127, 1, 86, '2026-02-17', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(128, 3, 93, '2026-04-11', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(129, 1, 5, '2026-04-15', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(130, 3, 73, '2025-08-12', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(131, 3, 68, '2025-11-27', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(132, 1, 78, '2026-05-12', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(133, 1, 102, '2025-02-17', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(134, 1, 63, '2025-05-08', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(135, 3, 5, '2025-07-27', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(136, 1, 43, '2025-10-08', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(137, 1, 37, '2026-01-16', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-01-16', '10:00:00', '2026-04-22 09:31:40'),
(138, 3, 85, '2025-08-28', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(139, 1, 95, '2025-01-02', '13:00:00', '16:00:00', 'L', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(140, 1, 21, '2026-06-16', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-06-16', '10:00:00', '2026-04-22 09:31:40'),
(141, 3, 94, '2025-05-04', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(142, 1, 66, '2025-08-23', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-08-23', '10:00:00', '2026-04-22 09:31:40'),
(143, 1, 18, '2025-11-17', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(144, 3, 22, '2025-05-17', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-05-17', '10:00:00', '2026-04-22 09:31:40'),
(145, 1, 77, '2025-06-18', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(146, 1, 32, '2026-02-26', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(147, 1, 16, '2025-05-24', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(148, 3, 54, '2026-03-16', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(149, 3, 36, '2025-03-28', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(150, 3, 81, '2025-01-28', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-01-28', '10:00:00', '2026-04-22 09:31:40'),
(151, 1, 82, '2026-02-06', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(152, 3, 35, '2026-01-31', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-01-31', '10:00:00', '2026-04-22 09:31:40'),
(153, 1, 86, '2026-06-25', '08:00:00', '11:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(154, 1, 45, '2026-02-01', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(155, 1, 92, '2026-04-28', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-04-28', '10:00:00', '2026-04-22 09:31:40'),
(156, 1, 13, '2025-09-26', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-09-26', '10:00:00', '2026-04-22 09:31:40'),
(157, 3, 12, '2026-06-03', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(158, 3, 69, '2026-03-10', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-03-10', '10:00:00', '2026-04-22 09:31:40'),
(159, 1, 73, '2025-10-12', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(160, 1, 70, '2025-06-09', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(161, 1, 80, '2025-11-14', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(162, 1, 35, '2025-09-08', '09:00:00', '12:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(163, 3, 19, '2025-02-26', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(164, 1, 89, '2025-05-03', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(165, 1, 94, '2025-06-17', '19:00:00', '22:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(166, 3, 71, '2025-06-20', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-06-20', '10:00:00', '2026-04-22 09:31:40'),
(167, 3, 104, '2025-05-01', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(168, 3, 59, '2026-06-21', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-06-21', '10:00:00', '2026-04-22 09:31:40'),
(169, 1, 78, '2026-05-24', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(170, 3, 12, '2025-06-20', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-06-20', '10:00:00', '2026-04-22 09:31:40'),
(171, 1, 103, '2025-04-29', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(172, 1, 5, '2025-01-13', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-01-13', '10:00:00', '2026-04-22 09:31:40'),
(173, 3, 51, '2025-06-03', '10:00:00', '13:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(174, 3, 9, '2025-08-18', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-08-18', '10:00:00', '2026-04-22 09:31:40'),
(175, 3, 97, '2025-10-05', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(176, 1, 20, '2025-07-03', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(177, 3, 10, '2025-03-12', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(178, 3, 104, '2025-12-02', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(179, 3, 6, '2025-07-25', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(180, 1, 43, '2026-04-21', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(181, 1, 68, '2025-09-09', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-09-09', '10:00:00', '2026-04-22 09:31:40'),
(182, 1, 57, '2025-08-27', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(183, 1, 93, '2025-12-10', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(184, 3, 53, '2025-04-17', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(185, 3, 35, '2026-05-19', '08:00:00', '11:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(186, 3, 23, '2025-04-06', '08:00:00', '11:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(187, 3, 71, '2026-01-17', '19:00:00', '22:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(188, 1, 15, '2026-06-02', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(189, 1, 55, '2025-03-05', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(190, 1, 21, '2025-10-26', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(191, 3, 55, '2025-11-22', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-11-22', '10:00:00', '2026-04-22 09:31:40'),
(192, 1, 14, '2025-05-20', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-05-20', '10:00:00', '2026-04-22 09:31:40'),
(193, 3, 26, '2026-04-23', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(194, 3, 73, '2025-08-01', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(195, 1, 38, '2025-04-03', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(196, 1, 43, '2025-08-09', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-08-09', '10:00:00', '2026-04-22 09:31:40'),
(197, 1, 96, '2025-12-31', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(198, 3, 91, '2025-09-24', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-09-24', '10:00:00', '2026-04-22 09:31:40'),
(199, 3, 56, '2025-09-13', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(200, 1, 22, '2025-01-13', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(201, 1, 33, '2025-07-22', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(202, 1, 85, '2025-09-23', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-09-23', '10:00:00', '2026-04-22 09:31:40'),
(203, 1, 13, '2026-03-31', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-03-31', '10:00:00', '2026-04-22 09:31:40'),
(204, 1, 47, '2025-02-13', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-02-13', '10:00:00', '2026-04-22 09:31:40'),
(205, 3, 78, '2026-02-09', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-02-09', '10:00:00', '2026-04-22 09:31:40'),
(206, 3, 92, '2025-06-26', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-06-26', '10:00:00', '2026-04-22 09:31:40'),
(207, 3, 28, '2025-10-14', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(208, 1, 9, '2025-10-30', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(209, 3, 75, '2025-03-04', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-03-04', '10:00:00', '2026-04-22 09:31:40'),
(210, 3, 22, '2025-07-24', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-07-24', '10:00:00', '2026-04-22 09:31:40'),
(211, 1, 74, '2026-01-27', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(212, 3, 67, '2026-05-30', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(213, 1, 28, '2025-11-23', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-11-23', '10:00:00', '2026-04-22 09:31:40'),
(214, 3, 104, '2025-03-01', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(215, 1, 103, '2025-06-13', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-06-13', '10:00:00', '2026-04-22 09:31:40'),
(216, 3, 35, '2025-02-27', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(217, 3, 54, '2025-06-27', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-06-27', '10:00:00', '2026-04-22 09:31:40'),
(218, 3, 45, '2025-01-29', '15:00:00', '18:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(219, 1, 77, '2025-07-12', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(220, 3, 27, '2025-02-08', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-02-08', '10:00:00', '2026-04-22 09:31:40'),
(221, 1, 82, '2025-01-21', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(222, 1, 47, '2025-05-14', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(223, 1, 46, '2025-01-23', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(224, 1, 23, '2026-06-23', '15:00:00', '18:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(225, 3, 52, '2025-04-14', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(226, 1, 22, '2026-03-24', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(227, 3, 27, '2025-08-17', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(228, 3, 98, '2025-05-11', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(229, 3, 94, '2025-02-03', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(230, 1, 83, '2025-04-17', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-04-17', '10:00:00', '2026-04-22 09:31:40'),
(231, 1, 100, '2025-09-01', '15:00:00', '18:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(232, 1, 26, '2025-12-10', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-12-10', '10:00:00', '2026-04-22 09:31:40'),
(233, 1, 31, '2025-03-11', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-03-11', '10:00:00', '2026-04-22 09:31:40'),
(234, 1, 18, '2025-02-19', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(235, 1, 58, '2026-02-28', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(236, 3, 49, '2025-04-14', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(237, 1, 78, '2025-06-16', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-06-16', '10:00:00', '2026-04-22 09:31:40'),
(238, 3, 9, '2025-01-21', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-01-21', '10:00:00', '2026-04-22 09:31:40'),
(239, 1, 18, '2025-12-17', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(240, 1, 25, '2025-04-06', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(241, 3, 83, '2025-02-01', '18:00:00', '21:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(242, 3, 26, '2025-06-10', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-06-10', '10:00:00', '2026-04-22 09:31:40'),
(243, 1, 31, '2026-02-24', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(244, 3, 98, '2025-10-16', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-10-16', '10:00:00', '2026-04-22 09:31:40'),
(245, 3, 11, '2026-05-18', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-05-18', '10:00:00', '2026-04-22 09:31:40'),
(246, 3, 5, '2025-03-31', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(247, 3, 85, '2025-07-24', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-07-24', '10:00:00', '2026-04-22 09:31:40'),
(248, 3, 26, '2025-03-25', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(249, 3, 44, '2026-04-28', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(250, 1, 38, '2026-02-01', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(251, 3, 53, '2025-07-11', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-07-11', '10:00:00', '2026-04-22 09:31:40'),
(252, 3, 61, '2025-09-27', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(253, 1, 77, '2025-06-04', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-06-04', '10:00:00', '2026-04-22 09:31:40'),
(254, 3, 49, '2025-08-21', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-08-21', '10:00:00', '2026-04-22 09:31:40'),
(255, 3, 54, '2026-05-02', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(256, 3, 15, '2025-02-05', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(257, 1, 71, '2025-05-04', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-05-04', '10:00:00', '2026-04-22 09:31:40'),
(258, 1, 26, '2025-07-17', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-07-17', '10:00:00', '2026-04-22 09:31:40'),
(259, 3, 15, '2025-07-26', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(260, 3, 38, '2025-03-10', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(261, 3, 55, '2025-10-10', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(262, 3, 6, '2025-04-26', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-04-26', '10:00:00', '2026-04-22 09:31:40'),
(263, 1, 77, '2025-04-19', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(264, 3, 73, '2026-02-25', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(265, 3, 67, '2025-02-08', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-02-08', '10:00:00', '2026-04-22 09:31:40'),
(266, 3, 23, '2025-02-09', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(267, 1, 47, '2025-02-20', '19:00:00', '22:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(268, 1, 52, '2025-12-12', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(269, 1, 67, '2025-08-22', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(270, 3, 100, '2025-11-25', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(271, 1, 82, '2025-07-12', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-07-12', '10:00:00', '2026-04-22 09:31:40'),
(272, 3, 57, '2026-06-13', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(273, 1, 70, '2025-03-09', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(274, 1, 56, '2026-06-21', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-06-21', '10:00:00', '2026-04-22 09:31:40'),
(275, 1, 30, '2025-09-13', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(276, 1, 51, '2025-10-08', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(277, 3, 69, '2025-05-07', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-05-07', '10:00:00', '2026-04-22 09:31:40'),
(278, 3, 67, '2025-07-01', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(279, 3, 49, '2025-06-17', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(280, 1, 93, '2025-10-19', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(281, 1, 25, '2025-08-15', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(282, 3, 39, '2026-06-10', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(283, 1, 103, '2026-05-01', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(284, 1, 81, '2025-08-18', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(285, 3, 44, '2026-03-10', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(286, 3, 63, '2025-08-12', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(287, 3, 71, '2025-04-15', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(288, 3, 89, '2025-10-17', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(289, 1, 66, '2025-12-11', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(290, 3, 40, '2025-11-02', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-11-02', '10:00:00', '2026-04-22 09:31:40'),
(291, 1, 102, '2025-02-28', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(292, 1, 92, '2025-01-27', '19:00:00', '22:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(293, 3, 38, '2026-02-19', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(294, 1, 79, '2025-12-18', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(295, 3, 86, '2026-01-03', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(296, 1, 26, '2025-10-28', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(297, 3, 99, '2025-07-07', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(298, 3, 33, '2025-08-17', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(299, 3, 47, '2025-09-24', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(300, 3, 20, '2025-02-24', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(301, 1, 29, '2026-01-26', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-01-26', '10:00:00', '2026-04-22 09:31:40'),
(302, 1, 11, '2025-05-21', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(303, 3, 77, '2025-05-27', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(304, 1, 28, '2026-05-15', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(305, 3, 27, '2025-03-01', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(306, 1, 31, '2025-06-12', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(307, 1, 104, '2025-05-13', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(308, 3, 56, '2026-05-04', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-05-04', '10:00:00', '2026-04-22 09:31:40'),
(309, 1, 73, '2026-01-18', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(310, 1, 101, '2025-01-19', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(311, 1, 36, '2025-12-19', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-12-19', '10:00:00', '2026-04-22 09:31:40'),
(312, 3, 54, '2025-06-21', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(313, 3, 43, '2026-04-12', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(314, 3, 48, '2025-05-18', '15:00:00', '18:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(315, 3, 67, '2025-07-12', '10:00:00', '13:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(316, 1, 56, '2025-08-22', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(317, 1, 21, '2025-01-23', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-01-23', '10:00:00', '2026-04-22 09:31:40'),
(318, 1, 51, '2026-01-20', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(319, 1, 84, '2025-02-19', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(320, 1, 7, '2025-04-29', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(321, 3, 20, '2026-05-01', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-05-01', '10:00:00', '2026-04-22 09:31:40'),
(322, 1, 92, '2025-11-05', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(323, 3, 89, '2025-05-21', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(324, 1, 18, '2025-10-17', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(325, 1, 68, '2025-07-24', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(326, 3, 30, '2026-02-24', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-02-24', '10:00:00', '2026-04-22 09:31:40'),
(327, 3, 75, '2025-08-01', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(328, 1, 5, '2025-04-02', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(329, 3, 90, '2025-06-02', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(330, 1, 14, '2025-09-20', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(331, 3, 42, '2026-04-21', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-04-21', '10:00:00', '2026-04-22 09:31:40'),
(332, 1, 27, '2025-10-25', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(333, 3, 45, '2025-04-29', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(334, 1, 10, '2025-05-22', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(335, 3, 61, '2025-04-06', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(336, 1, 28, '2026-02-15', '18:00:00', '21:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(337, 3, 39, '2026-05-05', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(338, 1, 26, '2025-05-16', '08:00:00', '11:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(339, 1, 25, '2026-03-03', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(340, 3, 91, '2025-07-05', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(341, 1, 83, '2025-05-14', '19:00:00', '22:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(342, 3, 19, '2026-03-28', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-03-28', '10:00:00', '2026-04-22 09:31:40'),
(343, 3, 88, '2025-01-13', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(344, 1, 78, '2025-12-13', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(345, 1, 94, '2026-03-20', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(346, 3, 89, '2025-06-02', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(347, 1, 83, '2025-01-12', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(348, 3, 65, '2025-06-19', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(349, 1, 46, '2025-12-05', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-12-05', '10:00:00', '2026-04-22 09:31:40'),
(350, 3, 33, '2026-02-17', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-02-17', '10:00:00', '2026-04-22 09:31:40'),
(351, 3, 61, '2025-04-01', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(352, 3, 20, '2025-01-19', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(353, 1, 9, '2025-04-04', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(354, 1, 76, '2026-04-13', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(355, 1, 11, '2026-04-11', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(356, 3, 84, '2026-01-08', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-01-08', '10:00:00', '2026-04-22 09:31:40'),
(357, 1, 102, '2025-01-03', '15:00:00', '18:00:00', 'R', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(358, 3, 86, '2026-06-19', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(359, 1, 10, '2026-05-20', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(360, 3, 100, '2025-04-20', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(361, 1, 29, '2026-02-07', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(362, 3, 29, '2025-04-21', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-04-21', '10:00:00', '2026-04-22 09:31:40'),
(363, 1, 86, '2026-04-07', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(364, 1, 69, '2026-05-26', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(365, 3, 11, '2026-05-10', '20:00:00', '23:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(366, 1, 27, '2025-05-12', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:40'),
(367, 3, 81, '2026-06-01', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(368, 1, 82, '2025-10-08', '18:00:00', '21:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(369, 3, 42, '2025-05-17', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(370, 3, 94, '2025-11-18', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(371, 1, 30, '2025-10-25', '15:00:00', '18:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(372, 1, 21, '2026-05-31', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(373, 1, 46, '2025-12-27', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(374, 3, 78, '2025-10-20', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(375, 1, 71, '2025-01-26', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-01-26', '10:00:00', '2026-04-22 09:31:41'),
(376, 1, 90, '2025-07-24', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(377, 3, 25, '2025-09-14', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(378, 3, 93, '2025-07-28', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-07-28', '10:00:00', '2026-04-22 09:31:41'),
(379, 1, 62, '2025-08-18', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(380, 3, 70, '2025-02-18', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(381, 3, 92, '2025-02-25', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(382, 3, 30, '2025-08-19', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(383, 1, 74, '2025-07-18', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(384, 1, 92, '2025-07-11', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(385, 3, 20, '2025-02-11', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-02-11', '10:00:00', '2026-04-22 09:31:41'),
(386, 1, 38, '2025-06-14', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-06-14', '10:00:00', '2026-04-22 09:31:41'),
(387, 1, 64, '2025-02-10', '10:00:00', '13:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(388, 1, 81, '2025-11-05', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(389, 3, 75, '2025-03-16', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(390, 1, 28, '2026-06-02', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(391, 3, 73, '2025-04-05', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-04-05', '10:00:00', '2026-04-22 09:31:41'),
(392, 3, 32, '2025-12-06', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-12-06', '10:00:00', '2026-04-22 09:31:41'),
(393, 3, 101, '2025-01-10', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(394, 1, 62, '2025-09-07', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(395, 3, 46, '2025-04-27', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-04-27', '10:00:00', '2026-04-22 09:31:41'),
(396, 3, 97, '2025-01-26', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(397, 3, 52, '2026-05-14', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-05-14', '10:00:00', '2026-04-22 09:31:41'),
(398, 1, 88, '2025-11-25', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-11-25', '10:00:00', '2026-04-22 09:31:41'),
(399, 1, 17, '2025-01-08', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-01-08', '10:00:00', '2026-04-22 09:31:41'),
(400, 1, 85, '2026-03-11', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-03-11', '10:00:00', '2026-04-22 09:31:41'),
(401, 3, 94, '2025-03-15', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-03-15', '10:00:00', '2026-04-22 09:31:41'),
(402, 3, 96, '2025-02-08', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-02-08', '10:00:00', '2026-04-22 09:31:41'),
(403, 3, 27, '2025-03-14', '13:00:00', '16:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(404, 3, 57, '2026-04-07', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(405, 3, 7, '2025-05-02', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-05-02', '10:00:00', '2026-04-22 09:31:41'),
(406, 1, 97, '2025-02-16', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(407, 1, 69, '2025-10-24', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(408, 3, 41, '2026-01-26', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(409, 3, 8, '2025-06-10', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-06-10', '10:00:00', '2026-04-22 09:31:41'),
(410, 3, 100, '2025-10-30', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-10-30', '10:00:00', '2026-04-22 09:31:41'),
(411, 3, 98, '2025-01-12', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(412, 1, 23, '2025-02-12', '08:00:00', '11:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(413, 1, 55, '2025-11-09', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(414, 3, 97, '2025-08-05', '18:00:00', '21:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(415, 1, 70, '2025-06-14', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-06-14', '10:00:00', '2026-04-22 09:31:41'),
(416, 1, 37, '2025-04-28', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(417, 1, 77, '2026-04-18', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-04-18', '10:00:00', '2026-04-22 09:31:41'),
(418, 1, 90, '2025-09-14', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-09-14', '10:00:00', '2026-04-22 09:31:41'),
(419, 3, 79, '2025-12-05', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-12-05', '10:00:00', '2026-04-22 09:31:41'),
(420, 1, 88, '2025-04-13', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(421, 3, 29, '2026-05-13', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(422, 3, 89, '2025-06-06', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(423, 1, 59, '2025-01-05', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-01-05', '10:00:00', '2026-04-22 09:31:41'),
(424, 3, 33, '2025-10-11', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-10-11', '10:00:00', '2026-04-22 09:31:41'),
(425, 3, 98, '2026-05-07', '19:00:00', '22:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(426, 3, 104, '2026-05-14', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-05-14', '10:00:00', '2026-04-22 09:31:41'),
(427, 1, 87, '2025-10-15', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(428, 3, 30, '2025-03-20', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(429, 1, 69, '2026-02-19', '13:00:00', '16:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(430, 3, 75, '2026-04-29', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(431, 3, 33, '2025-05-18', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(432, 3, 16, '2026-01-08', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-01-08', '10:00:00', '2026-04-22 09:31:41'),
(433, 1, 35, '2026-06-11', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(434, 1, 27, '2026-05-11', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2026-05-11', '10:00:00', '2026-04-22 09:31:41'),
(435, 3, 102, '2025-08-26', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-08-26', '10:00:00', '2026-04-22 09:31:41'),
(436, 1, 34, '2025-07-31', '20:00:00', '23:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(437, 3, 51, '2026-04-26', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(438, 3, 10, '2025-04-16', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(439, 3, 40, '2025-06-28', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(440, 1, 51, '2026-06-14', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(441, 3, 33, '2025-12-28', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(442, 1, 66, '2026-05-29', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(443, 1, 34, '2026-06-11', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-06-11', '10:00:00', '2026-04-22 09:31:41'),
(444, 1, 28, '2026-01-06', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(445, 3, 58, '2025-04-27', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(446, 1, 66, '2025-06-15', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-06-15', '10:00:00', '2026-04-22 09:31:41'),
(447, 1, 10, '2025-06-14', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(448, 1, 10, '2025-02-27', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-02-27', '10:00:00', '2026-04-22 09:31:41'),
(449, 3, 28, '2025-01-20', '14:00:00', '17:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(450, 3, 32, '2026-04-28', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-04-28', '10:00:00', '2026-04-22 09:31:41'),
(451, 1, 57, '2025-07-06', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-07-06', '10:00:00', '2026-04-22 09:31:41'),
(452, 3, 97, '2026-04-10', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-04-10', '10:00:00', '2026-04-22 09:31:41'),
(453, 1, 54, '2025-04-22', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-04-22', '10:00:00', '2026-04-22 09:31:41'),
(454, 3, 69, '2025-06-03', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-06-03', '10:00:00', '2026-04-22 09:31:41'),
(455, 1, 83, '2026-05-31', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-05-31', '10:00:00', '2026-04-22 09:31:41'),
(456, 1, 89, '2025-01-02', '18:00:00', '21:00:00', 'L', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(457, 1, 52, '2026-03-16', '13:00:00', '16:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(458, 3, 66, '2025-12-25', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(459, 3, 37, '2025-08-27', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-08-27', '10:00:00', '2026-04-22 09:31:41'),
(460, 3, 74, '2025-09-21', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-09-21', '10:00:00', '2026-04-22 09:31:41'),
(461, 1, 100, '2026-06-20', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(462, 1, 53, '2025-11-20', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(463, 3, 24, '2025-09-17', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41');
INSERT INTO `reservas` (`id_reserva`, `id_local`, `id_user`, `data_reserva`, `hora_ini`, `hora_fim`, `status`, `id_user_aprov`, `nome_user_aprov`, `data_aprov`, `hora_aprov`, `created_at`) VALUES
(464, 3, 59, '2025-10-10', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(465, 3, 57, '2025-07-03', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(466, 3, 66, '2025-11-11', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(467, 1, 55, '2025-05-02', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(468, 1, 94, '2025-04-13', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(487, 1, 38, '2025-10-22', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(488, 3, 100, '2025-03-19', '20:00:00', '23:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(489, 3, 65, '2025-12-29', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(490, 1, 39, '2025-07-14', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(491, 1, 35, '2025-09-29', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-09-29', '10:00:00', '2026-04-22 09:31:41'),
(492, 3, 36, '2025-06-09', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-06-09', '10:00:00', '2026-04-22 09:31:41'),
(502, 1, 38, '2025-09-27', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-09-27', '10:00:00', '2026-04-22 09:31:41'),
(507, 3, 76, '2026-01-26', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-01-26', '10:00:00', '2026-04-22 09:31:41'),
(508, 1, 99, '2026-04-30', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-04-30', '10:00:00', '2026-04-22 09:31:41'),
(509, 1, 68, '2026-06-14', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(511, 3, 11, '2025-04-12', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-04-12', '10:00:00', '2026-04-22 09:31:41'),
(513, 3, 38, '2026-01-04', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(514, 3, 37, '2025-01-21', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-01-21', '10:00:00', '2026-04-22 09:31:41'),
(515, 1, 91, '2025-06-28', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(516, 3, 91, '2026-04-03', '09:00:00', '12:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(517, 3, 41, '2025-05-29', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(518, 3, 48, '2026-02-19', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-02-19', '10:00:00', '2026-04-22 09:31:41'),
(519, 1, 48, '2025-11-18', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(520, 3, 95, '2026-02-09', '14:00:00', '17:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(521, 3, 104, '2026-06-18', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(522, 1, 28, '2025-05-09', '13:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(523, 1, 100, '2025-08-04', '10:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(524, 1, 17, '2026-04-30', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-04-30', '10:00:00', '2026-04-22 09:31:41'),
(525, 3, 103, '2026-06-21', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-06-21', '10:00:00', '2026-04-22 09:31:41'),
(526, 1, 84, '2025-03-28', '18:00:00', '21:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(527, 3, 36, '2026-03-30', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-03-30', '10:00:00', '2026-04-22 09:31:41'),
(528, 1, 26, '2025-02-05', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(529, 3, 46, '2026-04-24', '20:00:00', '23:00:00', 'N', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(530, 3, 75, '2025-05-19', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-05-19', '10:00:00', '2026-04-22 09:31:41'),
(531, 3, 81, '2026-03-22', '20:00:00', '23:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(532, 3, 73, '2025-12-22', '19:00:00', '22:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(533, 3, 16, '2025-11-12', '15:00:00', '18:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-22 09:31:41'),
(851, 1, 124, '2026-05-01', '06:00:00', '13:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-24 10:09:19'),
(852, 3, 124, '2026-05-02', '07:00:00', '16:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-24 10:43:57'),
(853, 1, 124, '2026-04-27', '10:00:00', '19:00:00', 'P', NULL, NULL, NULL, NULL, '2026-04-24 11:08:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `taxas_padrao`
--

CREATE TABLE `taxas_padrao` (
  `id_taxa` int(11) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
  `usuario_cad` varchar(100) NOT NULL,
  `data_cad` date DEFAULT NULL,
  `modulo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `taxas_padrao`
--

INSERT INTO `taxas_padrao` (`id_taxa`, `descricao`, `valor`, `status`, `usuario_cad`, `data_cad`, `modulo`) VALUES
(1, 'taxa do quadra', 55, 'A', 'VITOR LEON', '2026-05-06', 'TAXA'),
(2, 'taxa do quadra', 55, 'A', 'VITOR LEON', '2026-04-08', 'TAXA'),
(3, 'Taxa de limpeza', 25, 'A', 'VITOR LEON', '2026-05-01', 'TAXA'),
(4, 'taxa do porteiro ', 5.6, 'A', 'VITOR LEON', '2026-05-03', 'MULTA'),
(5, 'taxa para pintar os predios', 15.99, 'A', 'VITOR LEON', '2026-05-05', 'MULTA'),
(7, 'LIMPEZA DA PISCINA', 5.99, 'A', 'Vitor Leon', '2026-05-08', 'TAXA'),
(8, 'play ground', 2.69, 'A', 'Vitor Leon', '2026-05-08', 'taxa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculos`
--

CREATE TABLE `veiculos` (
  `id_veiculo` int(11) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `marca` varchar(60) NOT NULL,
  `modelo` varchar(60) NOT NULL,
  `cor` varchar(30) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_user_cad` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `veiculos`
--

INSERT INTO `veiculos` (`id_veiculo`, `placa`, `marca`, `modelo`, `cor`, `id_user`, `id_user_cad`, `created_at`) VALUES
(1, 'IRR3112', 'Volkswagen', 'Polo', 'Preto', 5, 2, '2026-04-22 09:31:40'),
(2, 'IJU3093', 'Honda', 'Fit', 'Preto', 5, 2, '2026-04-22 09:31:40'),
(3, 'LJJ3953', 'Hyundai', 'HB20', 'Azul', 6, 2, '2026-04-22 09:31:40'),
(4, 'MFD2264', 'Nissan', 'Kicks', 'Preto', 7, 2, '2026-04-22 09:31:40'),
(5, 'NOT9626', 'Toyota', 'Corolla', 'Azul', 7, 2, '2026-04-22 09:31:40'),
(6, 'QPE3962', 'Volkswagen', 'Polo', 'Prata', 8, 2, '2026-04-22 09:31:40'),
(7, 'SBJ4891', 'Mitsubishi', 'Outlander', 'Laranja', 8, 2, '2026-04-22 09:31:40'),
(8, 'TLN6070', 'Peugeot', '208', 'Cinza', 9, 2, '2026-04-22 09:31:40'),
(9, 'YZM5616', 'Audi', 'A3', 'Dourado', 10, 2, '2026-04-22 09:31:40'),
(10, 'ZVU3267', 'Jeep', 'Renegade', 'Branco', 11, 2, '2026-04-22 09:31:40'),
(11, 'WOC9452', 'Chevrolet', 'Onix', 'Vermelho', 12, 2, '2026-04-22 09:31:40'),
(12, 'NVC4637', 'Mitsubishi', 'Outlander', 'Azul', 15, 2, '2026-04-22 09:31:40'),
(13, 'KKJ7326', 'Fiat', 'Uno', 'Azul', 16, 2, '2026-04-22 09:31:40'),
(14, 'FIC6493', 'Volkswagen', 'Gol', 'Prata', 16, 2, '2026-04-22 09:31:40'),
(15, 'MVT8685', 'Mitsubishi', 'Outlander', 'Laranja', 18, 2, '2026-04-22 09:31:40'),
(16, 'ACG3449', 'Toyota', 'Yaris', 'Laranja', 18, 2, '2026-04-22 09:31:40'),
(17, 'CHH1782', 'Renault', 'Kwid', 'Verde', 19, 2, '2026-04-22 09:31:40'),
(18, 'QBV9189', 'Volkswagen', 'Polo', 'Dourado', 20, 2, '2026-04-22 09:31:40'),
(19, 'GDL6780', 'Renault', 'Kwid', 'Laranja', 22, 2, '2026-04-22 09:31:40'),
(20, 'RCZ2108', 'Honda', 'Fit', 'Dourado', 23, 2, '2026-04-22 09:31:40'),
(21, 'ZOK8702', 'Toyota', 'Corolla', 'Verde', 24, 2, '2026-04-22 09:31:40'),
(22, 'GAU6649', 'Renault', 'Kwid', 'Preto', 25, 2, '2026-04-22 09:31:40'),
(23, 'UTI1726', 'Mercedes', 'C180', 'Dourado', 25, 2, '2026-04-22 09:31:40'),
(24, 'QVR8840', 'Ford', 'Ka', 'Prata', 26, 2, '2026-04-22 09:31:40'),
(25, 'LHB4268', 'Toyota', 'Corolla', 'Azul', 28, 2, '2026-04-22 09:31:40'),
(26, 'YNZ9897', 'Peugeot', '208', 'Vermelho', 28, 2, '2026-04-22 09:31:40'),
(27, 'HWB6438', 'Jeep', 'Renegade', 'Preto', 30, 2, '2026-04-22 09:31:40'),
(28, 'LKL7334', 'BMW', '320i', 'Prata', 31, 2, '2026-04-22 09:31:40'),
(29, 'MMY9507', 'Jeep', 'Renegade', 'Preto', 31, 2, '2026-04-22 09:31:40'),
(30, 'CPV9937', 'Nissan', 'Kicks', 'Azul', 32, 2, '2026-04-22 09:31:40'),
(31, 'HLS3730', 'Mitsubishi', 'Outlander', 'Azul', 34, 2, '2026-04-22 09:31:40'),
(32, 'SXP8126', 'Jeep', 'Renegade', 'Branco', 35, 2, '2026-04-22 09:31:40'),
(33, 'JUR1510', 'Volkswagen', 'Gol', 'Laranja', 37, 2, '2026-04-22 09:31:40'),
(34, 'LDG7001', 'Mercedes', 'C180', 'Verde', 38, 2, '2026-04-22 09:31:40'),
(35, 'ADL7077', 'Mercedes', 'C180', 'Bege', 39, 2, '2026-04-22 09:31:40'),
(36, 'TON7521', 'BMW', '320i', 'Vermelho', 39, 2, '2026-04-22 09:31:40'),
(37, 'CTM7340', 'Toyota', 'Yaris', 'Preto', 40, 2, '2026-04-22 09:31:40'),
(38, 'GLZ5678', 'Peugeot', '208', 'Cinza', 41, 2, '2026-04-22 09:31:40'),
(39, 'LXL2438', 'BMW', '320i', 'Azul', 43, 2, '2026-04-22 09:31:40'),
(40, 'SOH5914', 'Ford', 'Ka', 'Prata', 43, 2, '2026-04-22 09:31:40'),
(41, 'NDF3275', 'Renault', 'Kwid', 'Bege', 44, 2, '2026-04-22 09:31:40'),
(42, 'AOJ3126', 'Volkswagen', 'Polo', 'Preto', 44, 2, '2026-04-22 09:31:40'),
(43, 'SMK7708', 'Fiat', 'Argo', 'Preto', 46, 2, '2026-04-22 09:31:40'),
(44, 'BMN3102', 'Toyota', 'Yaris', 'Laranja', 48, 2, '2026-04-22 09:31:40'),
(45, 'LXB3034', 'Honda', 'Fit', 'Prata', 50, 2, '2026-04-22 09:31:40'),
(46, 'HEY4694', 'Mercedes', 'C180', 'Dourado', 50, 2, '2026-04-22 09:31:40'),
(47, 'VGQ5496', 'Volkswagen', 'Gol', 'Vermelho', 51, 2, '2026-04-22 09:31:40'),
(48, 'PCQ3526', 'Ford', 'Ka', 'Laranja', 51, 2, '2026-04-22 09:31:40'),
(49, 'PVO1464', 'Fiat', 'Uno', 'Branco', 52, 2, '2026-04-22 09:31:40'),
(50, 'UGF7825', 'Volkswagen', 'Polo', 'Branco', 53, 2, '2026-04-22 09:31:40'),
(51, 'MQH5949', 'Peugeot', '208', 'Cinza', 53, 2, '2026-04-22 09:31:40'),
(52, 'RHB1981', 'Ford', 'Ka', 'Bege', 54, 2, '2026-04-22 09:31:40'),
(53, 'KMI3353', 'BMW', '320i', 'Azul', 54, 2, '2026-04-22 09:31:40'),
(54, 'WZD7070', 'Honda', 'Fit', 'Dourado', 55, 2, '2026-04-22 09:31:40'),
(55, 'DLD1829', 'Nissan', 'Kicks', 'Verde', 57, 2, '2026-04-22 09:31:40'),
(56, 'KZX6364', 'Fiat', 'Argo', 'Azul', 58, 2, '2026-04-22 09:31:40'),
(57, 'EEZ8648', 'Peugeot', '208', 'Vermelho', 58, 2, '2026-04-22 09:31:40'),
(58, 'CKL4944', 'Hyundai', 'HB20', 'Laranja', 59, 2, '2026-04-22 09:31:40'),
(59, 'BMW8710', 'Nissan', 'Kicks', 'Dourado', 60, 2, '2026-04-22 09:31:40'),
(60, 'JKB1838', 'Fiat', 'Argo', 'Dourado', 64, 2, '2026-04-22 09:31:40'),
(61, 'BNT5582', 'Volkswagen', 'Polo', 'Laranja', 66, 2, '2026-04-22 09:31:40'),
(62, 'KUI6990', 'Volkswagen', 'Gol', 'Cinza', 68, 2, '2026-04-22 09:31:40'),
(63, 'PKB1637', 'Volkswagen', 'Gol', 'Azul', 68, 2, '2026-04-22 09:31:40'),
(64, 'NDX3290', 'BMW', '320i', 'Laranja', 69, 2, '2026-04-22 09:31:40'),
(65, 'IKQ5902', 'Fiat', 'Argo', 'Azul', 69, 2, '2026-04-22 09:31:40'),
(66, 'NMO8780', 'Honda', 'Civic', 'Azul', 70, 2, '2026-04-22 09:31:40'),
(67, 'CKH1436', 'Volkswagen', 'Polo', 'Bege', 71, 2, '2026-04-22 09:31:40'),
(68, 'RZP4728', 'Toyota', 'Corolla', 'Laranja', 72, 2, '2026-04-22 09:31:40'),
(69, 'NSU7229', 'Volkswagen', 'Gol', 'Cinza', 73, 2, '2026-04-22 09:31:40'),
(70, 'CAI3481', 'Kia', 'Sportage', 'Cinza', 75, 2, '2026-04-22 09:31:40'),
(71, 'KUX2020', 'Volkswagen', 'Gol', 'Dourado', 75, 2, '2026-04-22 09:31:40'),
(72, 'IRN6140', 'Ford', 'Ka', 'Bege', 76, 2, '2026-04-22 09:31:40'),
(73, 'IJU5331', 'Volkswagen', 'Polo', 'Bege', 77, 2, '2026-04-22 09:31:40'),
(74, 'EGO4684', 'Nissan', 'Kicks', 'Vermelho', 77, 2, '2026-04-22 09:31:40'),
(75, 'RMM5480', 'Nissan', 'Kicks', 'Preto', 78, 2, '2026-04-22 09:31:40'),
(76, 'OXK6654', 'Volkswagen', 'Gol', 'Vermelho', 79, 2, '2026-04-22 09:31:40'),
(77, 'CYR8849', 'Hyundai', 'HB20', 'Cinza', 81, 2, '2026-04-22 09:31:40'),
(78, 'VHO5450', 'Volkswagen', 'Gol', 'Preto', 81, 2, '2026-04-22 09:31:40'),
(79, 'PGR9700', 'Renault', 'Kwid', 'Cinza', 82, 2, '2026-04-22 09:31:40'),
(80, 'SCU1084', 'Toyota', 'Yaris', 'Prata', 84, 2, '2026-04-22 09:31:40'),
(81, 'YWM4267', 'Nissan', 'Kicks', 'Azul', 85, 2, '2026-04-22 09:31:40'),
(82, 'BTQ4804', 'Toyota', 'Yaris', 'Branco', 86, 2, '2026-04-22 09:31:40'),
(83, 'EWE1595', 'Audi', 'A3', 'Bege', 87, 2, '2026-04-22 09:31:40'),
(84, 'ETW5742', 'Toyota', 'Corolla', 'Branco', 87, 2, '2026-04-22 09:31:40'),
(85, 'PYI8444', 'Toyota', 'Yaris', 'Dourado', 88, 2, '2026-04-22 09:31:40'),
(86, 'YWM4159', 'Chevrolet', 'Onix', 'Azul', 89, 2, '2026-04-22 09:31:40'),
(87, 'GET5833', 'Fiat', 'Argo', 'Cinza', 91, 2, '2026-04-22 09:31:40'),
(88, 'XVN2421', 'Audi', 'A3', 'Preto', 93, 2, '2026-04-22 09:31:40'),
(89, 'EDI5064', 'Honda', 'Civic', 'Vermelho', 93, 2, '2026-04-22 09:31:40'),
(90, 'LGI1187', 'Jeep', 'Renegade', 'Azul', 94, 2, '2026-04-22 09:31:40'),
(91, 'BDH7642', 'Honda', 'Fit', 'Vermelho', 95, 2, '2026-04-22 09:31:40'),
(92, 'QYJ4618', 'Renault', 'Kwid', 'Prata', 96, 2, '2026-04-22 09:31:40'),
(93, 'LZJ9998', 'Peugeot', '208', 'Dourado', 97, 2, '2026-04-22 09:31:40'),
(94, 'VTR2341', 'Honda', 'Fit', 'Bege', 98, 2, '2026-04-22 09:31:40'),
(95, 'NJX2838', 'Toyota', 'Corolla', 'Dourado', 98, 2, '2026-04-22 09:31:40'),
(96, 'FNE9525', 'Mitsubishi', 'Outlander', 'Preto', 99, 2, '2026-04-22 09:31:40'),
(97, 'RSM9361', 'Mitsubishi', 'Outlander', 'Branco', 99, 2, '2026-04-22 09:31:40'),
(98, 'NLB8575', 'Nissan', 'Kicks', 'Branco', 100, 2, '2026-04-22 09:31:40'),
(99, 'VTP1742', 'Kia', 'Sportage', 'Azul', 101, 2, '2026-04-22 09:31:40'),
(100, 'OBX8734', 'Toyota', 'Corolla', 'Vermelho', 102, 2, '2026-04-22 09:31:40'),
(101, 'TTZ7887', 'Mercedes', 'C180', 'Verde', 103, 2, '2026-04-22 09:31:40'),
(102, 'XJC9835', 'Volkswagen', 'Gol', 'Azul', 104, 2, '2026-04-22 09:31:40');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `faturas`
--
ALTER TABLE `faturas`
  ADD PRIMARY KEY (`id_fatura`);

--
-- Índices para tabela `lancamentos`
--
ALTER TABLE `lancamentos`
  ADD PRIMARY KEY (`id_lancamento`);

--
-- Índices para tabela `locais_festivos`
--
ALTER TABLE `locais_festivos`
  ADD PRIMARY KEY (`id_local`),
  ADD KEY `fk_local_usuario` (`id_user_cad`);

--
-- Índices para tabela `morador`
--
ALTER TABLE `morador`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `uk_cpf` (`cpf`),
  ADD UNIQUE KEY `uk_email` (`email`);

--
-- Índices para tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `idx_reserva_usuario` (`id_user`),
  ADD KEY `idx_reserva_local` (`id_local`),
  ADD KEY `idx_reserva_data` (`data_reserva`);

--
-- Índices para tabela `taxas_padrao`
--
ALTER TABLE `taxas_padrao`
  ADD PRIMARY KEY (`id_taxa`);

--
-- Índices para tabela `veiculos`
--
ALTER TABLE `veiculos`
  ADD PRIMARY KEY (`id_veiculo`),
  ADD UNIQUE KEY `uk_placa` (`placa`),
  ADD KEY `fk_veiculo_morador` (`id_user`),
  ADD KEY `fk_veiculo_cadastrou` (`id_user_cad`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `faturas`
--
ALTER TABLE `faturas`
  MODIFY `id_fatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `lancamentos`
--
ALTER TABLE `lancamentos`
  MODIFY `id_lancamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de tabela `locais_festivos`
--
ALTER TABLE `locais_festivos`
  MODIFY `id_local` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `morador`
--
ALTER TABLE `morador`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=854;

--
-- AUTO_INCREMENT de tabela `taxas_padrao`
--
ALTER TABLE `taxas_padrao`
  MODIFY `id_taxa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `veiculos`
--
ALTER TABLE `veiculos`
  MODIFY `id_veiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `locais_festivos`
--
ALTER TABLE `locais_festivos`
  ADD CONSTRAINT `fk_local_usuario` FOREIGN KEY (`id_user_cad`) REFERENCES `morador` (`id_user`);

--
-- Limitadores para a tabela `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reserva_local` FOREIGN KEY (`id_local`) REFERENCES `locais_festivos` (`id_local`),
  ADD CONSTRAINT `fk_reserva_usuario` FOREIGN KEY (`id_user`) REFERENCES `morador` (`id_user`);

--
-- Limitadores para a tabela `veiculos`
--
ALTER TABLE `veiculos`
  ADD CONSTRAINT `fk_veiculo_cadastrou` FOREIGN KEY (`id_user_cad`) REFERENCES `morador` (`id_user`),
  ADD CONSTRAINT `fk_veiculo_morador` FOREIGN KEY (`id_user`) REFERENCES `morador` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
