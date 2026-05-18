-- ═══════════════════════════════════════════════════════════
--  DomusFlow — Script de Banco de Dados
--  Versão: 2.0 (refatorado)
--  Compatível com: MariaDB 10.4+ / MySQL 8+
-- ═══════════════════════════════════════════════════════════

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- ── Cria e seleciona o banco ────────────────────────────────
CREATE DATABASE IF NOT EXISTS `domusflow_bd`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `domusflow_bd`;

-- ── Tabela: morador ─────────────────────────────────────────
-- status:     P=Pendente, L=Liberado, B=Bloqueado
-- privilegio: 1=Morador,  2=Síndico
-- sexo:       M=Masculino, F=Feminino
CREATE TABLE IF NOT EXISTS `morador` (
  `id_user`       INT(11)      NOT NULL AUTO_INCREMENT,
  `identificador` INT(11)      NOT NULL DEFAULT 1,
  `nome`          VARCHAR(100) NOT NULL,
  `apto`          VARCHAR(20)  NOT NULL,
  `bloco`         VARCHAR(5)   NOT NULL,
  `cpf`           VARCHAR(14)  NOT NULL,
  `email`         VARCHAR(100) NOT NULL,
  `telefone`      VARCHAR(15)  NOT NULL,
  `tell_recado`   VARCHAR(15)  DEFAULT NULL,
  `sexo`          CHAR(1)      NOT NULL DEFAULT 'M',
  `senha`         VARCHAR(255) NOT NULL,
  `status`        CHAR(1)      NOT NULL DEFAULT 'P',
  `privilegio`    TINYINT(1)   NOT NULL DEFAULT 1,
  `created_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `uk_cpf` (`cpf`),
  UNIQUE KEY `uk_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Tabela: locais_festivos ─────────────────────────────────
-- disp_uso: S=Disponível, N=Indisponível/Manutenção
CREATE TABLE IF NOT EXISTS `locais_festivos` (
  `id_local`    INT(11)     NOT NULL AUTO_INCREMENT,
  `local`       VARCHAR(60) NOT NULL,
  `capacidade`  INT(11)     NOT NULL DEFAULT 0,
  `disp_uso`    CHAR(1)     NOT NULL DEFAULT 'S',
  `id_user_cad` INT(11)     NOT NULL,
  `created_at`  DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_local`),
  CONSTRAINT `fk_local_usuario` FOREIGN KEY (`id_user_cad`)
    REFERENCES `morador` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Tabela: reservas ────────────────────────────────────────
-- status: P=Pendente, A=Aprovada, N=Negada
CREATE TABLE IF NOT EXISTS `reservas` (
  `id_reserva`      INT(11)      NOT NULL AUTO_INCREMENT,
  `id_local`        INT(11)      NOT NULL,
  `id_user`         INT(11)      NOT NULL,
  `data_reserva`    DATE         NOT NULL,
  `hora_ini`        TIME         NOT NULL,
  `hora_fim`        TIME         NOT NULL,
  `status`          CHAR(1)      NOT NULL DEFAULT 'P',
  `id_user_aprov`   INT(11)      DEFAULT NULL,
  `nome_user_aprov` VARCHAR(100) DEFAULT NULL,
  `data_aprov`      DATE         DEFAULT NULL,
  `hora_aprov`      TIME         DEFAULT NULL,
  `created_at`      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reserva`),
  KEY `idx_reserva_usuario` (`id_user`),
  KEY `idx_reserva_local`   (`id_local`),
  KEY `idx_reserva_data`    (`data_reserva`),
  CONSTRAINT `fk_reserva_usuario` FOREIGN KEY (`id_user`)
    REFERENCES `morador` (`id_user`),
  CONSTRAINT `fk_reserva_local` FOREIGN KEY (`id_local`)
    REFERENCES `locais_festivos` (`id_local`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Tabela Veiculos ──────────────────────────────────────
CREATE TABLE IF NOT EXISTS `veiculos` (
  `id_veiculo`   INT(11)      NOT NULL AUTO_INCREMENT,
  `placa`        VARCHAR(7)   NOT NULL,
  `marca`        VARCHAR(60)  NOT NULL,
  `modelo`       VARCHAR(60)  NOT NULL,
  `cor`          VARCHAR(30)  NOT NULL,
  `principal`    TINYINT(1)   NOT NULL DEFAULT 0,
  `id_user`      INT(11)      NOT NULL,
  `id_user_cad`  INT(11)      NOT NULL,
  `created_at`   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_veiculo`),
  UNIQUE KEY `uk_placa` (`placa`),
  CONSTRAINT `fk_veiculo_morador`   FOREIGN KEY (`id_user`)     REFERENCES `morador` (`id_user`),
  CONSTRAINT `fk_veiculo_cadastrou` FOREIGN KEY (`id_user_cad`) REFERENCES `morador` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `faturas` (
  `id_fatura` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `valor_total` double DEFAULT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `id_user_cad` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `taxas_padrao` (
  `id_taxa` int(11) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;