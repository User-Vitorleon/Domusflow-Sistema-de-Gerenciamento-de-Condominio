USE `domusflow_bd`;

-- ── 2. MORADORES BASE ──────────────────────────────────────
INSERT INTO `morador`
(`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`tell_recado`,`sexo`,`senha`,`status`,`previlegio`)
VALUES
(1,1,'Admin Root','00','Z','00000000000','admin@domusflow.com','(11) 3000-0000',NULL,'M','$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2','L',4),
(2,1,'Vitor Leon','1','A','43209957835','sindico@domusflow.com','(11) 98522-9900',NULL,'M','$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2','L',2),
(3,1,'Porteiro Padrão','00','Z','11111111111','porteiro@domusflow.com','(11) 3000-0001',NULL,'M','$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2','L',3),
(4,1,'Dona Zefinha','20','A','11760401897','zefinha@domusflow.com','(11) 98475-5600','(11) 3344-7788','F','$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2','L',1);

-- ── 3. MORADORES (1000 SEM REPETIÇÃO DE NOME) ──────────────

DELIMITER $$

CREATE PROCEDURE gerar_moradores()
BEGIN
  DECLARE i INT DEFAULT 5;
  DECLARE apto INT;
  DECLARE bloco CHAR(1);

  WHILE i <= 1004 DO

    SET apto = (i - 4);
    SET bloco = CHAR(65 + FLOOR((i-5)/200));

    INSERT INTO morador
    (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`tell_recado`,`sexo`,`senha`,`status`,`previlegio`)
    VALUES
    (
      i,
      1,
      CONCAT(
        ELT((i % 20)+1,
          'Carlos','Ana','João','Mariana','Lucas','Fernanda','Bruno','Juliana','Rafael','Patricia',
          'Thiago','Camila','Diego','Larissa','André','Vanessa','Felipe','Tatiane','Ricardo','Aline'
        ),
        ' ',
        ELT((FLOOR(i/3) % 20)+1,
          'Silva','Oliveira','Souza','Costa','Pereira','Rodrigues','Alves','Ferreira','Gomes','Martins',
          'Barbosa','Ribeiro','Carvalho','Dias','Rocha','Teixeira','Moreira','Batista','Freitas','Mendes'
        ),
        ' ',
        ELT((FLOOR(i/7) % 20)+1,
          'Lima','Cardoso','Nogueira','Monteiro','Correia','Farias','Duarte','Peixoto','Queiroz','Moura',
          'Neves','Sales','Campos','Rezende','Borges','Amaral','Cunha','Vieira','Pinto','Araújo'
        )
      ),
      apto,
      bloco,
      LPAD(FLOOR(10000000000 + RAND()*89999999999),11,'0'),
      CONCAT('morador', i, '@domusflow.com'),
      CONCAT('(11) 9', LPAD(FLOOR(RAND()*99999999),8,'0')),
      IF(i % 4 = 0,
         CONCAT('(11) 3', LPAD(FLOOR(RAND()*9999999),7,'0')),
         NULL
      ),
      IF(i % 2 = 0,'M','F'),
      '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2',
      CASE
        WHEN i % 10 = 0 THEN 'B'
        WHEN i % 3 = 0 THEN 'P'
        ELSE 'L'
      END,
      1
    );

    SET i = i + 1;

  END WHILE;

END$$

DELIMITER ;

CALL gerar_moradores();

-- ── 4. LOCAIS FESTIVOS ─────────────────────────────────────
INSERT INTO `locais_festivos`
(`id_local`,`local`,`capacidade`,`disp_uso`,`id_user_cad`)
VALUES
(1,'Churrasqueira',100,'S',2),
(2,'Parquinho de Diversão',10,'N',2),
(3,'Salão de Festa Pequeno',50,'S',2);

-- ── 5. VEÍCULOS ────────────────────────────────────────────

DELIMITER $$

CREATE PROCEDURE gerar_veiculos()
BEGIN
  DECLARE i INT DEFAULT 5;

  WHILE i <= 1004 DO

    IF i % 3 <> 0 THEN

      INSERT INTO veiculos
      (`placa`,`marca`,`modelo`,`cor`,`principal`,`id_user`,`id_user_cad`)
      VALUES
      (
        CONCAT(
          CHAR(65 + (i % 26)),
          CHAR(65 + ((i+3) % 26)),
          CHAR(65 + ((i+7) % 26)),
          FLOOR(1000 + (i % 9000))
        ),
        ELT((i % 6)+1,'Fiat','Volkswagen','Chevrolet','Toyota','Honda','Hyundai'),
        ELT((i % 6)+1,'Uno','Gol','Onix','Corolla','Civic','HB20'),
        ELT((i % 5)+1,'Preto','Branco','Prata','Cinza','Azul'),
        1,
        i,
        IF(i % 5 = 0,2,i)
      );

      IF i % 10 = 0 THEN
        INSERT INTO veiculos
        (`placa`,`marca`,`modelo`,`cor`,`principal`,`id_user`,`id_user_cad`)
        VALUES
        (
          CONCAT(
            CHAR(66 + (i % 26)),
            CHAR(66 + ((i+2) % 26)),
            CHAR(66 + ((i+5) % 26)),
            FLOOR(2000 + (i % 8000))
          ),
          'Ford',
          'Ka',
          'Branco',
          0,
          i,
          i
        );
      END IF;

    END IF;

    SET i = i + 1;

  END WHILE;

END$$

DELIMITER ;

CALL gerar_veiculos();

-- ── 6. RESERVAS ────────────────────────────────────────────

DELIMITER $$

CREATE PROCEDURE gerar_reservas()
BEGIN
  DECLARE i INT DEFAULT 1;

  WHILE i <= 400 DO

    INSERT INTO reservas
    (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,
     `id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`)
    VALUES
    (
      (i % 3) + 1,
      5 + (i % 1000),
      DATE_ADD('2026-05-01', INTERVAL (i % 30) DAY),
      ELT((i % 3)+1,'18:00:00','12:00:00','19:00:00'),
      ELT((i % 3)+1,'23:00:00','18:00:00','23:59:00'),
      ELT((i % 3)+1,'A','P','N'),
      IF(i % 2 = 0,2,NULL),
      IF(i % 2 = 0,'Vitor Leon',NULL),
      IF(i % 2 = 0,DATE_ADD('2026-05-01', INTERVAL (i % 10) DAY),NULL),
      IF(i % 2 = 0,'10:00:00',NULL)
    );

    SET i = i + 1;

  END WHILE;

END$$

DELIMITER ;

CALL gerar_reservas();