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
-- previlegio: 1=Morador,  2=Síndico
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
  `previlegio`    TINYINT(1)   NOT NULL DEFAULT 1,
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

-- ═══════════════════════════════════════════════════════════
--  Dados iniciais (seed)
-- ═══════════════════════════════════════════════════════════

-- ── Admin Root ──────────────────────────────────────────────
-- CPF: 000.000.000-00 | Senha: 123456 | Privilégio: 4
INSERT INTO `morador`
  (`id_user`, `identificador`, `nome`, `apto`, `bloco`, `cpf`, `email`,
   `telefone`, `tell_recado`, `sexo`, `senha`, `status`, `previlegio`)
VALUES
  (1, 1, 'Admin Root', '00', '0', '00000000000', 'admin@domusflow.com',
   '(11) 00000-0000', NULL, 'M',
   '$2y$10$ippmJA./AtFuQ/TGG.8Qxu8xHCFgqmCo0QLYUpeX/lWRwIggfFQgm',
   'L', 4);

-- ── Síndico ─────────────────────────────────────────────────
-- CPF: 432.099.578-35 | Senha: 123456 | Privilégio: 2
INSERT INTO `morador`
  (`id_user`, `identificador`, `nome`, `apto`, `bloco`, `cpf`, `email`,
   `telefone`, `tell_recado`, `sexo`, `senha`, `status`, `previlegio`)
VALUES
  (2, 1, 'Vitor Leon', '20', '2', '43209957835', 'sindico@domusflow.com',
   '(11) 98522-9900', '(11) 98544-5780', 'M',
   '$2y$10$ippmJA./AtFuQ/TGG.8Qxu8xHCFgqmCo0QLYUpeX/lWRwIggfFQgm',
   'L', 2);

-- ── Porteiro ────────────────────────────────────────────────
-- CPF: 111.111.111-11 | Senha: 123456 | Privilégio: 3
INSERT INTO `morador`
  (`id_user`, `identificador`, `nome`, `apto`, `bloco`, `cpf`, `email`,
   `telefone`, `tell_recado`, `sexo`, `senha`, `status`, `previlegio`)
VALUES
  (3, 1, 'Porteiro Padrão', '00', '0', '11111111111', 'porteiro@domusflow.com',
   '(11) 00000-0001', NULL, 'M',
   '$2y$10$ippmJA./AtFuQ/TGG.8Qxu8xHCFgqmCo0QLYUpeX/lWRwIggfFQgm',
   'L', 3);

-- ── Morador de teste ────────────────────────────────────────
-- CPF: 117.604.018-97 | Senha: 123456 | Privilégio: 1
INSERT INTO `morador`
  (`id_user`, `identificador`, `nome`, `apto`, `bloco`, `cpf`, `email`,
   `telefone`, `tell_recado`, `sexo`, `senha`, `status`, `previlegio`)
VALUES
  (4, 1, 'Dona Zefinha', '20', '1A', '11760401897', 'zefinha@domusflow.com',
   '(11) 98475-5600', '(11) 54878-7870', 'F',
   '$2y$10$/h375Lp3ZVoPCJ678rGKAef//ZsoZzaQHZEIp0zZQI0b270Dg2tkW',
   'L', 1);

-- ── Locais festivos ─────────────────────────────────────────
INSERT INTO `locais_festivos` (`id_local`, `local`, `capacidade`, `disp_uso`, `id_user_cad`) VALUES
  (1, 'Churrasqueira',          100, 'S', 1),
  (2, 'Parquinho de Diversão',   10, 'N', 1),
  (3, 'Salão de Festa Pequeno',  50, 'S', 1);

-- ── Reserva de exemplo ──────────────────────────────────────
INSERT INTO `reservas`
  (`id_reserva`, `id_local`, `id_user`, `data_reserva`, `hora_ini`, `hora_fim`, `status`)
VALUES
  (1, 1, 2, '2026-04-10', '10:00:00', '13:00:00', 'P');

COMMIT;
