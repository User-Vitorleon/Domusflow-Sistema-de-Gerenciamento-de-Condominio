-- ============================================================
-- DomusFlow — Estrutura do banco de dados
-- Versão: produção
-- Para popular o banco, execute: seed.php
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `domusflow_bd`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `domusflow_bd`;

-- ── TABELA: morador ─────────────────────────────────────────
CREATE TABLE `morador` (
  `id_user`      int(11)      NOT NULL AUTO_INCREMENT,
  `identificador` int(11)     NOT NULL DEFAULT 1,
  `nome`         varchar(100) NOT NULL,
  `apto`         varchar(20)  NOT NULL,
  `bloco`        varchar(5)   NOT NULL,
  `cpf`          varchar(14)  NOT NULL,
  `email`        varchar(100) NOT NULL,
  `telefone`     varchar(15)  NOT NULL,
  `tell_recado`  varchar(15)  DEFAULT NULL,
  `sexo`         char(1)      NOT NULL DEFAULT 'M',
  `senha`        varchar(255) NOT NULL,
  `status`       char(1)      NOT NULL DEFAULT 'P',
  `privilegio`   tinyint(1)   NOT NULL DEFAULT 1,
  `created_at`   datetime     NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `uk_cpf`   (`cpf`),
  UNIQUE KEY `uk_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── TABELA: locais_festivos ──────────────────────────────────
CREATE TABLE `locais_festivos` (
  `id_local`    int(11)     NOT NULL AUTO_INCREMENT,
  `local`       varchar(60) NOT NULL,
  `capacidade`  int(11)     NOT NULL DEFAULT 0,
  `disp_uso`    char(1)     NOT NULL DEFAULT 'S',
  `id_user_cad` int(11)     NOT NULL,
  `created_at`  datetime    NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_local`),
  KEY `fk_local_usuario` (`id_user_cad`),
  CONSTRAINT `fk_local_usuario`
    FOREIGN KEY (`id_user_cad`) REFERENCES `morador` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── TABELA: reservas ────────────────────────────────────────
CREATE TABLE `reservas` (
  `id_reserva`      int(11)     NOT NULL AUTO_INCREMENT,
  `id_local`        int(11)     NOT NULL,
  `id_user`         int(11)     NOT NULL,
  `data_reserva`    date        NOT NULL,
  `hora_ini`        time        NOT NULL,
  `hora_fim`        time        NOT NULL,
  `status`          char(1)     NOT NULL DEFAULT 'P',
  `id_user_aprov`   int(11)     DEFAULT NULL,
  `nome_user_aprov` varchar(100)DEFAULT NULL,
  `data_aprov`      date        DEFAULT NULL,
  `hora_aprov`      time        DEFAULT NULL,
  `created_at`      datetime    NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_reserva`),
  KEY `idx_reserva_usuario` (`id_user`),
  KEY `idx_reserva_local`   (`id_local`),
  KEY `idx_reserva_data`    (`data_reserva`),
  CONSTRAINT `fk_reserva_local`
    FOREIGN KEY (`id_local`) REFERENCES `locais_festivos` (`id_local`),
  CONSTRAINT `fk_reserva_usuario`
    FOREIGN KEY (`id_user`)  REFERENCES `morador` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── TABELA: veiculos ────────────────────────────────────────
CREATE TABLE `veiculos` (
  `id_veiculo`  int(11)     NOT NULL AUTO_INCREMENT,
  `placa`       varchar(10) NOT NULL,
  `marca`       varchar(60) NOT NULL,
  `modelo`      varchar(60) NOT NULL,
  `cor`         varchar(30) NOT NULL,
  `principal`   tinyint(1)  NOT NULL DEFAULT 1,
  `id_user`     int(11)     NOT NULL,
  `id_user_cad` int(11)     NOT NULL,
  `created_at`  datetime    NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_veiculo`),
  UNIQUE KEY `uk_placa` (`placa`),
  KEY `fk_veiculo_morador`    (`id_user`),
  KEY `fk_veiculo_cadastrou`  (`id_user_cad`),
  CONSTRAINT `fk_veiculo_morador`
    FOREIGN KEY (`id_user`)     REFERENCES `morador` (`id_user`),
  CONSTRAINT `fk_veiculo_cadastrou`
    FOREIGN KEY (`id_user_cad`) REFERENCES `morador` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── TABELA: faturas ─────────────────────────────────────────
CREATE TABLE `faturas` (
  `id_fatura`   int(11)      NOT NULL AUTO_INCREMENT,
  `id_user`     int(11)      DEFAULT NULL,
  `data`        date         DEFAULT NULL,
  `valor_total` double       DEFAULT NULL,
  `descricao`   varchar(100) DEFAULT NULL,
  `id_user_cad` int(11)      DEFAULT NULL,
  `created_at`  date         DEFAULT NULL,
  PRIMARY KEY (`id_fatura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ── TABELA: lancamentos ─────────────────────────────────────
CREATE TABLE `lancamentos` (
  `id_lancamento`  int(11)      NOT NULL AUTO_INCREMENT,
  `modelo`         varchar(50)  NOT NULL,
  `valor`          double       NOT NULL,
  `descricao`      varchar(100) NOT NULL,
  `id_user`        int(11)      NOT NULL,
  `data_vencimento` date        NOT NULL,
  `status`         varchar(1)   NOT NULL,
  `data_lancamento` date        NOT NULL,
  `id_user_cad`    int(11)      NOT NULL,
  `id_fatura`      int(11)      DEFAULT NULL,
  PRIMARY KEY (`id_lancamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ── TABELA: taxas_padrao ────────────────────────────────────
CREATE TABLE `taxas_padrao` (
  `id_taxa`     int(11)      NOT NULL AUTO_INCREMENT,
  `descricao`   varchar(100) NOT NULL,
  `valor`       double       NOT NULL,
  `status`      char(1)      NOT NULL DEFAULT 'A',
  `usuario_cad` varchar(100) NOT NULL,
  `data_cad`    date         NOT NULL,
  `modulo`      varchar(20)  NOT NULL,
  PRIMARY KEY (`id_taxa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ocorrencias (
    id_ocorrencia INT AUTO_INCREMENT PRIMARY KEY,
    id_user       INT NOT NULL,
    categoria     VARCHAR(100) NOT NULL,
    titulo        VARCHAR(200) NOT NULL,
    descricao     TEXT NOT NULL,
    status        ENUM('A','E','R','C') NOT NULL DEFAULT 'A',
    created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES morador(id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS ocorrencia_tramites (
    id_tramite      INT AUTO_INCREMENT PRIMARY KEY,
    id_ocorrencia   INT NOT NULL,
    id_user_cad     INT NOT NULL,
    nome_user_cad   VARCHAR(150) NOT NULL,
    descricao       TEXT NOT NULL,
    status_novo     ENUM('A','E','R','C') NOT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ocorrencia) REFERENCES ocorrencias(id_ocorrencia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS ocorrencia_notificacoes (
    id_notificacao INT AUTO_INCREMENT PRIMARY KEY,
    id_user        INT NOT NULL,
    id_ocorrencia  INT NOT NULL,
    lida           TINYINT(1) NOT NULL DEFAULT 0,
    created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES morador(id_user),
    FOREIGN KEY (id_ocorrencia) REFERENCES ocorrencias(id_ocorrencia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*TABELA: AVISOS*/

CREATE TABLE `avisos` (
  `id_aviso`    INT(11)      NOT NULL AUTO_INCREMENT,
  `titulo`      VARCHAR(100) NOT NULL,
  `mensagem`    TEXT         NOT NULL,
  `id_user_cad` INT(11)      NOT NULL,
  `status`      VARCHAR(1)   NOT NULL DEFAULT 'A',
  `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_aviso`),
  CONSTRAINT `fk_aviso_user` FOREIGN KEY (`id_user_cad`) REFERENCES `morador` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*TABELA: ASSEMBLEIAS*/

CREATE TABLE `assembleias` (
  `id_assembleia` INT(11)      NOT NULL AUTO_INCREMENT,
  `titulo`        VARCHAR(100) NOT NULL,
  `data`          DATE         NOT NULL,
  `hora`          TIME         NOT NULL,
  `local`         VARCHAR(100) NOT NULL,
  `pauta`         TEXT         NOT NULL,
  `id_user_cad`   INT(11)      NOT NULL,
  `status`        VARCHAR(1)   NOT NULL DEFAULT 'A',
  `created_at`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_assembleia`),
  CONSTRAINT `fk_assembleia_user` FOREIGN KEY (`id_user_cad`) REFERENCES `morador` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `assembleias_presencas` (
  `id_presenca`   INT(11)    NOT NULL AUTO_INCREMENT,
  `id_assembleia` INT(11)    NOT NULL,
  `id_user`       INT(11)    NOT NULL,
  `presenca`      VARCHAR(1) NOT NULL DEFAULT 'P',
  `created_at`    DATETIME   NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_presenca`),
  UNIQUE KEY `uk_presenca` (`id_assembleia`, `id_user`),
  CONSTRAINT `fk_presenca_assembleia` FOREIGN KEY (`id_assembleia`) REFERENCES `assembleias` (`id_assembleia`),
  CONSTRAINT `fk_presenca_user`       FOREIGN KEY (`id_user`)       REFERENCES `morador` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;