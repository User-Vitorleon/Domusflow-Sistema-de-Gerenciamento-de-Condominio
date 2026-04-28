-- ═══════════════════════════════════════════════════════════
--  DomusFlow — Seed inicial
--  Usuários fixos do sistema
-- ═══════════════════════════════════════════════════════════

USE `domusflow_bd`;

-- ── Admin Root — CPF: 000.000.000-00 | Senha: 123456 | Privilégio: 4
INSERT INTO `morador` (`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`tell_recado`,`senha`,`status`,`previlegio`) VALUES
  (1, 'Admin Root', '00', '0', '00000000000', 'admin@domusflow.com', '(11) 00000-0000', NULL, '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 4);

-- ── Síndico — CPF: 432.099.578-35 | Senha: 123456 | Privilégio: 2
INSERT INTO `morador` (`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`tell_recado`,`senha`,`status`,`previlegio`) VALUES
  (1, 'Vitor Leon', '20', '2', '43209957835', 'sindico@domusflow.com', '(11) 98522-9900', '(11) 98544-5780', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 2);

-- ── Porteiro — CPF: 111.111.111-11 | Senha: 123456 | Privilégio: 3
INSERT INTO `morador` (`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`tell_recado`,`senha`,`status`,`previlegio`) VALUES
  (1, 'Porteiro Padrão', '00', '0', '11111111111', 'porteiro@domusflow.com', '(11) 00000-0001', NULL, '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 3);

-- ── Morador teste — CPF: 117.604.018-97 | Senha: 123456 | Privilégio: 1
INSERT INTO `morador` (`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`tell_recado`,`senha`,`status`,`previlegio`) VALUES
  (1, 'Dona Zefinha', '20', '1A', '11760401897', 'zefinha@domusflow.com', '(11) 98475-5600', '(11) 54878-7870', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);

-- ── Locais festivos
INSERT INTO `locais_festivos` (`local`,`capacidade`,`disp_uso`,`id_user_cad`) VALUES
  ('Churrasqueira', 100, 'S', 1),
  ('Parquinho de Diversão', 10, 'N', 1),
  ('Salão de Festa Pequeno', 50, 'S', 1);

-- ── Reserva de exemplo
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 2, '2026-04-10', '10:00:00', '13:00:00', 'P');

-- ── Veículos dos usuários fixos
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('ABC1234', 'Honda',     'Civic',  'Prata',    2, 2),
  ('DEF5678', 'Toyota',    'Corolla','Preto',    2, 2),
  ('GHI9012', 'Fiat',      'Uno',    'Branco',   4, 2),
  ('JKL3456', 'Chevrolet', 'Onix',   'Vermelho', 4, 2);
-- ═══════════════════════════════════════════════════════════
--  DomusFlow — Seed de Dados (massa de testes)
--  Senha padrão de todos os usuários: 123456
-- ═══════════════════════════════════════════════════════════

USE `domusflow_bd`;

-- ── Moradores ──────────────────────────────────────────────
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (5, 1, 'Carlos Silva', '2', 'A', '10433218196', 'carlossilva5@email.com', '(11) 94582-4811', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (6, 1, 'João Oliveira', '1', 'D', '89083863794', 'joaooliveira6@email.com', '(11) 96574-5552', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (7, 1, 'Pedro Santos', '2B', 'D', '23511615594', 'pedrosantos7@email.com', '(11) 99785-3045', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (8, 1, 'Lucas Ferreira', '10', 'B', '61849593103', 'lucasferreira8@email.com', '(11) 92654-7227', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (9, 1, 'Marcos Costa', '18B', 'B', '47525534192', 'marcoscosta9@email.com', '(11) 93677-8573', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (10, 1, 'Rafael Souza', '3', 'E', '64835030564', 'rafaelsouza10@email.com', '(11) 96155-4483', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (11, 1, 'Bruno Lima', '14B', 'D', '76724238849', 'brunolima11@email.com', '(11) 96930-4593', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (12, 1, 'Felipe Pereira', '13A', 'E', '28710122691', 'felipepereira12@email.com', '(11) 98668-9669', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (13, 1, 'Thiago Alves', '15', 'C', '48018451462', 'thiagoalves13@email.com', '(11) 99201-3927', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (14, 1, 'Diego Rocha', '1B', 'C', '81489325288', 'diegorocha14@email.com', '(11) 99005-1319', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (15, 1, 'André Mendes', '18', 'B', '15430391171', 'andremendes15@email.com', '(11) 98787-3705', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (16, 1, 'Gustavo Martins', '17A', 'A', '48963834657', 'gustavomartins16@email.com', '(11) 95061-4681', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (17, 1, 'Ricardo Carvalho', '8', 'A', '15098393010', 'ricardocarvalho17@email.com', '(11) 96413-2160', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (18, 1, 'Leandro Dias', '16A', 'B', '83473829973', 'leandrodias18@email.com', '(11) 92545-2588', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (19, 1, 'Fernando Ribeiro', '8', 'B', '65667010651', 'fernandoribeiro19@email.com', '(11) 99786-8350', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (20, 1, 'Rodrigo Gomes', '18', 'A', '26247317810', 'rodrigogomes20@email.com', '(11) 94872-3724', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (21, 1, 'Fabian Torres', '15A', 'D', '67736026064', 'fabiantorres21@email.com', '(11) 98973-3536', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (22, 1, 'Henrique Nunes', '16B', 'E', '34309805009', 'henriquenunes22@email.com', '(11) 93579-1931', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (23, 1, 'Vinicius Castro', '19B', 'A', '81219136193', 'viniciuscastro23@email.com', '(11) 92343-7868', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (24, 1, 'Eduardo Moreira', '10A', 'C', '99854353462', 'eduardomoreira24@email.com', '(11) 92188-1152', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (25, 1, 'Alexandre Barbosa', '3', 'C', '79911838425', 'alexandrebarbosa25@email.com', '(11) 95669-3584', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (26, 1, 'Mateus Campos', '4', 'E', '78498084124', 'mateuscampos26@email.com', '(11) 93546-5462', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (27, 1, 'Leonardo Cardoso', '14A', 'A', '49353487401', 'leonardocardoso27@email.com', '(11) 91058-6464', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (28, 1, 'Caio Correia', '18', 'C', '24278680112', 'caiocorreia28@email.com', '(11) 93426-8041', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (29, 1, 'Renato Freitas', '14B', 'B', '20450533158', 'renatofreitas29@email.com', '(11) 94878-3662', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (30, 1, 'Daniel Teixeira', '2A', 'B', '26025634216', 'danielteixeira30@email.com', '(11) 94269-8541', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (31, 1, 'Julio Nascimento', '12B', 'E', '54330365414', 'julionascimento31@email.com', '(11) 97548-9785', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (32, 1, 'Sergio Moura', '12B', 'C', '50142940196', 'sergiomoura32@email.com', '(11) 98149-9379', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (33, 1, 'Paulo Andrade', '12A', 'A', '16934060883', 'pauloandrade33@email.com', '(11) 96409-6143', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (34, 1, 'Nelson Viana', '14B', 'D', '14846564823', 'nelsonviana34@email.com', '(11) 93851-5930', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (35, 1, 'Ana Lima', '15A', 'B', '68044369957', 'analima35@email.com', '(11) 99375-8752', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (36, 1, 'Maria Santos', '5', 'A', '21489513433', 'mariasantos36@email.com', '(11) 95011-8784', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (37, 1, 'Carla Oliveira', '1', 'D', '91769367632', 'carlaoliveira37@email.com', '(11) 94585-3881', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (38, 1, 'Juliana Costa', '20A', 'D', '87083172788', 'julianacosta38@email.com', '(11) 99270-7991', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (39, 1, 'Fernanda Silva', '9A', 'A', '87277434873', 'fernandasilva39@email.com', '(11) 95681-4841', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (40, 1, 'Patricia Rocha', '3A', 'D', '45581223623', 'patriciarocha40@email.com', '(11) 96421-9890', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (41, 1, 'Amanda Ferreira', '1A', 'C', '76036690967', 'amandaferreira41@email.com', '(11) 97389-7865', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (42, 1, 'Camila Souza', '11B', 'D', '88937346706', 'camilasouza42@email.com', '(11) 93704-8657', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (43, 1, 'Isabela Pereira', '15', 'A', '29806990162', 'isabelapereira43@email.com', '(11) 95262-7211', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (44, 1, 'Leticia Alves', '1B', 'E', '53755646417', 'leticiaalves44@email.com', '(11) 91853-6733', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (45, 1, 'Gabriela Martins', '16B', 'A', '31003309232', 'gabrielamartins45@email.com', '(11) 94571-8619', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (46, 1, 'Beatriz Gomes', '10B', 'D', '45299124190', 'beatrizgomes46@email.com', '(11) 97498-4249', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (47, 1, 'Larissa Cardoso', '14B', 'C', '19314919058', 'larissacardoso47@email.com', '(11) 92129-9289', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (48, 1, 'Natalia Dias', '17B', 'C', '50671657262', 'nataliadias48@email.com', '(11) 99817-8921', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (49, 1, 'Priscila Ribeiro', '19B', 'D', '76945314737', 'priscilaribeiro49@email.com', '(11) 96511-1470', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (50, 1, 'Tatiana Nunes', '18', 'E', '75273545494', 'tatiananunes50@email.com', '(11) 94130-2402', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (51, 1, 'Vanessa Castro', '8A', 'B', '36783777014', 'vanessacastro51@email.com', '(11) 96016-7046', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (52, 1, 'Renata Moreira', '9', 'A', '78856855744', 'renatamoreira52@email.com', '(11) 94155-6169', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (53, 1, 'Luciana Torres', '4', 'C', '18233749894', 'lucianatorres53@email.com', '(11) 94727-6912', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (54, 1, 'Aline Correia', '16', 'A', '24082400842', 'alinecorreia54@email.com', '(11) 95658-8690', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (55, 1, 'Bruna Freitas', '3B', 'A', '77520471167', 'brunafreitas55@email.com', '(11) 93485-3444', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (56, 1, 'Debora Teixeira', '17A', 'D', '94131869993', 'deborateixeira56@email.com', '(11) 98253-5871', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (57, 1, 'Fabiana Nascimento', '3', 'B', '96499091334', 'fabiananascimento57@email.com', '(11) 93847-2229', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (58, 1, 'Livia Moura', '15', 'B', '20679740344', 'liviamoura58@email.com', '(11) 95334-4241', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (59, 1, 'Paula Andrade', '20B', 'E', '61832421024', 'paulaandrade59@email.com', '(11) 95728-8195', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (60, 1, 'Claudia Viana', '2A', 'C', '17464887719', 'claudiaviana60@email.com', '(11) 95102-1423', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (61, 1, 'Mariana Barbosa', '15A', 'B', '13990490278', 'marianabarbosa61@email.com', '(11) 98141-9056', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (62, 1, 'Simone Campos', '10B', 'D', '17565512567', 'simonecampos62@email.com', '(11) 91601-8451', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (63, 1, 'Viviane Carvalho', '2', 'E', '15451680876', 'vivianecarvalho63@email.com', '(11) 96927-9167', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (64, 1, 'Helena Mendes', '20', 'B', '70348247710', 'helenamendes64@email.com', '(11) 96091-1224', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (65, 1, 'Carlos Silva 60', '9A', 'D', '86131712748', 'carlossilva6065@email.com', '(11) 98736-4993', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (66, 1, 'João Oliveira 61', '11B', 'C', '78263982146', 'joaooliveira6166@email.com', '(11) 91042-5634', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (67, 1, 'Pedro Santos 62', '18A', 'D', '49972787558', 'pedrosantos6267@email.com', '(11) 96272-4090', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (68, 1, 'Lucas Ferreira 63', '16', 'B', '39636057662', 'lucasferreira6368@email.com', '(11) 99229-6439', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (69, 1, 'Marcos Costa 64', '9A', 'E', '17187026217', 'marcoscosta6469@email.com', '(11) 97512-2315', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (70, 1, 'Rafael Souza 65', '8B', 'A', '58657809134', 'rafaelsouza6570@email.com', '(11) 98110-2612', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (71, 1, 'Bruno Lima 66', '14', 'B', '17240050455', 'brunolima6671@email.com', '(11) 99702-7751', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (72, 1, 'Felipe Pereira 67', '5', 'D', '92221969379', 'felipepereira6772@email.com', '(11) 95161-8529', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (73, 1, 'Thiago Alves 68', '14B', 'C', '40748217594', 'thiagoalves6873@email.com', '(11) 98484-5949', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (74, 1, 'Diego Rocha 69', '1B', 'D', '36713695944', 'diegorocha6974@email.com', '(11) 95497-1132', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (75, 1, 'André Mendes 70', '9B', 'B', '90974395339', 'andremendes7075@email.com', '(11) 92591-1645', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (76, 1, 'Gustavo Martins 71', '7', 'E', '47095214562', 'gustavomartins7176@email.com', '(11) 96994-9697', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (77, 1, 'Ricardo Carvalho 72', '8B', 'D', '84247451712', 'ricardocarvalho7277@email.com', '(11) 96992-2479', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (78, 1, 'Leandro Dias 73', '4B', 'B', '60481754965', 'leandrodias7378@email.com', '(11) 98724-1410', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (79, 1, 'Fernando Ribeiro 74', '2', 'C', '98593174612', 'fernandoribeiro7479@email.com', '(11) 99071-2902', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (80, 1, 'Rodrigo Gomes 75', '14B', 'A', '13826758692', 'rodrigogomes7580@email.com', '(11) 99017-7686', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (81, 1, 'Fabian Torres 76', '12', 'D', '40537735158', 'fabiantorres7681@email.com', '(11) 95520-4109', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (82, 1, 'Henrique Nunes 77', '7', 'E', '17139005329', 'henriquenunes7782@email.com', '(11) 94394-4538', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (83, 1, 'Vinicius Castro 78', '4B', 'A', '35290422842', 'viniciuscastro7883@email.com', '(11) 93159-1243', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (84, 1, 'Eduardo Moreira 79', '4B', 'A', '53950240268', 'eduardomoreira7984@email.com', '(11) 98802-8344', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (85, 1, 'Alexandre Barbosa 80', '15B', 'A', '58917839084', 'alexandrebarbosa8085@email.com', '(11) 91996-8847', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (86, 1, 'Mateus Campos 81', '5A', 'E', '66177115921', 'mateuscampos8186@email.com', '(11) 99984-6327', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (87, 1, 'Leonardo Cardoso 82', '7A', 'D', '69847896118', 'leonardocardoso8287@email.com', '(11) 94743-7779', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (88, 1, 'Caio Correia 83', '16', 'A', '57661565452', 'caiocorreia8388@email.com', '(11) 92398-2527', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (89, 1, 'Renato Freitas 84', '14A', 'D', '61528098851', 'renatofreitas8489@email.com', '(11) 91842-5712', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (90, 1, 'Daniel Teixeira 85', '12B', 'C', '94519832731', 'danielteixeira8590@email.com', '(11) 92882-5564', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (91, 1, 'Julio Nascimento 86', '6A', 'C', '93689980940', 'julionascimento8691@email.com', '(11) 96567-6751', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (92, 1, 'Sergio Moura 87', '13A', 'D', '02296120183', 'sergiomoura8792@email.com', '(11) 96585-3578', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (93, 1, 'Paulo Andrade 88', '3A', 'D', '54599102290', 'pauloandrade8893@email.com', '(11) 97947-8957', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (94, 1, 'Nelson Viana 89', '19A', 'E', '97643815614', 'nelsonviana8994@email.com', '(11) 96053-1744', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (95, 1, 'Ana Lima 90', '11', 'A', '36900343244', 'analima9095@email.com', '(11) 99149-8055', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (96, 1, 'Maria Santos 91', '14', 'D', '22683885160', 'mariasantos9196@email.com', '(11) 92275-6129', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (97, 1, 'Carla Oliveira 92', '20A', 'C', '96966416052', 'carlaoliveira9297@email.com', '(11) 92443-8155', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (98, 1, 'Juliana Costa 93', '11', 'A', '13696816453', 'julianacosta9398@email.com', '(11) 99363-2868', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (99, 1, 'Fernanda Silva 94', '6B', 'B', '88355231243', 'fernandasilva9499@email.com', '(11) 92234-3902', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (100, 1, 'Patricia Rocha 95', '3A', 'D', '77997995527', 'patriciarocha95100@email.com', '(11) 95961-5500', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (101, 1, 'Amanda Ferreira 96', '10', 'A', '90581477005', 'amandaferreira96101@email.com', '(11) 99307-7299', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (102, 1, 'Camila Souza 97', '5', 'D', '79807935978', 'camilasouza97102@email.com', '(11) 92695-6626', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (103, 1, 'Isabela Pereira 98', '12A', 'C', '18203778892', 'isabelapereira98103@email.com', '(11) 97347-7697', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);
INSERT INTO `morador` (`id_user`,`identificador`,`nome`,`apto`,`bloco`,`cpf`,`email`,`telefone`,`senha`,`status`,`previlegio`) VALUES
  (104, 1, 'Leticia Alves 99', '20', 'C', '59051518644', 'leticiaalves99104@email.com', '(11) 92335-3317', '$2y$10$TFYflMyWCmgpm/KFokJ3yO.zlffHUjH3hRufEziUGOT2rOCmA.KK2', 'L', 1);

-- ── Veículos ───────────────────────────────────────────────
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('IRR3112', 'Volkswagen', 'Polo', 'Preto', 5, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('IJU3093', 'Honda', 'Fit', 'Preto', 5, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('LJJ3953', 'Hyundai', 'HB20', 'Azul', 6, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('MFD2264', 'Nissan', 'Kicks', 'Preto', 7, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('NOT9626', 'Toyota', 'Corolla', 'Azul', 7, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('QPE3962', 'Volkswagen', 'Polo', 'Prata', 8, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('SBJ4891', 'Mitsubishi', 'Outlander', 'Laranja', 8, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('TLN6070', 'Peugeot', '208', 'Cinza', 9, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('YZM5616', 'Audi', 'A3', 'Dourado', 10, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('ZVU3267', 'Jeep', 'Renegade', 'Branco', 11, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('WOC9452', 'Chevrolet', 'Onix', 'Vermelho', 12, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('NVC4637', 'Mitsubishi', 'Outlander', 'Azul', 15, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('KKJ7326', 'Fiat', 'Uno', 'Azul', 16, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('FIC6493', 'Volkswagen', 'Gol', 'Prata', 16, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('MVT8685', 'Mitsubishi', 'Outlander', 'Laranja', 18, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('ACG3449', 'Toyota', 'Yaris', 'Laranja', 18, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('CHH1782', 'Renault', 'Kwid', 'Verde', 19, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('QBV9189', 'Volkswagen', 'Polo', 'Dourado', 20, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('GDL6780', 'Renault', 'Kwid', 'Laranja', 22, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('RCZ2108', 'Honda', 'Fit', 'Dourado', 23, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('ZOK8702', 'Toyota', 'Corolla', 'Verde', 24, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('GAU6649', 'Renault', 'Kwid', 'Preto', 25, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('UTI1726', 'Mercedes', 'C180', 'Dourado', 25, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('QVR8840', 'Ford', 'Ka', 'Prata', 26, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('LHB4268', 'Toyota', 'Corolla', 'Azul', 28, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('YNZ9897', 'Peugeot', '208', 'Vermelho', 28, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('HWB6438', 'Jeep', 'Renegade', 'Preto', 30, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('LKL7334', 'BMW', '320i', 'Prata', 31, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('MMY9507', 'Jeep', 'Renegade', 'Preto', 31, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('CPV9937', 'Nissan', 'Kicks', 'Azul', 32, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('HLS3730', 'Mitsubishi', 'Outlander', 'Azul', 34, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('SXP8126', 'Jeep', 'Renegade', 'Branco', 35, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('JUR1510', 'Volkswagen', 'Gol', 'Laranja', 37, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('LDG7001', 'Mercedes', 'C180', 'Verde', 38, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('ADL7077', 'Mercedes', 'C180', 'Bege', 39, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('TON7521', 'BMW', '320i', 'Vermelho', 39, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('CTM7340', 'Toyota', 'Yaris', 'Preto', 40, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('GLZ5678', 'Peugeot', '208', 'Cinza', 41, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('LXL2438', 'BMW', '320i', 'Azul', 43, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('SOH5914', 'Ford', 'Ka', 'Prata', 43, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('NDF3275', 'Renault', 'Kwid', 'Bege', 44, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('AOJ3126', 'Volkswagen', 'Polo', 'Preto', 44, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('SMK7708', 'Fiat', 'Argo', 'Preto', 46, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('BMN3102', 'Toyota', 'Yaris', 'Laranja', 48, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('LXB3034', 'Honda', 'Fit', 'Prata', 50, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('HEY4694', 'Mercedes', 'C180', 'Dourado', 50, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('VGQ5496', 'Volkswagen', 'Gol', 'Vermelho', 51, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('PCQ3526', 'Ford', 'Ka', 'Laranja', 51, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('PVO1464', 'Fiat', 'Uno', 'Branco', 52, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('UGF7825', 'Volkswagen', 'Polo', 'Branco', 53, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('MQH5949', 'Peugeot', '208', 'Cinza', 53, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('RHB1981', 'Ford', 'Ka', 'Bege', 54, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('KMI3353', 'BMW', '320i', 'Azul', 54, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('WZD7070', 'Honda', 'Fit', 'Dourado', 55, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('DLD1829', 'Nissan', 'Kicks', 'Verde', 57, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('KZX6364', 'Fiat', 'Argo', 'Azul', 58, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('EEZ8648', 'Peugeot', '208', 'Vermelho', 58, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('CKL4944', 'Hyundai', 'HB20', 'Laranja', 59, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('BMW8710', 'Nissan', 'Kicks', 'Dourado', 60, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('JKB1838', 'Fiat', 'Argo', 'Dourado', 64, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('BNT5582', 'Volkswagen', 'Polo', 'Laranja', 66, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('KUI6990', 'Volkswagen', 'Gol', 'Cinza', 68, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('PKB1637', 'Volkswagen', 'Gol', 'Azul', 68, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('NDX3290', 'BMW', '320i', 'Laranja', 69, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('IKQ5902', 'Fiat', 'Argo', 'Azul', 69, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('NMO8780', 'Honda', 'Civic', 'Azul', 70, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('CKH1436', 'Volkswagen', 'Polo', 'Bege', 71, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('RZP4728', 'Toyota', 'Corolla', 'Laranja', 72, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('NSU7229', 'Volkswagen', 'Gol', 'Cinza', 73, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('CAI3481', 'Kia', 'Sportage', 'Cinza', 75, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('KUX2020', 'Volkswagen', 'Gol', 'Dourado', 75, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('IRN6140', 'Ford', 'Ka', 'Bege', 76, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('IJU5331', 'Volkswagen', 'Polo', 'Bege', 77, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('EGO4684', 'Nissan', 'Kicks', 'Vermelho', 77, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('RMM5480', 'Nissan', 'Kicks', 'Preto', 78, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('OXK6654', 'Volkswagen', 'Gol', 'Vermelho', 79, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('CYR8849', 'Hyundai', 'HB20', 'Cinza', 81, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('VHO5450', 'Volkswagen', 'Gol', 'Preto', 81, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('PGR9700', 'Renault', 'Kwid', 'Cinza', 82, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('SCU1084', 'Toyota', 'Yaris', 'Prata', 84, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('YWM4267', 'Nissan', 'Kicks', 'Azul', 85, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('BTQ4804', 'Toyota', 'Yaris', 'Branco', 86, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('EWE1595', 'Audi', 'A3', 'Bege', 87, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('ETW5742', 'Toyota', 'Corolla', 'Branco', 87, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('PYI8444', 'Toyota', 'Yaris', 'Dourado', 88, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('YWM4159', 'Chevrolet', 'Onix', 'Azul', 89, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('GET5833', 'Fiat', 'Argo', 'Cinza', 91, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('XVN2421', 'Audi', 'A3', 'Preto', 93, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('EDI5064', 'Honda', 'Civic', 'Vermelho', 93, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('LGI1187', 'Jeep', 'Renegade', 'Azul', 94, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('BDH7642', 'Honda', 'Fit', 'Vermelho', 95, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('QYJ4618', 'Renault', 'Kwid', 'Prata', 96, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('LZJ9998', 'Peugeot', '208', 'Dourado', 97, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('VTR2341', 'Honda', 'Fit', 'Bege', 98, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('NJX2838', 'Toyota', 'Corolla', 'Dourado', 98, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('FNE9525', 'Mitsubishi', 'Outlander', 'Preto', 99, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('RSM9361', 'Mitsubishi', 'Outlander', 'Branco', 99, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('NLB8575', 'Nissan', 'Kicks', 'Branco', 100, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('VTP1742', 'Kia', 'Sportage', 'Azul', 101, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('OBX8734', 'Toyota', 'Corolla', 'Vermelho', 102, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('TTZ7887', 'Mercedes', 'C180', 'Verde', 103, 2);
INSERT INTO `veiculos` (`placa`,`marca`,`modelo`,`cor`,`id_user`,`id_user_cad`) VALUES
  ('XJC9835', 'Volkswagen', 'Gol', 'Azul', 104, 2);

-- ── Reservas ───────────────────────────────────────────────
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 20, '2026-02-07', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-02-07', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 33, '2025-01-24', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 97, '2026-01-24', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-01-24', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 49, '2025-10-10', '13:00:00', '16:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 97, '2025-02-02', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 7, '2025-07-31', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-07-31', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 9, '2025-02-19', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 56, '2025-08-28', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-08-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 104, '2025-05-24', '20:00:00', '23:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 34, '2025-11-25', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 23, '2026-02-28', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-02-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 76, '2026-03-14', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 49, '2026-06-22', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 57, '2025-11-04', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-11-04', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 73, '2025-09-04', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 95, '2026-04-20', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 58, '2026-02-02', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-02-02', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 47, '2026-04-06', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2026-04-06', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 97, '2025-02-22', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 82, '2025-03-16', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 80, '2026-05-06', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 47, '2025-01-16', '13:00:00', '16:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 99, '2026-05-06', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 95, '2026-02-11', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 104, '2026-01-25', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 50, '2025-09-25', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 68, '2025-04-11', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 45, '2026-01-15', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 77, '2025-05-30', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-05-30', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 79, '2025-10-30', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-10-30', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 34, '2025-09-09', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 92, '2025-09-21', '19:00:00', '22:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 87, '2026-04-17', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 50, '2025-05-24', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 74, '2026-06-21', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 14, '2025-01-07', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-01-07', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 85, '2025-03-11', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-03-11', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 69, '2026-01-18', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 90, '2026-05-15', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-05-15', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 75, '2025-01-13', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 40, '2025-01-18', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 91, '2025-07-03', '09:00:00', '12:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 72, '2025-09-04', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 37, '2025-10-01', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-10-01', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 56, '2025-09-07', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-09-07', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 15, '2025-04-06', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 75, '2025-02-27', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 15, '2026-03-21', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 17, '2025-08-24', '13:00:00', '16:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 93, '2025-10-05', '08:00:00', '11:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 92, '2025-02-03', '10:00:00', '13:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 45, '2025-08-01', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 96, '2025-03-20', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-03-20', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 35, '2025-12-06', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 22, '2026-05-28', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2026-05-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 60, '2025-03-19', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 83, '2025-12-01', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 62, '2025-08-22', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 53, '2025-07-10', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-07-10', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 84, '2025-09-10', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-09-10', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 24, '2025-06-07', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 18, '2025-01-06', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 102, '2025-04-15', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-04-15', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 60, '2026-06-09', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-06-09', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 16, '2025-04-06', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 6, '2026-02-28', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 97, '2026-06-18', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 26, '2025-10-03', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-10-03', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 23, '2025-06-21', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-06-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 43, '2025-03-20', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-03-20', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 36, '2025-07-20', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-07-20', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 43, '2026-02-10', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 53, '2026-03-27', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 88, '2025-11-04', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 93, '2026-05-06', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2026-05-06', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 55, '2025-10-26', '19:00:00', '22:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 36, '2026-01-21', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 55, '2025-04-27', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 74, '2025-01-28', '19:00:00', '22:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 31, '2025-10-26', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 57, '2025-05-23', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-05-23', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 89, '2026-03-10', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-03-10', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 81, '2026-02-15', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 93, '2025-02-07', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 73, '2025-04-22', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 50, '2025-02-15', '18:00:00', '21:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 47, '2025-04-19', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-04-19', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 33, '2026-04-02', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 103, '2025-12-20', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 42, '2025-03-29', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 98, '2025-12-23', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 31, '2025-12-23', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-12-23', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 97, '2025-11-23', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 95, '2025-01-24', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 91, '2025-09-07', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-09-07', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 25, '2026-03-13', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-03-13', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 56, '2025-07-10', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 99, '2026-04-06', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 95, '2025-07-30', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 13, '2025-07-11', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 63, '2025-09-26', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 86, '2026-02-02', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 49, '2026-04-14', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 95, '2025-03-28', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 35, '2025-04-30', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 23, '2026-03-05', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 59, '2026-05-14', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 87, '2025-06-20', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-06-20', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 28, '2026-04-07', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 6, '2025-05-20', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 76, '2026-02-23', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 61, '2025-06-21', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 102, '2025-10-27', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-10-27', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 73, '2025-06-22', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 103, '2026-06-08', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 39, '2025-02-12', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 59, '2025-09-11', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 9, '2025-09-27', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 16, '2025-05-01', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-05-01', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 99, '2026-03-15', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 31, '2025-03-02', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 81, '2025-11-28', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-11-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 39, '2025-05-19', '18:00:00', '21:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 40, '2025-05-16', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-05-16', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 46, '2026-02-07', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-02-07', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 85, '2026-03-01', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 86, '2026-02-17', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 93, '2026-04-11', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 5, '2026-04-15', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 73, '2025-08-12', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 68, '2025-11-27', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 78, '2026-05-12', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 102, '2025-02-17', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 63, '2025-05-08', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 5, '2025-07-27', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 43, '2025-10-08', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 37, '2026-01-16', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-01-16', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 85, '2025-08-28', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 95, '2025-01-02', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 21, '2026-06-16', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-06-16', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 94, '2025-05-04', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 66, '2025-08-23', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-08-23', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 18, '2025-11-17', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 22, '2025-05-17', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-05-17', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 77, '2025-06-18', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 32, '2026-02-26', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 16, '2025-05-24', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 54, '2026-03-16', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 36, '2025-03-28', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 81, '2025-01-28', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-01-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 82, '2026-02-06', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 35, '2026-01-31', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-01-31', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 86, '2026-06-25', '08:00:00', '11:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 45, '2026-02-01', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 92, '2026-04-28', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-04-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 13, '2025-09-26', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-09-26', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 12, '2026-06-03', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 69, '2026-03-10', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-03-10', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 73, '2025-10-12', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 70, '2025-06-09', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 80, '2025-11-14', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 35, '2025-09-08', '09:00:00', '12:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 19, '2025-02-26', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 89, '2025-05-03', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 94, '2025-06-17', '19:00:00', '22:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 71, '2025-06-20', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-06-20', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 104, '2025-05-01', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 59, '2026-06-21', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-06-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 78, '2026-05-24', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 12, '2025-06-20', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-06-20', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 103, '2025-04-29', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 5, '2025-01-13', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-01-13', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 51, '2025-06-03', '10:00:00', '13:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 9, '2025-08-18', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-08-18', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 97, '2025-10-05', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 20, '2025-07-03', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 10, '2025-03-12', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 104, '2025-12-02', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 6, '2025-07-25', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 43, '2026-04-21', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 68, '2025-09-09', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-09-09', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 57, '2025-08-27', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 93, '2025-12-10', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 53, '2025-04-17', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 35, '2026-05-19', '08:00:00', '11:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 23, '2025-04-06', '08:00:00', '11:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 71, '2026-01-17', '19:00:00', '22:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 15, '2026-06-02', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 55, '2025-03-05', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 21, '2025-10-26', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 55, '2025-11-22', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-11-22', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 14, '2025-05-20', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-05-20', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 26, '2026-04-23', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 73, '2025-08-01', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 38, '2025-04-03', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 43, '2025-08-09', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-08-09', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 96, '2025-12-31', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 91, '2025-09-24', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-09-24', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 56, '2025-09-13', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 22, '2025-01-13', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 33, '2025-07-22', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 85, '2025-09-23', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-09-23', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 13, '2026-03-31', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-03-31', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 47, '2025-02-13', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-02-13', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 78, '2026-02-09', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-02-09', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 92, '2025-06-26', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-06-26', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 28, '2025-10-14', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 9, '2025-10-30', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 75, '2025-03-04', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-03-04', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 22, '2025-07-24', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-07-24', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 74, '2026-01-27', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 67, '2026-05-30', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 28, '2025-11-23', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-11-23', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 104, '2025-03-01', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 103, '2025-06-13', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-06-13', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 35, '2025-02-27', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 54, '2025-06-27', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-06-27', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 45, '2025-01-29', '15:00:00', '18:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 77, '2025-07-12', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 27, '2025-02-08', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-02-08', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 82, '2025-01-21', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 47, '2025-05-14', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 46, '2025-01-23', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 23, '2026-06-23', '15:00:00', '18:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 52, '2025-04-14', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 22, '2026-03-24', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 27, '2025-08-17', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 98, '2025-05-11', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 94, '2025-02-03', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 83, '2025-04-17', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-04-17', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 100, '2025-09-01', '15:00:00', '18:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 26, '2025-12-10', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-12-10', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 31, '2025-03-11', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-03-11', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 18, '2025-02-19', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 58, '2026-02-28', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 49, '2025-04-14', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 78, '2025-06-16', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-06-16', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 9, '2025-01-21', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-01-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 18, '2025-12-17', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 25, '2025-04-06', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 83, '2025-02-01', '18:00:00', '21:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 26, '2025-06-10', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-06-10', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 31, '2026-02-24', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 98, '2025-10-16', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-10-16', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 11, '2026-05-18', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-05-18', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 5, '2025-03-31', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 85, '2025-07-24', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-07-24', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 26, '2025-03-25', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 44, '2026-04-28', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 38, '2026-02-01', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 53, '2025-07-11', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-07-11', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 61, '2025-09-27', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 77, '2025-06-04', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-06-04', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 49, '2025-08-21', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-08-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 54, '2026-05-02', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 15, '2025-02-05', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 71, '2025-05-04', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-05-04', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 26, '2025-07-17', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-07-17', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 15, '2025-07-26', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 38, '2025-03-10', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 55, '2025-10-10', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 6, '2025-04-26', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-04-26', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 77, '2025-04-19', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 73, '2026-02-25', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 67, '2025-02-08', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-02-08', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 23, '2025-02-09', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 47, '2025-02-20', '19:00:00', '22:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 52, '2025-12-12', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 67, '2025-08-22', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 100, '2025-11-25', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 82, '2025-07-12', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-07-12', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 57, '2026-06-13', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 70, '2025-03-09', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 56, '2026-06-21', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-06-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 30, '2025-09-13', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 51, '2025-10-08', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 69, '2025-05-07', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-05-07', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 67, '2025-07-01', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 49, '2025-06-17', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 93, '2025-10-19', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 25, '2025-08-15', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 39, '2026-06-10', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 103, '2026-05-01', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 81, '2025-08-18', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 44, '2026-03-10', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 63, '2025-08-12', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 71, '2025-04-15', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 89, '2025-10-17', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 66, '2025-12-11', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 40, '2025-11-02', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-11-02', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 102, '2025-02-28', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 92, '2025-01-27', '19:00:00', '22:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 38, '2026-02-19', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 79, '2025-12-18', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 86, '2026-01-03', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 26, '2025-10-28', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 99, '2025-07-07', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 33, '2025-08-17', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 47, '2025-09-24', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 20, '2025-02-24', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 29, '2026-01-26', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-01-26', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 11, '2025-05-21', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 77, '2025-05-27', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 28, '2026-05-15', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 27, '2025-03-01', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 31, '2025-06-12', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 104, '2025-05-13', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 56, '2026-05-04', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-05-04', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 73, '2026-01-18', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 101, '2025-01-19', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 36, '2025-12-19', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-12-19', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 54, '2025-06-21', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 43, '2026-04-12', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 48, '2025-05-18', '15:00:00', '18:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 67, '2025-07-12', '10:00:00', '13:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 56, '2025-08-22', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 21, '2025-01-23', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-01-23', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 51, '2026-01-20', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 84, '2025-02-19', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 7, '2025-04-29', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 20, '2026-05-01', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-05-01', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 92, '2025-11-05', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 89, '2025-05-21', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 18, '2025-10-17', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 68, '2025-07-24', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 30, '2026-02-24', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-02-24', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 75, '2025-08-01', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 5, '2025-04-02', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 90, '2025-06-02', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 14, '2025-09-20', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 42, '2026-04-21', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-04-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 27, '2025-10-25', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 45, '2025-04-29', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 10, '2025-05-22', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 61, '2025-04-06', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 28, '2026-02-15', '18:00:00', '21:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 39, '2026-05-05', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 26, '2025-05-16', '08:00:00', '11:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 25, '2026-03-03', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 91, '2025-07-05', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 83, '2025-05-14', '19:00:00', '22:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 19, '2026-03-28', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-03-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 88, '2025-01-13', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 78, '2025-12-13', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 94, '2026-03-20', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 89, '2025-06-02', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 83, '2025-01-12', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 65, '2025-06-19', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 46, '2025-12-05', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-12-05', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 33, '2026-02-17', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-02-17', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 61, '2025-04-01', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 20, '2025-01-19', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 9, '2025-04-04', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 76, '2026-04-13', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 11, '2026-04-11', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 84, '2026-01-08', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-01-08', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 102, '2025-01-03', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 86, '2026-06-19', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 10, '2026-05-20', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 100, '2025-04-20', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 29, '2026-02-07', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 29, '2025-04-21', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-04-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 86, '2026-04-07', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 69, '2026-05-26', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 11, '2026-05-10', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 27, '2025-05-12', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 81, '2026-06-01', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 82, '2025-10-08', '18:00:00', '21:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 42, '2025-05-17', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 94, '2025-11-18', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 30, '2025-10-25', '15:00:00', '18:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 21, '2026-05-31', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 46, '2025-12-27', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 78, '2025-10-20', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 71, '2025-01-26', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-01-26', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 90, '2025-07-24', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 25, '2025-09-14', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 93, '2025-07-28', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-07-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 62, '2025-08-18', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 70, '2025-02-18', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 92, '2025-02-25', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 30, '2025-08-19', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 74, '2025-07-18', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 92, '2025-07-11', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 20, '2025-02-11', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-02-11', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 38, '2025-06-14', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-06-14', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 64, '2025-02-10', '10:00:00', '13:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 81, '2025-11-05', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 75, '2025-03-16', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 28, '2026-06-02', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 73, '2025-04-05', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-04-05', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 32, '2025-12-06', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-12-06', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 101, '2025-01-10', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 62, '2025-09-07', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 46, '2025-04-27', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-04-27', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 97, '2025-01-26', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 52, '2026-05-14', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-05-14', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 88, '2025-11-25', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-11-25', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 17, '2025-01-08', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-01-08', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 85, '2026-03-11', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-03-11', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 94, '2025-03-15', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-03-15', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 96, '2025-02-08', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-02-08', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 27, '2025-03-14', '13:00:00', '16:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 57, '2026-04-07', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 7, '2025-05-02', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-05-02', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 97, '2025-02-16', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 69, '2025-10-24', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 41, '2026-01-26', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 8, '2025-06-10', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-06-10', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 100, '2025-10-30', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-10-30', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 98, '2025-01-12', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 23, '2025-02-12', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 55, '2025-11-09', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 97, '2025-08-05', '18:00:00', '21:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 70, '2025-06-14', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-06-14', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 37, '2025-04-28', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 77, '2026-04-18', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-04-18', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 90, '2025-09-14', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-09-14', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 79, '2025-12-05', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-12-05', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 88, '2025-04-13', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 29, '2026-05-13', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 89, '2025-06-06', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 59, '2025-01-05', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-01-05', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 33, '2025-10-11', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-10-11', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 98, '2026-05-07', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 104, '2026-05-14', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-05-14', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 87, '2025-10-15', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 30, '2025-03-20', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 69, '2026-02-19', '13:00:00', '16:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 75, '2026-04-29', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 33, '2025-05-18', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 16, '2026-01-08', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-01-08', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 35, '2026-06-11', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 27, '2026-05-11', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2026-05-11', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 102, '2025-08-26', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-08-26', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 34, '2025-07-31', '20:00:00', '23:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 51, '2026-04-26', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 10, '2025-04-16', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 40, '2025-06-28', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 51, '2026-06-14', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 33, '2025-12-28', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 66, '2026-05-29', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 34, '2026-06-11', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-06-11', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 28, '2026-01-06', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 58, '2025-04-27', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 66, '2025-06-15', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-06-15', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 10, '2025-06-14', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 10, '2025-02-27', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-02-27', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 28, '2025-01-20', '14:00:00', '17:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 32, '2026-04-28', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-04-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 57, '2025-07-06', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-07-06', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 97, '2026-04-10', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-04-10', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 54, '2025-04-22', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-04-22', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 69, '2025-06-03', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-06-03', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 83, '2026-05-31', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-05-31', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 89, '2025-01-02', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 52, '2026-03-16', '13:00:00', '16:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 66, '2025-12-25', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 37, '2025-08-27', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-08-27', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 74, '2025-09-21', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-09-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 100, '2026-06-20', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 53, '2025-11-20', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 24, '2025-09-17', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 59, '2025-10-10', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 57, '2025-07-03', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 66, '2025-11-11', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 55, '2025-05-02', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 94, '2025-04-13', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 48, '2025-06-14', '18:00:00', '21:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 5, '2025-05-29', '19:00:00', '22:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 60, '2025-03-07', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-03-07', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 15, '2026-01-29', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 71, '2025-02-28', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 61, '2025-07-26', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-07-26', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 9, '2025-06-23', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 88, '2025-06-11', '09:00:00', '12:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 104, '2025-12-28', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 30, '2025-03-12', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 97, '2025-12-22', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-12-22', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 29, '2026-02-18', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-02-18', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 57, '2025-03-16', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-03-16', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 19, '2025-09-14', '19:00:00', '22:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 77, '2025-09-07', '15:00:00', '18:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 63, '2025-01-29', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-01-29', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 13, '2025-08-14', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 57, '2026-06-13', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-06-13', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 38, '2025-10-22', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 100, '2025-03-19', '20:00:00', '23:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 65, '2025-12-29', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 39, '2025-07-14', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 35, '2025-09-29', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-09-29', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 36, '2025-06-09', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-06-09', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 15, '2025-01-07', '20:00:00', '23:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 66, '2025-11-19', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 78, '2026-05-18', '10:00:00', '13:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 70, '2026-02-12', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 21, '2026-06-23', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 74, '2026-05-30', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 92, '2026-04-14', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 63, '2025-01-09', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 53, '2025-11-30', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 38, '2025-09-27', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-09-27', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 83, '2026-01-10', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 31, '2026-01-17', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 40, '2025-07-04', '10:00:00', '13:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 92, '2025-04-13', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 76, '2026-01-26', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-01-26', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 99, '2026-04-30', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-04-30', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 68, '2026-06-14', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 67, '2025-09-14', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 11, '2025-04-12', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-04-12', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 37, '2025-04-09', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 38, '2026-01-04', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 37, '2025-01-21', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-01-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 91, '2025-06-28', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 91, '2026-04-03', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 41, '2025-05-29', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 48, '2026-02-19', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-02-19', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 48, '2025-11-18', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 95, '2026-02-09', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 104, '2026-06-18', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 28, '2025-05-09', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 100, '2025-08-04', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 17, '2026-04-30', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-04-30', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 103, '2026-06-21', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-06-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 84, '2025-03-28', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 36, '2026-03-30', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-03-30', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 26, '2025-02-05', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 46, '2026-04-24', '20:00:00', '23:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 75, '2025-05-19', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-05-19', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 81, '2026-03-22', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 73, '2025-12-22', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 16, '2025-11-12', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 24, '2025-01-11', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 102, '2025-12-19', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 6, '2026-05-04', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-05-04', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 60, '2025-08-25', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 29, '2026-03-24', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-03-24', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 96, '2026-01-23', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-01-23', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 59, '2026-06-14', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-06-14', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 100, '2026-02-27', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 28, '2025-10-24', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 84, '2025-10-06', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-10-06', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 7, '2025-02-20', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-02-20', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 18, '2025-10-03', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 98, '2025-08-27', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-08-27', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 68, '2025-12-17', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 68, '2026-04-20', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 101, '2025-02-27', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 14, '2025-07-05', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 37, '2025-01-13', '09:00:00', '12:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 96, '2026-01-30', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-01-30', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 9, '2026-04-17', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 31, '2026-02-03', '14:00:00', '17:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 25, '2026-06-18', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-06-18', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 86, '2025-07-23', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 90, '2025-04-26', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 46, '2025-06-21', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 55, '2025-01-10', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 93, '2025-06-08', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 36, '2026-05-27', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 48, '2025-03-03', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 94, '2025-05-09', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-05-09', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 76, '2026-03-26', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-03-26', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 53, '2025-05-18', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 67, '2025-10-29', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 29, '2025-12-23', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 40, '2025-03-12', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-03-12', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 42, '2026-01-11', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-01-11', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 86, '2025-07-09', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 51, '2025-11-25', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 73, '2025-07-14', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 103, '2025-10-17', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 46, '2025-04-09', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 10, '2025-07-02', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-07-02', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 67, '2025-04-12', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 54, '2026-06-23', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-06-23', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 33, '2025-01-14', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 15, '2025-03-04', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 58, '2025-03-01', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 98, '2025-11-08', '09:00:00', '12:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 71, '2025-04-14', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 29, '2026-06-23', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 27, '2025-04-19', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 94, '2025-04-17', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 75, '2026-06-01', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 73, '2025-12-27', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 46, '2026-02-27', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 46, '2025-08-08', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 100, '2026-01-04', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 55, '2025-02-05', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 71, '2025-11-06', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 33, '2025-11-19', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 93, '2026-06-08', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 78, '2025-04-07', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 24, '2025-09-29', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 36, '2025-09-20', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-09-20', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 56, '2025-03-21', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 27, '2025-04-08', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-04-08', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 78, '2025-03-22', '08:00:00', '11:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 47, '2026-03-21', '18:00:00', '21:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 20, '2025-01-12', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-01-12', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 72, '2025-11-23', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 46, '2025-06-06', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 55, '2026-06-01', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-06-01', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 42, '2025-06-01', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 65, '2026-02-13', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-02-13', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 69, '2025-05-14', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 30, '2026-02-09', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 99, '2025-09-06', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-09-06', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 60, '2025-04-02', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 59, '2025-12-23', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 81, '2025-11-09', '10:00:00', '13:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 83, '2025-05-30', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-05-30', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 34, '2026-01-18', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 15, '2025-02-25', '13:00:00', '16:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 23, '2025-01-15', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 19, '2026-04-06', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-04-06', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 31, '2025-07-28', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 38, '2025-05-25', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 89, '2025-09-19', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-09-19', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 30, '2025-02-24', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 6, '2026-02-02', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 89, '2025-04-21', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-04-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 88, '2025-08-25', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 95, '2025-11-20', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 73, '2025-07-10', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 63, '2025-02-10', '13:00:00', '16:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 44, '2026-05-17', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 7, '2025-12-27', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 35, '2025-03-05', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 8, '2025-08-19', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 55, '2025-03-31', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 91, '2026-03-04', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 59, '2025-12-04', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 31, '2025-07-27', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 95, '2026-03-17', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 77, '2025-11-22', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 97, '2025-07-08', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 23, '2025-11-23', '18:00:00', '21:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 43, '2025-10-08', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 18, '2025-07-09', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 83, '2025-08-25', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-08-25', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 8, '2025-03-23', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-03-23', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 82, '2026-01-18', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 67, '2025-05-21', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-05-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 9, '2025-01-16', '14:00:00', '17:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 33, '2025-07-29', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-07-29', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 61, '2025-11-29', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 59, '2025-02-12', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 55, '2026-06-18', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 10, '2026-06-16', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 99, '2026-02-01', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 11, '2025-10-26', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 43, '2026-04-18', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 83, '2026-06-14', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 87, '2025-04-03', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-04-03', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 104, '2026-02-07', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 8, '2026-04-10', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 16, '2025-11-28', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 20, '2025-04-27', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 15, '2026-06-08', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 53, '2025-06-24', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 89, '2025-06-16', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-06-16', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 96, '2026-03-06', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 103, '2025-10-23', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-10-23', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 21, '2025-01-04', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-01-04', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 68, '2025-01-06', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-01-06', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 80, '2026-04-10', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 81, '2025-09-08', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-09-08', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 85, '2025-02-20', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-02-20', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 88, '2025-02-07', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 90, '2025-12-06', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-12-06', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 58, '2025-06-15', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 93, '2026-04-12', '15:00:00', '18:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 16, '2025-11-27', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 13, '2025-03-08', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 20, '2025-12-04', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 31, '2025-03-01', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 85, '2026-05-11', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 45, '2026-06-23', '15:00:00', '18:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 83, '2026-06-17', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 28, '2025-10-25', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-10-25', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 8, '2025-05-01', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 58, '2025-02-16', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 86, '2025-01-12', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 37, '2025-11-12', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 46, '2025-04-27', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 97, '2025-06-29', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 48, '2026-05-01', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 66, '2026-04-17', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 64, '2025-02-27', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-02-27', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 97, '2025-01-20', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 47, '2025-03-09', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-03-09', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 8, '2026-01-20', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 78, '2025-07-11', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 101, '2025-11-19', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-11-19', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 16, '2025-09-01', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 43, '2026-06-22', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-06-22', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 52, '2025-07-26', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 8, '2026-05-28', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-05-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 66, '2025-12-02', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 17, '2025-07-30', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 96, '2025-01-05', '14:00:00', '17:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 92, '2025-12-08', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 18, '2025-01-24', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 31, '2025-07-25', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2025-07-25', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 73, '2026-03-28', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-03-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 25, '2025-04-28', '08:00:00', '11:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 76, '2025-07-31', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 45, '2025-05-25', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 26, '2025-11-15', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 11, '2025-01-30', '19:00:00', '22:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 11, '2026-01-28', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-01-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 55, '2026-04-02', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 30, '2026-04-22', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-04-22', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 94, '2025-04-10', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 87, '2026-04-27', '13:00:00', '16:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 23, '2026-01-08', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-01-08', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 90, '2025-11-29', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 13, '2025-04-26', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 26, '2025-12-23', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 56, '2025-11-30', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 43, '2026-02-15', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-02-15', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 36, '2026-05-09', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-05-09', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 31, '2026-03-22', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 35, '2025-03-21', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-03-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 81, '2025-11-30', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-11-30', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 61, '2025-11-12', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-11-12', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 18, '2025-12-02', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 12, '2025-08-11', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 101, '2025-05-31', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 42, '2026-04-03', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-04-03', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 45, '2025-11-08', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 49, '2025-01-09', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 21, '2025-03-05', '15:00:00', '18:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 11, '2026-01-03', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 8, '2026-03-19', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 96, '2026-02-20', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 32, '2026-05-02', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-05-02', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 54, '2026-03-04', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-03-04', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 90, '2025-05-18', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-05-18', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 7, '2026-05-14', '18:00:00', '21:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 22, '2025-05-21', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 94, '2025-07-04', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 75, '2026-01-29', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2026-01-29', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 59, '2026-05-26', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 39, '2026-01-11', '08:00:00', '11:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 77, '2026-01-13', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 93, '2025-05-26', '20:00:00', '23:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 101, '2026-04-22', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-04-22', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 83, '2025-09-09', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 89, '2025-11-16', '08:00:00', '11:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 73, '2026-04-26', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 65, '2026-03-08', '15:00:00', '18:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 42, '2025-06-21', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 81, '2025-09-24', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 79, '2025-02-22', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 84, '2025-10-21', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-10-21', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 69, '2025-10-12', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-10-12', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 40, '2025-09-21', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 82, '2025-06-04', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 27, '2025-08-30', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2025-08-30', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 72, '2025-12-18', '09:00:00', '12:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 81, '2026-05-23', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 35, '2025-06-21', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 49, '2025-09-28', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-09-28', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 64, '2026-05-03', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 101, '2026-01-24', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 23, '2025-01-13', '14:00:00', '17:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 62, '2025-11-20', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 10, '2025-12-29', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 88, '2025-12-10', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-12-10', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 17, '2026-02-05', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 100, '2025-07-19', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 93, '2025-11-17', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2025-11-17', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 6, '2025-01-13', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-01-13', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 18, '2025-12-26', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 37, '2025-02-04', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 12, '2025-05-05', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-05-05', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 82, '2026-01-20', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 94, '2025-09-17', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 14, '2025-10-11', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 90, '2025-09-21', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 40, '2026-01-27', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 12, '2025-09-29', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 67, '2026-02-07', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 18, '2026-03-18', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 18, '2025-09-23', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-09-23', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 14, '2026-04-02', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 24, '2025-02-08', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-02-08', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 94, '2026-02-05', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 103, '2026-05-05', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 98, '2025-08-20', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 93, '2025-05-05', '20:00:00', '23:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 50, '2025-11-07', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-11-07', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 87, '2026-01-10', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 48, '2026-04-16', '14:00:00', '17:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 27, '2026-01-29', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-01-29', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 54, '2026-01-03', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-01-03', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 85, '2025-07-14', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-07-14', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 8, '2026-05-16', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2026-05-16', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 74, '2026-05-27', '20:00:00', '23:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 62, '2025-02-07', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-02-07', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 97, '2026-02-20', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2026-02-20', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 88, '2025-06-02', '13:00:00', '16:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 9, '2026-05-16', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 84, '2025-09-06', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-09-06', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 85, '2025-11-11', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 26, '2025-04-19', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 83, '2025-03-06', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 99, '2025-11-29', '09:00:00', '12:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 78, '2025-11-26', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 80, '2025-12-10', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-12-10', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 23, '2025-06-22', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 61, '2025-02-11', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2025-02-11', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 85, '2025-06-11', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 15, '2025-01-08', '10:00:00', '13:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 95, '2026-03-03', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 31, '2025-10-05', '20:00:00', '23:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 35, '2025-02-08', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 83, '2025-11-05', '15:00:00', '18:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 76, '2025-07-16', '09:00:00', '12:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 17, '2026-06-04', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 85, '2025-10-11', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2025-10-11', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 24, '2026-05-25', '10:00:00', '13:00:00', 'A', 2, 'Vitor Leon', '2026-05-25', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 10, '2026-01-08', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-01-08', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 37, '2026-04-10', '08:00:00', '11:00:00', 'A', 2, 'Vitor Leon', '2026-04-10', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 11, '2025-06-11', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 19, '2025-08-29', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 46, '2025-07-23', '15:00:00', '18:00:00', 'A', 2, 'Vitor Leon', '2025-07-23', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 19, '2025-08-22', '09:00:00', '12:00:00', 'A', 2, 'Vitor Leon', '2025-08-22', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 57, '2026-01-20', '13:00:00', '16:00:00', 'A', 2, 'Vitor Leon', '2026-01-20', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (3, 79, '2025-02-25', '18:00:00', '21:00:00', 'A', 2, 'Vitor Leon', '2025-02-25', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 83, '2025-07-02', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 63, '2026-01-03', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-01-03', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 21, '2025-03-03', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2025-03-03', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 64, '2026-03-05', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 33, '2025-06-10', '10:00:00', '13:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 75, '2025-03-30', '18:00:00', '21:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 67, '2026-04-30', '19:00:00', '22:00:00', 'A', 2, 'Vitor Leon', '2026-04-30', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 98, '2025-09-10', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 79, '2025-06-02', '08:00:00', '11:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 10, '2026-04-27', '20:00:00', '23:00:00', 'A', 2, 'Vitor Leon', '2026-04-27', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 72, '2026-05-06', '09:00:00', '12:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 35, '2025-01-13', '18:00:00', '21:00:00', 'N');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 21, '2025-10-30', '13:00:00', '16:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`,`id_user_aprov`,`nome_user_aprov`,`data_aprov`,`hora_aprov`) VALUES
  (1, 16, '2026-05-07', '14:00:00', '17:00:00', 'A', 2, 'Vitor Leon', '2026-05-07', '10:00:00');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (1, 63, '2026-04-11', '19:00:00', '22:00:00', 'P');
INSERT INTO `reservas` (`id_local`,`id_user`,`data_reserva`,`hora_ini`,`hora_fim`,`status`) VALUES
  (3, 95, '2025-07-09', '15:00:00', '18:00:00', 'P');

-- ✅ Total gerado: 100 moradores | 102 veículos | 850 reservas