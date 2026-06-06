<?php

require_once __DIR__ . '/../helpers/CryptoHelper.php';

class MoradorRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM morador WHERE id_user = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $this->descriptografarMorador($stmt->fetch() ?: null);
    }

    public function findByUuid(string $uuid): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM morador WHERE uuid = :uuid LIMIT 1");
        $stmt->execute([':uuid' => $uuid]);
        return $this->descriptografarMorador($stmt->fetch() ?: null);
    }

    public function findAtivos(): array
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM morador WHERE status = 'L' AND privilegio = 1 ORDER BY nome ASC"
        );
        return $this->descriptografarLista($stmt->fetchAll());
    }

    public function findTodos(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM morador WHERE status != 'B' ORDER BY nome ASC");
        return $this->descriptografarLista($stmt->fetchAll());
    }

    public function findByCpf(string $cpf): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM morador WHERE cpf_hash = :cpf_hash LIMIT 1");
        $stmt->execute([':cpf_hash' => CryptoHelper::hashCpf($cpf)]);
        return $this->descriptografarMorador($stmt->fetch() ?: null);
    }

    public function existeCpf(string $cpf): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM morador WHERE cpf_hash = :cpf_hash");
        $stmt->execute([':cpf_hash' => CryptoHelper::hashCpf($cpf)]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function existeEmail(string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM morador WHERE email_hash = :email_hash");
        $stmt->execute([':email_hash' => CryptoHelper::hashEmail($email)]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function existeEmailParaOutro(string $email, int $idAtual): bool{
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM morador WHERE email_hash = :email_hash AND id_user != :id");
        $stmt->execute([':email_hash' => CryptoHelper::hashEmail($email), ':id' => $idAtual]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function existeMoradorAtivoNaUnidade(string $apto, string $bloco, int $ignorarId = 0): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM morador
            WHERE status = 'L'
              AND privilegio IN (1, 2)
              AND apto = :apto
              AND bloco = :bloco
              AND id_user != :ignorar_id
        ");
        $stmt->execute([
            ':apto'       => $apto,
            ':bloco'      => $bloco,
            ':ignorar_id' => $ignorarId,
        ]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function findPendentes(): array
    {
        $stmt = $this->pdo->query("
            SELECT id_user, uuid, nome, apto, bloco, cpf, created_at
            FROM morador
            WHERE status = 'P'
            ORDER BY nome ASC
        ");
        return $this->descriptografarLista($stmt->fetchAll());
    }

    public function findPendentesComFiltros(array $filtros, int $limit, int $offset): array
    {
        $sql = "
            SELECT id_user, uuid, nome, apto, bloco, cpf, created_at, privilegio
            FROM morador
            WHERE status = 'P'
        ";

        $params = $this->montarFiltrosPendentes($filtros);
        $sql   .= $params['sql'];

        $colunasPermitidas = [
            'nome'  => 'nome',
            'cpf'   => 'nome',
            'bloco' => 'bloco',
        ];

        $ordenar = $colunasPermitidas[$filtros['ordenar'] ?? 'nome'] ?? 'nome';
        $direcao = strtolower($filtros['direcao'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

        $sql .= " ORDER BY {$ordenar} {$direcao} LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params['bindings'] as $chave => $valor) {
            $stmt->bindValue($chave, $valor);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $this->descriptografarLista($stmt->fetchAll());
    }

    public function countPendentesComFiltros(array $filtros): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM morador
            WHERE status = 'P'
        ";

        $params = $this->montarFiltrosPendentes($filtros);
        $sql   .= $params['sql'];

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params['bindings']);

        return (int)$stmt->fetchColumn();
    }

    private function montarFiltrosPendentes(array $filtros): array
    {
        $sql      = '';
        $bindings = [];

        if (!empty($filtros['nome'])) {
            $sql .= ' AND nome LIKE :nome';
            $bindings[':nome'] = '%' . $filtros['nome'] . '%';
        }
        if (!empty($filtros['bloco'])) {
            $sql .= ' AND bloco LIKE :bloco';
            $bindings[':bloco'] = '%' . $filtros['bloco'] . '%';
        }
        if (!empty($filtros['apto'])) {
            $sql .= ' AND apto LIKE :apto';
            $bindings[':apto'] = '%' . $filtros['apto'] . '%';
        }
        if (!empty($filtros['cpf'])) {
            $cpf = preg_replace('/\D/', '', $filtros['cpf']);
            $sql .= strlen($cpf) === 11 ? ' AND cpf_hash = :cpf_hash' : ' AND 1 = 0';
            if (strlen($cpf) === 11) {
                $bindings[':cpf_hash'] = CryptoHelper::hashCpf($cpf);
            }
        }
        if (!empty($filtros['data_solicitacao'])) {
            $sql .= ' AND DATE(created_at) = :data_solicitacao';
            $bindings[':data_solicitacao'] = $filtros['data_solicitacao'];
        }

        if (isset($filtros['perfil']) && $filtros['perfil'] !== '') {
            $sql .= ' AND privilegio = :perfil';
            $bindings[':perfil'] = (int) $filtros['perfil'];
        }

        return ['sql' => $sql, 'bindings' => $bindings];
    }

    public function save(array $data): int|bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO morador
                (uuid, nome, apto, bloco, cpf, cpf_hash, email, email_hash, telefone, tell_recado, senha, status, privilegio)
             VALUES
                (:uuid, :nome, :apto, :bloco, :cpf, :cpf_hash, :email, :email_hash, :cell, :recado, :senha, :status, :privilegio)"
        );

        $sucesso = $stmt->execute([
            ':uuid'   => self::gerarUuid(),
            ':nome'   => $data['nome'],
            ':apto'   => $data['apto'],
            ':bloco'  => $data['bloco'],
            ':cpf'    => CryptoHelper::encrypt($data['cpf']),
            ':cpf_hash' => CryptoHelper::hashCpf($data['cpf']),
            ':email'  => CryptoHelper::encrypt($data['email']),
            ':email_hash' => CryptoHelper::hashEmail($data['email']),
            ':cell'   => CryptoHelper::encrypt($data['telefone']),
            ':recado' => CryptoHelper::encrypt($data['telefone_recado'] ?? null),
            ':senha'  => $data['senha'],
            ':status' => 'P',
            ':privilegio' => (int) ($data['privilegio'] ?? 1),
        ]);

        if ($sucesso) {
            return (int)$this->pdo->lastInsertId();
        }

        return false;
    }

    public function atualizarStatus(int $id, string $status): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE morador SET status = :status WHERE id_user = :id"
        );
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }

    public function getStatus(int $id): ?string
    {
        $stmt = $this->pdo->prepare(
            "SELECT status FROM morador WHERE id_user = :id LIMIT 1"
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ? $row['status'] : null;
    }

    public function countByStatus(string $status): int
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM morador WHERE status = :status"
        );
        $stmt->execute([':status' => $status]);
        return (int)$stmt->fetchColumn();
    }

    public function countMoradoresAtivos(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM morador WHERE status = 'L' AND privilegio = 1");
        return (int)$stmt->fetchColumn();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM morador ORDER BY nome ASC");
        return $this->descriptografarLista($stmt->fetchAll());
    }

    public function atualizarDados(array $update): bool
    {
        $params = [
            ':nome'        => $update['nome'],
            ':email'       => CryptoHelper::encrypt($update['email']),
            ':email_hash'  => CryptoHelper::hashEmail($update['email']),
            ':apto'        => $update['apto'],
            ':bloco'       => $update['bloco'],
            ':telefone'    => CryptoHelper::encrypt($update['telefone']),
            ':tell_recado' => CryptoHelper::encrypt($update['tell_recado']),
            ':id'          => $update['id'],
        ];

        if (empty($update['senha'])) {
            $sql = "UPDATE morador
                    SET nome = :nome, email = :email, email_hash = :email_hash, apto = :apto, bloco = :bloco,
                        telefone = :telefone, tell_recado = :tell_recado
                    WHERE id_user = :id";
        } else {
            $sql = "UPDATE morador
                    SET nome = :nome, email = :email, email_hash = :email_hash, apto = :apto, bloco = :bloco,
                        telefone = :telefone, tell_recado = :tell_recado, senha = :senha
                    WHERE id_user = :id";
            $params[':senha'] = $update['senha'];
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function deletarDados(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE morador SET
                nome        = :nome,
                cpf         = :cpf,
                cpf_hash    = :cpf_hash,
                email       = :email,
                email_hash  = :email_hash,
                apto        = '***',
                bloco       = '***',
                telefone    = :telefone,
                tell_recado = :tell_recado,
                senha       = '***',
                status      = 'E'
             WHERE id_user = :id"
        );
        return $stmt->execute([
            ':nome'  => '***' . $id,
            ':cpf'   => CryptoHelper::encrypt('***' . $id),
            ':cpf_hash' => CryptoHelper::hashLookup('cpf-deletado-' . $id),
            ':email' => CryptoHelper::encrypt('***' . $id . '@deletado.com'),
            ':email_hash' => CryptoHelper::hashLookup('email-deletado-' . $id),
            ':telefone' => CryptoHelper::encrypt('***'),
            ':tell_recado' => CryptoHelper::encrypt('***'),
            ':id'    => $id,
        ]);
    }

    private static function gerarUuid(): string
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x40);
        $bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

    public function contarPorStatus(): array
    {
        $stmt = $this->pdo->query("
            SELECT status, COUNT(id_user) AS total
            FROM morador
            GROUP BY status
        ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $map = ['P' => 0, 'L' => 0, 'I' => 0, 'B' => 0, 'E' => 0];

        foreach ($rows as $row) {
            $key = strtoupper(trim($row['status']));
            if (isset($map[$key])) {
                $map[$key] = (int)$row['total'];
            }
        }

        return $map;
    }

    public function atualizarPrivilegio(int $id, int $privilegio): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE morador SET privilegio = :privilegio WHERE id_user = :id"
        );
        return $stmt->execute([
            ':privilegio' => $privilegio,
            ':id'         => $id,
        ]);
    }

    public function atualizarUnidade(int $id, string $apto, string $bloco): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE morador SET apto = :apto, bloco = :bloco WHERE id_user = :id"
        );
        return $stmt->execute([
            ':apto'  => $apto,
            ':bloco' => $bloco,
            ':id'    => $id,
        ]);
    }

    public function findTodosComFiltros(array $filtros, ?int $limit = null, int $offset = 0): array{
        $params = $this->montarFiltrosTodos($filtros);
        $sql    = "SELECT * FROM morador WHERE 1=1" . $params['sql'] . ' ORDER BY nome ASC';

        if ($limit !== null) {
            $sql .= ' LIMIT :limit OFFSET :offset';
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params['bindings'] as $chave => $valor) {
            $stmt->bindValue($chave, $valor);
        }
        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $this->descriptografarLista($stmt->fetchAll());
    }

    public function countTodosComFiltros(array $filtros): int
    {
        $params = $this->montarFiltrosTodos($filtros);
        $stmt   = $this->pdo->prepare("SELECT COUNT(*) FROM morador WHERE 1=1" . $params['sql']);
        $stmt->execute($params['bindings']);
        return (int)$stmt->fetchColumn();
    }

    private function montarFiltrosTodos(array $filtros): array
    {
        $sql      = '';
        $bindings = [];

        if (!empty($filtros['nome'])) {
            $sql .= ' AND nome LIKE :nome';
            $bindings[':nome'] = '%' . $filtros['nome'] . '%';
        }
        if (!empty($filtros['apto'])) {
            $sql .= ' AND apto LIKE :apto';
            $bindings[':apto'] = '%' . $filtros['apto'] . '%';
        }
        if (!empty($filtros['bloco'])) {
            $sql .= ' AND bloco LIKE :bloco';
            $bindings[':bloco'] = '%' . $filtros['bloco'] . '%';
        }
        if (!empty($filtros['status'])) {
            $sql .= ' AND status = :status';
            $bindings[':status'] = $filtros['status'];
        }
        if (isset($filtros['perfil']) && $filtros['perfil'] !== '') {
            $sql .= ' AND privilegio = :perfil';
            $bindings[':perfil'] = (int) $filtros['perfil'];
        }
        if (!empty($filtros['foco'])) {
            $sql .= ' AND id_user = :foco';
            $bindings[':foco'] = (int) $filtros['foco'];
        }

        return ['sql' => $sql, 'bindings' => $bindings];
    }

    public function atualizarSenha(int $id, string $senhaHash): bool{
        $stmt = $this->pdo->prepare("UPDATE morador SET senha = :senha WHERE id_user = :id");
        return $stmt->execute([':senha' => $senhaHash, ':id' => $id]);
    }

    private function descriptografarMorador(?array $morador): ?array
    {
        if (!$morador) {
            return null;
        }

        foreach (['cpf', 'email', 'telefone', 'tell_recado'] as $campo) {
            if (array_key_exists($campo, $morador)) {
                $morador[$campo] = CryptoHelper::decrypt($morador[$campo]);
            }
        }

        return $morador;
    }

    private function descriptografarLista(array $moradores): array
    {
        return array_map(fn ($morador) => $this->descriptografarMorador($morador), $moradores);
    }

}
