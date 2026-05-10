<?php

/**
 * DomusFlow — Seed de dados
 *
 * Execute UMA VEZ após importar domusflow_bd_prod.sql:
 *   http://localhost/Domusflow-Sistema-de-Gerenciamento-de-Condominio/database/seed.php
 *
 *  APAGUE este arquivo após executar!
 */

require_once __DIR__ . '/../../config/database.php';

set_time_limit(120);

try {
    $pdo = getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    $senha_padrao = '123456';
    $hash         = password_hash($senha_padrao, PASSWORD_BCRYPT);

    echo "<pre>";
    echo "Hash bcrypt gerado com sucesso.\n";
    echo "Senha padrão: <strong>{$senha_padrao}</strong>\n\n";

    // ── 1. USUÁRIOS DO SISTEMA (admin, síndico, porteiros) ──────────────────
    $sistema = [
        [1, 1, 'Admin Root',       '00', '0', '00000000000', 'admin@domusflow.com',    '(11) 00000-0000', null,              'M', $hash, 'L', 4],
        [2, 1, 'Vitor Leon',       '10', '1', '43209957835', 'sindico@domusflow.com',  '(11) 98522-9900', '(11) 95907-3260', 'M', $hash, 'L', 2],
        [3, 1, 'Porteiro Padrão',  '00', '0', '11111111111', 'porteiro@domusflow.com', '(11) 00000-0001', null,              'M', $hash, 'L', 3],
        [4, 1, 'Porteiro Carlos',  '00', '0', '22222222222', 'porteiro2@domusflow.com', '(11) 00000-0002', null,              'M', $hash, 'L', 3],
    ];

    $stmt = $pdo->prepare("
        INSERT INTO morador
          (id_user, identificador, nome, apto, bloco, cpf, email, telefone, tell_recado, sexo, senha, status, previlegio)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");
    foreach ($sistema as $u) {
        $stmt->execute($u);
    }
    echo "✔ Usuários do sistema inseridos: " . count($sistema) . "\n";

    // ── 2. MORADORES (1000 registros únicos) ────────────────────────────────
    $nomes_m = [
        'Carlos',
        'João',
        'Pedro',
        'Lucas',
        'Marcos',
        'Rafael',
        'Bruno',
        'Felipe',
        'Thiago',
        'Diego',
        'André',
        'Gustavo',
        'Ricardo',
        'Leandro',
        'Fernando',
        'Rodrigo',
        'Fabian',
        'Henrique',
        'Vinicius',
        'Eduardo',
        'Alexandre',
        'Mateus',
        'Leonardo',
        'Caio',
        'Renato',
        'Daniel',
        'Julio',
        'Sergio',
        'Paulo',
        'Nelson',
        'Roberto',
        'Felipe',
        'Guilherme',
        'Marcelo',
        'Antônio',
        'Jorge',
        'Wagner',
        'Patrick',
        'Samuel',
        'Davi'
    ];

    $nomes_f = [
        'Ana',
        'Maria',
        'Carla',
        'Juliana',
        'Fernanda',
        'Patricia',
        'Amanda',
        'Camila',
        'Isabela',
        'Leticia',
        'Gabriela',
        'Beatriz',
        'Larissa',
        'Natalia',
        'Priscila',
        'Tatiana',
        'Vanessa',
        'Renata',
        'Luciana',
        'Aline',
        'Bruna',
        'Debora',
        'Fabiana',
        'Livia',
        'Paula',
        'Claudia',
        'Mariana',
        'Simone',
        'Viviane',
        'Helena',
        'Monica',
        'Cristiane',
        'Elaine',
        'Silvia',
        'Adriana',
        'Daniela',
        'Raquel',
        'Sabrina',
        'Tania',
        'Vera'
    ];

    $sobrenomes = [
        'Silva',
        'Oliveira',
        'Souza',
        'Costa',
        'Pereira',
        'Rodrigues',
        'Alves',
        'Ferreira',
        'Gomes',
        'Martins',
        'Barbosa',
        'Ribeiro',
        'Carvalho',
        'Dias',
        'Rocha',
        'Teixeira',
        'Moreira',
        'Batista',
        'Freitas',
        'Mendes',
        'Lima',
        'Cardoso',
        'Nogueira',
        'Monteiro',
        'Correia',
        'Farias',
        'Duarte',
        'Peixoto',
        'Queiroz',
        'Moura',
        'Neves',
        'Sales',
        'Campos',
        'Rezende',
        'Borges',
        'Amaral',
        'Cunha',
        'Vieira',
        'Pinto',
        'Araújo'
    ];

    $blocos = ['A', 'B', 'C', 'D', 'E'];
    $status_opts = ['L', 'L', 'L', 'L', 'L', 'L', 'L', 'P', 'P', 'B']; // 70% livre, 20% pendente, 10% bloqueado

    $stmt_m = $pdo->prepare("
        INSERT INTO morador
          (identificador, nome, apto, bloco, cpf, email, telefone, tell_recado, sexo, senha, status, previlegio)
        VALUES (1,?,?,?,?,?,?,?,?,?,?,1)
    ");

    $nomes_usados  = [];
    $cpfs_usados   = ['00000000000', '43209957835', '11111111111', '22222222222'];
    $emails_usados = ['admin@domusflow.com', 'sindico@domusflow.com', 'porteiro@domusflow.com', 'porteiro2@domusflow.com'];

    $inseridos = 0;
    $id_morador = 5;
    $tentativas = 0;

    while ($inseridos < 1000 && $tentativas < 5000) {
        $tentativas++;
        $sexo = ($inseridos % 2 === 0) ? 'M' : 'F';
        $lista_nomes = ($sexo === 'M') ? $nomes_m : $nomes_f;

        $nome_idx  = ($inseridos % count($lista_nomes));
        $sob1_idx  = (intdiv($inseridos, 3)  % count($sobrenomes));
        $sob2_idx  = (intdiv($inseridos, 7)  % count($sobrenomes));

        $primeiro  = $lista_nomes[$nome_idx];
        $sob1      = $sobrenomes[$sob1_idx];
        $sob2      = $sobrenomes[$sob2_idx];
        $nome      = "{$primeiro} {$sob1} {$sob2}";

        if (in_array($nome, $nomes_usados)) {
            $nome = "{$primeiro} {$sob1} {$sob2} " . ($inseridos + 1);
        }

        $bloco = $blocos[$inseridos % 5];
        $apto  = (($inseridos % 200) + 1);
        $cpf   = str_pad(mt_rand(10000000000, 99999999999), 11, '0', STR_PAD_LEFT);

        if (in_array($cpf, $cpfs_usados)) continue;

        $email = strtolower(
            preg_replace('/[^a-z0-9]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $primeiro)) .
                strtolower(preg_replace('/[^a-z0-9]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $sob1))) .
                ($id_morador) . '@email.com'
        );

        if (in_array($email, $emails_usados)) continue;

        $tel = '(11) 9' . str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
        $tel_rec = ($inseridos % 4 === 0)
            ? '(11) 3' . str_pad(mt_rand(1000000, 9999999), 7, '0', STR_PAD_LEFT)
            : null;

        $status = $status_opts[$inseridos % 10];

        $stmt_m->execute([$nome, (string)$apto, $bloco, $cpf, $email, $tel, $tel_rec, $sexo, $hash, $status]);

        $nomes_usados[]  = $nome;
        $cpfs_usados[]   = $cpf;
        $emails_usados[] = $email;
        $inseridos++;
        $id_morador++;
    }

    echo "✔ Moradores inseridos: {$inseridos}\n";

    // busca os ids dos moradores (excluindo sistema)
    $ids_moradores = $pdo->query("SELECT id_user FROM morador WHERE previlegio = 1 ORDER BY id_user")->fetchAll(PDO::FETCH_COLUMN);

    // ── 3. LOCAIS FESTIVOS (6 locais) ───────────────────────────────────────
    $locais = [
        [1, 'Churrasqueira',           100, 'S'],
        [1, 'Salão de Festas Pequeno',  50, 'S'],
        [1, 'Salão de Festas Grande',  150, 'S'],
        [1, 'Parquinho de Diversão',    15, 'N'],
        [1, 'Quadra Poliesportiva',     40, 'S'],
        [1, 'Espaço Gourmet',           30, 'S'],
    ];

    $stmt_l = $pdo->prepare("INSERT INTO locais_festivos (id_user_cad, local, capacidade, disp_uso) VALUES (?,?,?,?)");
    foreach ($locais as $l) {
        $stmt_l->execute($l);
    }
    $id_locais = $pdo->query("SELECT id_local FROM locais_festivos ORDER BY id_local")->fetchAll(PDO::FETCH_COLUMN);
    echo "✔ Locais festivos inseridos: " . count($locais) . "\n";

    // ── 4. VEÍCULOS (1000 registros) ────────────────────────────────────────
    $marcas = [
        'Fiat'       => ['Uno', 'Argo', 'Pulse', 'Strada', 'Toro', 'Cronos'],
        'Volkswagen' => ['Gol', 'Polo', 'Virtus', 'Nivus', 'T-Cross', 'Tiguan'],
        'Chevrolet'  => ['Onix', 'Tracker', 'Cruze', 'S10', 'Spin', 'Montana'],
        'Toyota'     => ['Corolla', 'Yaris', 'Hilux', 'SW4', 'RAV4', 'Prius'],
        'Honda'      => ['Fit', 'Civic', 'HR-V', 'WR-V', 'City', 'CR-V'],
        'Hyundai'    => ['HB20', 'Creta', 'Tucson', 'i30', 'Santa Fe', 'Azera'],
        'Renault'    => ['Kwid', 'Sandero', 'Logan', 'Duster', 'Captur', 'Zoe'],
        'Jeep'       => ['Renegade', 'Compass', 'Commander', 'Wrangler', 'Cherokee', 'Grand Cherokee'],
        'Ford'       => ['Ka', 'EcoSport', 'Ranger', 'Bronco', 'Maverick', 'Territory'],
        'Nissan'     => ['Kicks', 'Versa', 'Frontier', 'Sentra', 'March', 'Leaf'],
        'Peugeot'    => ['208', '2008', '3008', '5008', 'Partner', 'Expert'],
        'BMW'        => ['320i', '530i', 'X1', 'X3', 'X5', 'M3'],
        'Mercedes'   => ['C180', 'C200', 'GLA', 'GLC', 'A200', 'E300'],
        'Mitsubishi' => ['Outlander', 'Eclipse Cross', 'L200', 'ASX', 'Pajero', 'Space Star'],
        'Audi'       => ['A3', 'A4', 'Q3', 'Q5', 'Q7', 'TT'],
    ];
    $cores = ['Preto', 'Branco', 'Prata', 'Cinza', 'Azul', 'Vermelho', 'Verde', 'Dourado', 'Bege', 'Laranja', 'Vinho', 'Marrom'];

    $marcas_list  = array_keys($marcas);
    $placas_usadas = [];

    $stmt_v = $pdo->prepare("
        INSERT INTO veiculos (placa, marca, modelo, cor, principal, id_user, id_user_cad)
        VALUES (?,?,?,?,?,?,?)
    ");

    $veiculos_inseridos = 0;
    $total_ids = count($ids_moradores);
    // distribuir ~1 veículo por morador, alguns terão 2
    $i = 0;
    while ($veiculos_inseridos < 1000) {
        $id_user = $ids_moradores[$i % $total_ids];
        $marca   = $marcas_list[$veiculos_inseridos % count($marcas_list)];
        $modelos = $marcas[$marca];
        $modelo  = $modelos[$veiculos_inseridos % count($modelos)];
        $cor     = $cores[$veiculos_inseridos % count($cores)];
        $principal = ($veiculos_inseridos % 7 !== 0) ? 1 : 0;

        // gerar placa no padrão Mercosul (ABC1D23) ou antigo (ABC1234) alternado
        $tentativas_placa = 0;
        do {
            if ($veiculos_inseridos % 2 === 0) {
                $placa = chr(65 + rand(0, 25)) . chr(65 + rand(0, 25)) . chr(65 + rand(0, 25))
                    . rand(1, 9)
                    . chr(65 + rand(0, 25))
                    . rand(0, 9) . rand(0, 9);
            } else {
                $placa = chr(65 + rand(0, 25)) . chr(65 + rand(0, 25)) . chr(65 + rand(0, 25))
                    . rand(1000, 9999);
            }
            $tentativas_placa++;
        } while (in_array($placa, $placas_usadas) && $tentativas_placa < 100);

        if (in_array($placa, $placas_usadas)) {
            $i++;
            continue;
        }

        $stmt_v->execute([$placa, $marca, $modelo, $cor, $principal, $id_user, 2]);
        $placas_usadas[] = $placa;
        $veiculos_inseridos++;
        $i++;
    }
    echo "✔ Veículos inseridos: {$veiculos_inseridos}\n";

    // ── 5. RESERVAS (1000 registros) ────────────────────────────────────────
    $horas = [
        ['08:00:00', '12:00:00'],
        ['12:00:00', '17:00:00'],
        ['17:00:00', '21:00:00'],
        ['18:00:00', '22:00:00'],
        ['19:00:00', '23:00:00'],
        ['20:00:00', '23:59:00'],
    ];
    $status_res = ['A', 'A', 'A', 'P', 'P', 'N']; // 50% aprovada, 33% pendente, 17% negada

    $stmt_r = $pdo->prepare("
        INSERT INTO reservas
          (id_local, id_user, data_reserva, hora_ini, hora_fim, status,
           id_user_aprov, nome_user_aprov, data_aprov, hora_aprov)
        VALUES (?,?,?,?,?,?,?,?,?,?)
    ");

    $base_date = new DateTime('2026-01-01');
    for ($r = 0; $r < 1000; $r++) {
        $id_local  = $id_locais[$r % count($id_locais)];
        $id_user   = $ids_moradores[$r % $total_ids];
        $data_res  = (clone $base_date)->modify("+{$r} day")->format('Y-m-d');
        $hora_pair = $horas[$r % count($horas)];
        $status_r  = $status_res[$r % count($status_res)];

        $aprov_id   = null;
        $aprov_nome = null;
        $aprov_data = null;
        $aprov_hora = null;

        if ($status_r === 'A') {
            $aprov_id   = 2;
            $aprov_nome = 'Vitor Leon';
            $aprov_data = (clone $base_date)->modify("+{$r} day")->modify('-1 day')->format('Y-m-d');
            $aprov_hora = '10:00:00';
        }

        $stmt_r->execute([
            $id_local,
            $id_user,
            $data_res,
            $hora_pair[0],
            $hora_pair[1],
            $status_r,
            $aprov_id,
            $aprov_nome,
            $aprov_data,
            $aprov_hora
        ]);
    }
    echo "✔ Reservas inseridas: 1000\n";

    // ── 6. TAXAS PADRÃO ─────────────────────────────────────────────────────
    $taxas = [
        ['Taxa de Condomínio',        350.00, 'A', 'Vitor Leon', '2026-01-01', 'TAXA'],
        ['Taxa de Limpeza',            25.00, 'A', 'Vitor Leon', '2026-01-01', 'TAXA'],
        ['Taxa de Manutenção',         45.00, 'A', 'Vitor Leon', '2026-01-01', 'TAXA'],
        ['Limpeza da Piscina',          5.99, 'A', 'Vitor Leon', '2026-01-01', 'TAXA'],
        ['Taxa da Quadra',             55.00, 'A', 'Vitor Leon', '2026-01-01', 'TAXA'],
        ['Playground',                  2.69, 'A', 'Vitor Leon', '2026-01-01', 'TAXA'],
        ['Taxa do Porteiro',            5.60, 'A', 'Vitor Leon', '2026-01-01', 'MULTA'],
        ['Multa por Barulho',          80.00, 'A', 'Vitor Leon', '2026-01-01', 'MULTA'],
        ['Multa por Inadimplência',   150.00, 'A', 'Vitor Leon', '2026-01-01', 'MULTA'],
        ['Taxa para Pintura',          15.99, 'I', 'Vitor Leon', '2026-01-01', 'MULTA'],
    ];

    $stmt_t = $pdo->prepare("INSERT INTO taxas_padrao (descricao, valor, status, usuario_cad, data_cad, modulo) VALUES (?,?,?,?,?,?)");
    foreach ($taxas as $t) {
        $stmt_t->execute($t);
    }
    echo "✔ Taxas padrão inseridas: " . count($taxas) . "\n";

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");


    // ── 7. OCORRÊNCIAS (50 registros) ─────────────────────────────────────────
    $categorias_oc = [
        'MANUTENÇÃO',
        'BARULHO / PERTURBAÇÃO',
        'SEGURANÇA',
        'LIMPEZA',
        'ÁREA COMUM',
        'OUTROS',
    ];

    $titulos_oc = [
        'MANUTENÇÃO'            => ['VAZAMENTO NO CORREDOR DO 3º ANDAR', 'LÂMPADA QUEIMADA NA ESCADA', 'PORTA DO ELEVADOR COM DEFEITO', 'INFILTRAÇÃO NO TETO DA GARAGEM', 'INTERFONE COM DEFEITO'],
        'BARULHO / PERTURBAÇÃO' => ['BARULHO EXCESSIVO APÓS 22H', 'MÚSICA ALTA NO APARTAMENTO 204', 'OBRAS SEM AVISO PRÉVIO', 'BRIGA NO CORREDOR', 'ANIMAL LATINDO DE MADRUGADA'],
        'SEGURANÇA'             => ['CÂMERA DO HALL DESLIGADA', 'PORTÃO DA GARAGEM NÃO FECHA', 'PESSOA ESTRANHA NAS DEPENDÊNCIAS', 'ILUMINAÇÃO EXTERNA APAGADA', 'FECHADURA DA PORTA DE SERVIÇO QUEBRADA'],
        'LIMPEZA'               => ['LIXO ACUMULADO NO CORREDOR', 'MATO ALTO NO JARDIM', 'PISCINA COM ÁGUA VERDE', 'BANHEIRO DA ACADEMIA SUJO', 'ODOR NO HALL DO ELEVADOR'],
        'ÁREA COMUM'            => ['EQUIPAMENTO DA ACADEMIA QUEBRADO', 'CHURRASQUEIRA COM PROBLEMA', 'BANCO DO JARDIM QUEBRADO', 'TORNEIRA DO SALÃO VAZANDO', 'TELÃO DO SALÃO SEM FUNCIONAR'],
        'OUTROS'                => ['CAIXA DE CORREIO DANIFICADA', 'BICICLETA ABANDONADA NO CORREDOR', 'RECLAMAÇÃO SOBRE ESTACIONAMENTO', 'PROBLEMA COM ENTREGA DE ENCOMENDA', 'OUTRO ASSUNTO DIVERSO'],
    ];

    $status_oc  = ['A', 'A', 'E', 'R', 'C']; // 40% aberto, 20% andamento, 20% resolvido, 20% cancelado
    $base_oc    = new DateTime('2026-01-15');

    $stmt_oc = $pdo->prepare("
    INSERT INTO ocorrencias (id_user, categoria, titulo, descricao, status, created_at)
    VALUES (?,?,?,?,?,?)
");

    $oc_ids = [];
    for ($o = 0; $o < 50; $o++) {
        $id_user   = $ids_moradores[$o % $total_ids];
        $cat       = $categorias_oc[$o % count($categorias_oc)];
        $titulo    = $titulos_oc[$cat][$o % count($titulos_oc[$cat])];
        $descricao = 'OCORRÊNCIA REGISTRADA PELO MORADOR: ' . $titulo . '. FAVOR VERIFICAR E TOMAR AS DEVIDAS PROVIDÊNCIAS.';
        $status    = $status_oc[$o % count($status_oc)];
        $created   = (clone $base_oc)->modify("+{$o} day")->format('Y-m-d H:i:s');

        $stmt_oc->execute([$id_user, $cat, $titulo, $descricao, $status, $created]);
        $oc_ids[] = $pdo->lastInsertId();
    }
    echo "✔ Ocorrências inseridas: " . count($oc_ids) . "\n";

    // ── 8. TRAMITAÇÕES (para ocorrências E, R e C) ────────────────────────────
    $stmt_tr = $pdo->prepare("
    INSERT INTO ocorrencia_tramites (id_ocorrencia, id_user_cad, nome_user_cad, status_novo, descricao, created_at)
    VALUES (?,?,?,?,?,?)
");

    $stmt_oc_status = $pdo->query("SELECT id_ocorrencia, status, created_at FROM ocorrencias ORDER BY id_ocorrencia");
    $todas_oc = $stmt_oc_status->fetchAll(PDO::FETCH_ASSOC);

    $tramites_inseridos = 0;
    foreach ($todas_oc as $oc) {
        $id_oc      = $oc['id_ocorrencia'];
        $status_oc  = $oc['status'];
        $data_base  = new DateTime($oc['created_at']);

        if ($status_oc === 'E') {
            // 1 tramitação: Aberto → Em Andamento
            $stmt_tr->execute([
                $id_oc,
                2,
                'Vitor Leon',
                'E',
                'OCORRÊNCIA RECEBIDA E EM ANÁLISE. PROVIDÊNCIAS SENDO TOMADAS.',
                (clone $data_base)->modify('+1 day')->format('Y-m-d H:i:s')
            ]);
            $tramites_inseridos++;
        }

        if ($status_oc === 'R') {
            // 2 tramitações: Aberto → Em Andamento → Resolvido
            $stmt_tr->execute([
                $id_oc,
                2,
                'Vitor Leon',
                'E',
                'OCORRÊNCIA RECEBIDA. INICIANDO TRATATIVA COM A EQUIPE DE MANUTENÇÃO.',
                (clone $data_base)->modify('+1 day')->format('Y-m-d H:i:s')
            ]);
            $stmt_tr->execute([
                $id_oc,
                2,
                'Vitor Leon',
                'R',
                'PROBLEMA SOLUCIONADO. SERVIÇO CONCLUÍDO PELA EQUIPE RESPONSÁVEL.',
                (clone $data_base)->modify('+3 days')->format('Y-m-d H:i:s')
            ]);
            $tramites_inseridos += 2;
        }

        if ($status_oc === 'C') {
            // 1 tramitação: cancelamento pelo próprio morador
            $stmt_tr->execute([
                $id_oc,
                $ids_moradores[0],
                'Morador',
                'C',
                'OCORRÊNCIA CANCELADA PELO SOLICITANTE.',
                (clone $data_base)->modify('+1 day')->format('Y-m-d H:i:s')
            ]);
            $tramites_inseridos++;
        }
    }
    echo "✔ Tramitações inseridas: {$tramites_inseridos}\n";

    // ── 9. NOTIFICAÇÕES (para ocorrências com tramitação) ─────────────────────
    $stmt_noti = $pdo->prepare("
    INSERT INTO ocorrencia_notificacoes (id_ocorrencia, id_user, lida, created_at)
    VALUES (?,?,0,?)
");

    $stmt_com_tramite = $pdo->query("
    SELECT DISTINCT o.id_ocorrencia, o.id_user, MIN(t.created_at) as data_tramite
    FROM ocorrencias o
    INNER JOIN ocorrencia_tramites t ON t.id_ocorrencia = o.id_ocorrencia
    GROUP BY o.id_ocorrencia, o.id_user
");

    $notis = $stmt_com_tramite->fetchAll(PDO::FETCH_ASSOC);
    $notis_inseridas = 0;
    foreach ($notis as $n) {
        $stmt_noti->execute([$n['id_ocorrencia'], $n['id_user'], $n['data_tramite']]);
        $notis_inseridas++;
    }
    echo "✔ Notificações inseridas: {$notis_inseridas}\n";

    // ── Confirmação (SEED APLICADO) ─────────────────────────────────────────

    echo "\n<strong style='color:green'>✔ Seed concluído com sucesso!</strong>\n";
    echo "Senha padrão de todos os usuários: <strong>{$senha_padrao}</strong>\n";
    echo "<p style='color:red; font-weight:bold; margin-top:16px'>⚠️  APAGUE este arquivo agora!</p>";
    echo "</pre>";
} catch (Exception $e) {
    echo "<pre style='color:red'>Erro: " . $e->getMessage() . "</pre>";
}
