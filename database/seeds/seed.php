<?php

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/helpers/CryptoHelper.php';
require_once __DIR__ . '/../../app/helpers/VeiculoCatalogo.php';

set_time_limit(180);

function gerarUuid(): string
{
    $bytes = random_bytes(16);
    $bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x40);
    $bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
}

function gerarCpfValido(array &$usados): string
{
    do {
        $n = [];
        for ($i = 0; $i < 9; $i++) {
            $n[] = random_int(0, 9);
        }
        for ($t = 9; $t < 11; $t++) {
            $soma = 0;
            for ($i = 0; $i < $t; $i++) {
                $soma += $n[$i] * (($t + 1) - $i);
            }
            $n[] = ((10 * $soma) % 11) % 10;
        }
        $cpf = implode('', $n);
    } while (isset($usados[$cpf]));

    $usados[$cpf] = true;
    return $cpf;
}

function slug(string $texto): string
{
    $ascii = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $texto);
    return strtolower(trim(preg_replace('/[^a-zA-Z]+/', '.', $ascii), '.'));
}

function telefoneCelular(int $i): string
{
    return sprintf('(11) 9%04d-%04d', 2000 + ($i % 7000), 1000 + (($i * 37) % 9000));
}

function telefoneFixo(int $i): string
{
    return sprintf('(11) 3%03d-%04d', 100 + ($i % 900), 1000 + (($i * 19) % 9000));
}

function dataRelativa(int $dias, string $hora = '09:00:00'): string
{
    return (new DateTime('2026-06-06 ' . $hora))->modify(($dias >= 0 ? '+' : '') . $dias . ' days')->format('Y-m-d H:i:s');
}

try {
    $pdo = getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

    foreach ([
        'assembleias_presencas', 'assembleias', 'avisos',
        'ocorrencia_notificacoes', 'ocorrencia_tramites', 'ocorrencias',
        'lancamentos', 'faturas', 'taxas_padrao',
        'reservas', 'veiculos', 'locais_festivos',
        'auditoria', 'morador',
    ] as $tabela) {
        $pdo->exec("TRUNCATE TABLE {$tabela}");
    }
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    $pdo->beginTransaction();

    $senhaPadrao = '123456';
    $hash = password_hash($senhaPadrao, PASSWORD_BCRYPT);
    $cpfsUsados = [
        '00000000000' => true,
        '99999999999' => true,
        '11111111111' => true,
        '22222222222' => true,
        '43209957835' => true,
        '98765432100' => true,
    ];
    $cpfSindicoExtra1 = gerarCpfValido($cpfsUsados);
    $cpfSindicoExtra2 = gerarCpfValido($cpfsUsados);

    echo "<pre>";
    echo "Seed DomusFlow iniciado.\n";
    echo "Senha padrão de todos os usuários: {$senhaPadrao}\n\n";

    $stmtMorador = $pdo->prepare("
        INSERT INTO morador
            (id_user, uuid, nome, apto, bloco, cpf, cpf_hash, email, email_hash, telefone, tell_recado, senha, status, privilegio, created_at)
        VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $usuariosSistema = [
        [1, 'Admin Principal', '0', 'G', '00000000000', 'ana.costa@domusflow.com', '(11) 3000-0000', null, 'L', 4],
        [2, 'Admin Reserva', '0', 'G', '99999999999', 'marcos.ribeiro@domusflow.com', '(11) 3000-0001', null, 'L', 4],
        [3, 'Vitor Leon', '10', 'A', '43209957835', 'sindico@domusflow.com', '(11) 98522-9900', '(11) 95907-3260', 'L', 2],
        [4, 'Mariana Alves', '11', 'B', '98765432100', 'mariana.alves@domusflow.com', '(11) 98888-1100', null, 'L', 2],
        [5, 'Roberto Martins', '12', 'C', $cpfSindicoExtra1, 'roberto.martins@domusflow.com', '(11) 97777-1200', null, 'L', 2],
        [6, 'Patricia Gomes', '13', 'D', $cpfSindicoExtra2, 'patricia.gomes@domusflow.com', '(11) 96666-1300', null, 'L', 2],
        [7, 'Carlos Lima', '0', 'G', '11111111111', 'porteiro@domusflow.com', '(11) 3000-0002', null, 'L', 3],
        [8, 'Eduardo Moreira', '0', 'G', '22222222222', 'eduardo.moreira@domusflow.com', '(11) 3000-0003', null, 'L', 3],
    ];

    foreach ($usuariosSistema as $u) {
        $stmtMorador->execute([
            $u[0], gerarUuid(), CryptoHelper::encrypt($u[1]), $u[2], $u[3],
            CryptoHelper::encrypt($u[4]), CryptoHelper::hashCpf($u[4]),
            CryptoHelper::encrypt($u[5]), CryptoHelper::hashEmail($u[5]),
            CryptoHelper::encrypt($u[6]), CryptoHelper::encrypt($u[7]),
            $hash, $u[8], $u[9], dataRelativa(-180 + $u[0]),
        ]);
    }

    $credenciaisChave = [
        'admin' => ['nome' => $usuariosSistema[0][1], 'cpf' => $usuariosSistema[0][4]],
        'sindico' => ['nome' => $usuariosSistema[2][1], 'cpf' => $usuariosSistema[2][4]],
        'porteiro' => ['nome' => $usuariosSistema[6][1], 'cpf' => $usuariosSistema[6][4]],
        'morador' => null,
    ];

    $nomesMasculinos = [
        'Carlos', 'Joao', 'Pedro', 'Lucas', 'Marcos', 'Rafael', 'Bruno', 'Felipe', 'Thiago', 'Diego',
        'André', 'Gustavo', 'Ricardo', 'Leandro', 'Fernando', 'Rodrigo', 'Fabian', 'Henrique', 'Vinicius', 'Eduardo',
        'Alexandre', 'Mateus', 'Leonardo', 'Caio', 'Renato', 'Daniel', 'Julio', 'Sergio', 'Paulo', 'Nelson',
        'Roberto', 'Guilherme', 'Marcelo', 'Antônio', 'Jorge', 'Wagner', 'Patrick', 'Samuel', 'Davi', 'Victor',
    ];
    $nomesFemininos = [
        'Ana', 'Maria', 'Carla', 'Juliana', 'Fernanda', 'Patricia', 'Amanda', 'Camila', 'Isabela', 'Leticia',
        'Gabriela', 'Beatriz', 'Larissa', 'Natalia', 'Priscila', 'Tatiana', 'Vanessa', 'Renata', 'Luciana', 'Aline',
        'Bruna', 'Debora', 'Fabiana', 'Livia', 'Paula', 'Claudia', 'Mariana', 'Simone', 'Viviane', 'Helena',
        'Monica', 'Cristiane', 'Elaine', 'Silvia', 'Adriana', 'Daniela', 'Raquel', 'Sabrina', 'Tania', 'Vera',
    ];
    $sobrenomes = [
        'Silva', 'Oliveira', 'Souza', 'Costa', 'Pereira', 'Rodrigues', 'Alves', 'Ferreira', 'Gomes', 'Martins',
        'Barbosa', 'Ribeiro', 'Carvalho', 'Dias', 'Rocha', 'Teixeira', 'Moreira', 'Batista', 'Freitas', 'Mendes',
        'Lima', 'Cardoso', 'Nogueira', 'Monteiro', 'Correia', 'Farias', 'Duarte', 'Peixoto', 'Queiroz', 'Moura',
        'Neves', 'Sales', 'Campos', 'Rezende', 'Borges', 'Amaral', 'Cunha', 'Vieira', 'Pinto', 'Araújo',
    ];
    $blocos = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
    $aptosPorBloco = 100;
    $statusDistribuicao = array_merge(
        array_fill(0, 800, 'L'),
        array_fill(0, 80, 'P'),
        array_fill(0, 70, 'I'),
        array_fill(0, 50, 'B')
    );

    $idsMoradores = [];
    $idsAtivos = [];
    $idsPendentes = [];
    $idsInativos = [];
    $idsBloqueados = [];
    $emailsUsados = [];
    $unidadesSistema = [];
    foreach ($usuariosSistema as $u) {
        if ((int)$u[9] === 2) {
            $unidadesSistema[$u[3] . '-' . $u[2]] = true;
        }
    }
    $proximaUnidadeAtiva = 0;
    $id = 9;
    $nomeIndex = 0;

    for ($i = 0; $i < 1000; $i++, $id++) {
        $lista = ($i % 2 === 0) ? $nomesMasculinos : $nomesFemininos;
        $primeiro = $lista[$i % count($lista)];
        $sob1 = $sobrenomes[intdiv($nomeIndex, count($sobrenomes)) % count($sobrenomes)];
        $sob2 = $sobrenomes[$nomeIndex % count($sobrenomes)];
        $nomeIndex++;
        if ($sob1 === $sob2) {
            $sob2 = $sobrenomes[($nomeIndex + 7) % count($sobrenomes)];
        }
        $nome = "{$primeiro} {$sob1} {$sob2}";
        $status = $statusDistribuicao[$i];

        if ($status === 'L') {
            do {
                $apto = (string)(($proximaUnidadeAtiva % $aptosPorBloco) + 1);
                $bloco = $blocos[intdiv($proximaUnidadeAtiva, $aptosPorBloco) % count($blocos)];
                $proximaUnidadeAtiva++;
            } while (isset($unidadesSistema[$bloco . '-' . $apto]));
        } else {
            $apto = (string)(($i % $aptosPorBloco) + 1);
            $bloco = $blocos[intdiv($i, $aptosPorBloco) % count($blocos)];
        }

        $emailBase = slug($nome);
        $email = $emailBase . '@moradores.domusflow.test';
        while (isset($emailsUsados[$email])) {
            $sobExtra = $sobrenomes[($nomeIndex + count($emailsUsados)) % count($sobrenomes)];
            $email = slug($primeiro . ' ' . $sob1 . ' ' . $sob2 . ' ' . $sobExtra) . '@moradores.domusflow.test';
        }
        $emailsUsados[$email] = true;

        $cpf = gerarCpfValido($cpfsUsados);
        $telefone = telefoneCelular($i);
        $telefoneRecado = ($i % 5 === 0) ? telefoneFixo($i) : null;

        $stmtMorador->execute([
            $id,
            gerarUuid(),
            CryptoHelper::encrypt($nome),
            $apto,
            $bloco,
            CryptoHelper::encrypt($cpf),
            CryptoHelper::hashCpf($cpf),
            CryptoHelper::encrypt($email),
            CryptoHelper::hashEmail($email),
            CryptoHelper::encrypt($telefone),
            CryptoHelper::encrypt($telefoneRecado),
            $hash,
            $status,
            1,
            dataRelativa(-160 + ($i % 150)),
        ]);

        if ($credenciaisChave['morador'] === null && $status === 'L') {
            $credenciaisChave['morador'] = ['nome' => $nome, 'cpf' => $cpf];
        }

        $idsMoradores[] = $id;
        if ($status === 'L') $idsAtivos[] = $id;
        if ($status === 'P') $idsPendentes[] = $id;
        if ($status === 'I') $idsInativos[] = $id;
        if ($status === 'B') $idsBloqueados[] = $id;
    }

    echo "Usuários do sistema: 8\n";
    echo "Moradores: 1000 (ativos: " . count($idsAtivos) . ", pendentes: " . count($idsPendentes) . ", inativos: " . count($idsInativos) . ", bloqueados: " . count($idsBloqueados) . ")\n";

    $locais = [
        ['Salão de Festas Principal', 160, 'S'],
        ['Salão de Festas Pequeno', 70, 'S'],
        ['Churrasqueira Gourmet', 45, 'S'],
        ['Espaço Kids', 25, 'S'],
        ['Quadra Poliesportiva', 40, 'S'],
        ['Espaço Coworking', 20, 'S'],
        ['Academia', 30, 'S'],
        ['Piscina Adulto', 60, 'N'],
        ['Piscina Infantil', 25, 'N'],
        ['Sala de Jogos', 35, 'S'],
    ];
    $stmtLocal = $pdo->prepare("INSERT INTO locais_festivos (id_user_cad, local, capacidade, disp_uso) VALUES (?,?,?,?)");
    foreach ($locais as $l) {
        $stmtLocal->execute([1, $l[0], $l[1], $l[2]]);
    }
    $idsLocais = $pdo->query("SELECT id_local FROM locais_festivos ORDER BY id_local")->fetchAll(PDO::FETCH_COLUMN);

    $taxas = [
        ['Condomínio mensal', 420.00, 'A', 'Vitor Leon', '2026-01-01', 'TAXA'],
        ['Fundo de reserva', 65.00, 'A', 'Vitor Leon', '2026-01-01', 'TAXA'],
        ['Manutenção dos elevadores', 38.50, 'A', 'Vitor Leon', '2026-01-01', 'TAXA'],
        ['Limpeza das áreas comuns', 28.00, 'A', 'Vitor Leon', '2026-01-01', 'TAXA'],
        ['Pintura da garagem', 55.90, 'I', 'Vitor Leon', '2026-01-01', 'TAXA'],
        ['Multa por atraso', 85.00, 'A', 'Vitor Leon', '2026-01-01', 'MULTA'],
        ['Multa por barulho', 150.00, 'A', 'Vitor Leon', '2026-01-01', 'MULTA'],
        ['Multa por uso indevido da vaga', 120.00, 'A', 'Vitor Leon', '2026-01-01', 'MULTA'],
        ['Multa por dano em área comum', 220.00, 'A', 'Vitor Leon', '2026-01-01', 'MULTA'],
        ['Multa por descarte irregular', 95.00, 'A', 'Vitor Leon', '2026-01-01', 'MULTA'],
    ];
    $stmtTaxa = $pdo->prepare("INSERT INTO taxas_padrao (descricao, valor, status, usuario_cad, data_cad, modulo) VALUES (?,?,?,?,?,?)");
    foreach ($taxas as $t) $stmtTaxa->execute($t);

    $stmtVeiculo = $pdo->prepare("INSERT INTO veiculos (placa, marca, modelo, cor, principal, id_user, id_user_cad, created_at) VALUES (?,?,?,?,?,?,?,?)");
    $catalogoVeiculos = VeiculoCatalogo::marcasModelos();
    $marcas = array_keys($catalogoVeiculos);
    $cores = ['Preto', 'Branco', 'Prata', 'Cinza', 'Azul', 'Vermelho', 'Verde', 'Bege'];
    $placas = [];
    $veiculos = 0;
    foreach ($idsAtivos as $idx => $moradorId) {
        $qtd = ($idx % 4 === 0) ? 0 : (($idx % 5 === 0) ? 2 : 1);
        for ($v = 0; $v < $qtd; $v++) {
            $placa = sprintf('%s%s%s%d%s%d%d',
                chr(65 + (($veiculos + 3) % 26)),
                chr(65 + (($veiculos + 9) % 26)),
                chr(65 + (($veiculos + 15) % 26)),
                ($veiculos % 9) + 1,
                chr(65 + (($veiculos + 21) % 26)),
                intdiv($veiculos, 10) % 10,
                $veiculos % 10
            );
            if (isset($placas[$placa])) continue;
            $placas[$placa] = true;
            $marca = $marcas[$veiculos % count($marcas)];
            $modelos = $catalogoVeiculos[$marca];
            $modelo = $modelos[intdiv($veiculos, count($marcas)) % count($modelos)];
            $stmtVeiculo->execute([$placa, $marca, $modelo, $cores[$veiculos % count($cores)], $v === 0 ? 1 : 0, $moradorId, 7, dataRelativa(-1 - ($veiculos % 180))]);
            $veiculos++;
        }
    }

    $stmtReserva = $pdo->prepare("
        INSERT INTO reservas
            (id_local, id_user, data_reserva, hora_ini, hora_fim, status, id_user_aprov, nome_user_aprov, data_aprov, hora_aprov, created_at)
        VALUES (?,?,?,?,?,?,?,?,?,?,?)
    ");
    $horarios = [
        ['08:00:00', '12:00:00'], ['12:00:00', '17:00:00'], ['17:00:00', '21:00:00'],
        ['18:00:00', '22:00:00'], ['19:00:00', '23:00:00'],
    ];
    $statusReservas = ['A', 'A', 'A', 'P', 'P', 'N'];
    $pendentesAntigas = 0;
    $slotsReservados = [];
    for ($i = 0; $i < 1000; $i++) {
        $status = $statusReservas[$i % count($statusReservas)];
        if ($status === 'P' && $pendentesAntigas < 25) {
            $diasReserva = -($pendentesAntigas + 1);
            $pendentesAntigas++;
        } elseif ($status === 'P') {
            $diasReserva = $i % 90;
        } else {
            $diasReserva = -180 + ($i % 420);
        }
        $created = dataRelativa(min(-1, $diasReserva - 12), '14:00:00');
        $aprovado = in_array($status, ['A', 'N'], true);
        $idLocal = $idsLocais[$i % count($idsLocais)];
        $horario = $horarios[$i % count($horarios)];
        $dataReserva = (new DateTime('2026-06-06'))->modify(($diasReserva >= 0 ? '+' : '') . $diasReserva . ' days')->format('Y-m-d');

        if (in_array($status, ['A', 'P'], true)) {
            for ($tentativa = 0; $tentativa < 240; $tentativa++) {
                $chaveSlot = $idLocal . '|' . $dataReserva . '|' . $horario[0] . '|' . $horario[1];
                if (!isset($slotsReservados[$chaveSlot])) {
                    $slotsReservados[$chaveSlot] = true;
                    break;
                }

                $idLocal = $idsLocais[($i + $tentativa + 1) % count($idsLocais)];
                $horario = $horarios[($i + $tentativa + 1) % count($horarios)];
                $dataReserva = (new DateTime('2026-06-06'))->modify(($diasReserva + $tentativa + 1) . ' days')->format('Y-m-d');
            }
        }

        $stmtReserva->execute([
            $idLocal,
            $idsAtivos[$i % count($idsAtivos)],
            $dataReserva,
            $horario[0],
            $horario[1],
            $status,
            $aprovado ? (($i % 2 === 0) ? 3 : 4) : null,
            $aprovado ? (($i % 2 === 0) ? 'Vitor Leon' : 'Mariana Alves') : null,
            $aprovado ? substr(dataRelativa(min(-1, $diasReserva - 10)), 0, 10) : null,
            $aprovado ? '10:30:00' : null,
            $created,
        ]);
    }

    $stmtFatura = $pdo->prepare("INSERT INTO faturas (id_user, data, valor_total, descricao, id_user_cad, created_at) VALUES (?,?,?,?,?,?)");
    $stmtLanc = $pdo->prepare("
        INSERT INTO lancamentos (modelo, valor, descricao, id_user, data_vencimento, status, data_lancamento, id_user_cad, id_fatura)
        VALUES (?,?,?,?,?,?,?,?,?)
    ");
    $descricoesTaxa = array_values(array_filter($taxas, fn($t) => $t[5] === 'TAXA'));
    $descricoesMulta = array_values(array_filter($taxas, fn($t) => $t[5] === 'MULTA'));
    $totalLancamentos = 0;
    for ($mes = -8; $mes <= 4; $mes++) {
        $dataVenc = (new DateTime('2026-06-10'))->modify(($mes >= 0 ? '+' : '') . $mes . ' months')->format('Y-m-d');
        foreach (array_slice($idsAtivos, 0, 180) as $idx => $moradorId) {
            $taxa = $descricoesTaxa[$idx % count($descricoesTaxa)];
            $status = $mes < -1 ? 'P' : 'A';
            $idFatura = null;
            if ($status === 'P') {
                $stmtFatura->execute([$moradorId, $dataVenc, $taxa[1], 'Fatura paga - ' . $taxa[0], 1, $dataVenc]);
                $idFatura = (int)$pdo->lastInsertId();
            }
            $stmtLanc->execute([$taxa[5], $taxa[1], $taxa[0], $moradorId, $dataVenc, $status, substr(dataRelativa(-30), 0, 10), 1, $idFatura]);
            $totalLancamentos++;
        }
    }
    for ($i = 0; $i < 160; $i++) {
        $multa = $descricoesMulta[$i % count($descricoesMulta)];
        $moradorId = $idsAtivos[($i * 3) % count($idsAtivos)];
        $dataVenc = (new DateTime('2026-06-15'))->modify(($i % 60 - 30) . ' days')->format('Y-m-d');
        $status = ($i % 5 === 0) ? 'P' : 'A';
        $idFatura = null;
        if ($status === 'P') {
            $stmtFatura->execute([$moradorId, $dataVenc, $multa[1], 'Fatura paga - ' . $multa[0], 1, $dataVenc]);
            $idFatura = (int)$pdo->lastInsertId();
        }
        $stmtLanc->execute([$multa[5], $multa[1], $multa[0], $moradorId, $dataVenc, $status, substr(dataRelativa(-20), 0, 10), 1, $idFatura]);
        $totalLancamentos++;
    }

    $stmtOc = $pdo->prepare("INSERT INTO ocorrencias (id_user, categoria, titulo, descricao, status, created_at) VALUES (?,?,?,?,?,?)");
    $stmtTr = $pdo->prepare("INSERT INTO ocorrencia_tramites (id_ocorrencia, id_user_cad, nome_user_cad, status_novo, descricao, created_at) VALUES (?,?,?,?,?,?)");
    $stmtNot = $pdo->prepare("INSERT INTO ocorrencia_notificacoes (id_ocorrencia, id_user, lida, created_at) VALUES (?,?,?,?)");
    $categorias = ['MANUTENCAO', 'BARULHO / PERTURBACAO', 'SEGURANCA', 'LIMPEZA', 'AREA COMUM', 'OUTROS'];
    $titulos = ['Vazamento no corredor', 'Barulho apos horario permitido', 'Portao da garagem com falha', 'Lixo acumulado', 'Equipamento quebrado', 'Entrega extraviada'];
    $statusOc = ['A', 'E', 'R', 'C'];
    for ($i = 0; $i < 300; $i++) {
        $status = $statusOc[$i % count($statusOc)];
        $aberturaDias = -181 + ($i % 160);
        $stmtOc->execute([
            $idsAtivos[$i % count($idsAtivos)],
            $categorias[$i % count($categorias)],
            $titulos[$i % count($titulos)],
            'Ocorrência registrada pelo morador para acompanhamento da administração.',
            $status,
            dataRelativa($aberturaDias),
        ]);
        $idOc = (int)$pdo->lastInsertId();
        if (in_array($status, ['E', 'R'], true)) {
            $stmtTr->execute([$idOc, 3, 'Vitor Leon', 'E', 'Ocorrência recebida e em análise pela equipe responsável.', dataRelativa(min(-1, $aberturaDias + 3))]);
        }
        if ($status === 'R') {
            $stmtTr->execute([$idOc, 3, 'Vitor Leon', 'R', 'Problema solucionado e ocorrência encerrada.', dataRelativa(min(-1, $aberturaDias + 12))]);
        }
        if ($status === 'C') {
            $stmtTr->execute([$idOc, $idsAtivos[$i % count($idsAtivos)], 'Morador', 'C', 'Ocorrência cancelada pelo solicitante.', dataRelativa(min(-1, $aberturaDias + 2))]);
        }
        if ($status !== 'A') {
            $stmtNot->execute([$idOc, $idsAtivos[$i % count($idsAtivos)], $i % 2, dataRelativa(min(-1, $aberturaDias + 4))]);
        }
    }

    $stmtAviso = $pdo->prepare("INSERT INTO avisos (titulo, mensagem, id_user_cad, status, created_at) VALUES (?,?,?,?,?)");
    $avisosRealistas = [
        ['Manutencao preventiva dos elevadores', 'A manutencao preventiva dos elevadores dos blocos A e B ocorrera das 09h as 12h. Durante o periodo, utilize o elevador de servico quando disponivel.'],
        ['Limpeza da caixa d agua', 'A limpeza semestral da caixa d agua sera realizada nesta semana. Pode haver oscilacao no abastecimento entre 08h e 14h.'],
        ['Dedetizacao das areas comuns', 'A dedetizacao das garagens, halls e areas tecnicas ocorrera a partir das 13h. Evite circular nesses locais durante a aplicacao.'],
        ['Atualizacao do cadastro de moradores', 'Solicitamos que moradores atualizem telefone e e-mail no sistema para melhorar a comunicacao oficial do condominio.'],
        ['Obras no portao da garagem', 'O portao da garagem passara por ajustes tecnicos. A entrada e saida poderao ser realizadas com apoio da portaria.'],
        ['Uso do salao de festas', 'Reforcamos que a entrega do salao deve ocorrer limpa e organizada, conforme regulamento interno.'],
        ['Coleta seletiva', 'A coleta seletiva ocorre as tercas e quintas. Separe reciclaveis em sacos identificados e descarte no local correto.'],
        ['Teste do sistema de incendio', 'Sera realizado teste dos alarmes e sensores de incendio. O acionamento sera apenas preventivo e acompanhado pela manutencao.'],
        ['Comunicado sobre encomendas', 'Encomendas devem ser retiradas em ate 48 horas apos aviso da portaria para evitar acumulacao no espaco de recebimento.'],
        ['Pintura das vagas de garagem', 'A pintura de demarcacao das vagas sera feita por etapas. Fique atento aos avisos de remanejamento temporario.'],
        ['Regras de silencio', 'Lembramos que o horario de silencio deve ser respeitado entre 22h e 08h, inclusive em areas comuns.'],
        ['Treinamento da equipe de portaria', 'A equipe de portaria participara de treinamento interno. O atendimento seguira normalmente, com apoio do sindico.'],
    ];
    for ($i = 1; $i <= 12; $i++) {
        $aviso = $avisosRealistas[($i - 1) % count($avisosRealistas)];
        $stmtAviso->execute([
            $aviso[0],
            $aviso[1],
            ($i % 2 === 0) ? 3 : 4,
            'A',
            dataRelativa(-20 + $i),
        ]);
    }

    $stmtAss = $pdo->prepare("INSERT INTO assembleias (titulo, data, hora, local, pauta, id_user_cad, status, created_at) VALUES (?,?,?,?,?,?,?,?)");
    $stmtPres = $pdo->prepare("INSERT INTO assembleias_presencas (id_assembleia, id_user, presenca, created_at) VALUES (?,?,?,?)");
    $assembleiasRealistas = [
        ['Assembleia ordinaria de prestacao de contas', 'Analise das receitas e despesas do periodo, apresentacao de inadimplencia e aprovacao das contas.', 'Salao de Festas Principal', '19:30:00', -5],
        ['Assembleia para previsao orcamentaria', 'Discussao da previsao orcamentaria, reajuste condominial e contratos de manutencao.', 'Salao de Festas Principal', '19:00:00', -3],
        ['Assembleia sobre seguranca patrimonial', 'Avaliacao de cameras, controle de acesso, portaria e procedimentos para visitantes.', 'Espaco Coworking', '20:00:00', -1],
        ['Assembleia extraordinaria sobre garagem', 'Organizacao de vagas, circulacao, cadastro de veiculos e regras para visitantes.', 'Sala de Jogos', '19:30:00', 10],
        ['Assembleia sobre obras e melhorias', 'Priorizacao de manutencoes, pintura, elevadores e melhorias nas areas comuns.', 'Salao de Festas Principal', '19:30:00', 24],
        ['Assembleia de convivencia e regulamento interno', 'Revisao de regras de silencio, uso do salao, animais, encomendas e areas comuns.', 'Espaco Coworking', '20:00:00', 45],
        ['Assembleia para fundo de reserva', 'Definicao de metas do fundo de reserva e planejamento para despesas extraordinarias.', 'Salao de Festas Pequeno', '19:00:00', 75],
        ['Assembleia anual de planejamento condominial', 'Planejamento anual, calendario de manutencoes, contratos e prioridades da administracao.', 'Salao de Festas Principal', '19:30:00', 110],
    ];
    foreach ($assembleiasRealistas as $i => $assembleia) {
        $data = (new DateTime('2026-06-06'))->modify(($assembleia[4] >= 0 ? '+' : '') . $assembleia[4] . ' days')->format('Y-m-d');
        $stmtAss->execute([
            $assembleia[0],
            $data,
            $assembleia[3],
            $assembleia[2],
            $assembleia[1],
            3,
            ($i === 1) ? 'I' : 'A',
            $data . ' 10:00:00',
        ]);
        $idAss = (int)$pdo->lastInsertId();
        foreach (array_slice($idsAtivos, 0, 240) as $idx => $moradorId) {
            $presenca = ($idx % 5 === 0) ? 'N' : (($idx % 3 === 0) ? 'P' : 'S');
            $stmtPres->execute([$idAss, $moradorId, $presenca, $data . ' 20:00:00']);
        }
    }

    $stmtAudit = $pdo->prepare("INSERT INTO auditoria (id_user, acao, entidade, entidade_id, descricao, ip, created_at) VALUES (?,?,?,?,?,?,?)");
    $acoes = ['VISUALIZAR_CPF', 'ALTERAR_STATUS', 'ALTERAR_PRIVILEGIO', 'ACEITAR_CADASTRO', 'RECUSAR_CADASTRO', 'ALTERAR_UNIDADE'];
    for ($i = 0; $i < 150; $i++) {
        $stmtAudit->execute([
            ($i % 2 === 0) ? 1 : 3,
            $acoes[$i % count($acoes)],
            'morador',
            $idsMoradores[$i % count($idsMoradores)],
            'Registro de auditoria gerado pelo seed para demonstracao LGPD.',
            '127.0.0.1',
            dataRelativa(-60 + ($i % 50)),
        ]);
    }

    $pdo->commit();

    echo "Locais: " . count($idsLocais) . "\n";
    echo "Veículos: {$veiculos}\n";
    echo "Reservas: 1000\n";
    echo "Lancamentos financeiros: {$totalLancamentos}\n";
    echo "Ocorrências: 300\n";
    echo "Avisos: 12\n";
    echo "Assembleias: 8\n";
    echo "Auditoria: 150\n";
    echo "\nSeed concluído com sucesso.\n";
    echo "\nUsuários-chave para login:\n";
    echo "Admin: {$credenciaisChave['admin']['nome']} | CPF: {$credenciaisChave['admin']['cpf']} | Senha: {$senhaPadrao}\n";
    echo "Síndico: {$credenciaisChave['sindico']['nome']} | CPF: {$credenciaisChave['sindico']['cpf']} | Senha: {$senhaPadrao}\n";
    echo "Porteiro: {$credenciaisChave['porteiro']['nome']} | CPF: {$credenciaisChave['porteiro']['cpf']} | Senha: {$senhaPadrao}\n";
    echo "Morador: {$credenciaisChave['morador']['nome']} | CPF: {$credenciaisChave['morador']['cpf']} | Senha: {$senhaPadrao}\n";
    echo "</pre>";
} catch (Throwable $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    if (isset($pdo)) {
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    }
    echo "<pre style='color:red'>Erro no seed: " . htmlspecialchars($e->getMessage()) . "</pre>";
}
