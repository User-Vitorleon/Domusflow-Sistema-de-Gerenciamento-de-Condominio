<?php

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
        return $stmt->fetch() ?: null;
    }

    public function findAtivos(): array
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM morador WHERE status = 'L' AND privilegio = 1"
        );
        return $stmt->fetchAll();
    }

    public function findTodos(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM morador WHERE status != 'B' ORDER BY nome ASC");
        return $stmt->fetchAll();
    }

    public function findByCpf(string $cpf): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM morador WHERE cpf = :cpf LIMIT 1");
        $stmt->execute([':cpf' => $cpf]);
        return $stmt->fetch() ?: null;
    }

    public function existeCpf(string $cpf): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM morador WHERE cpf = :cpf");
        $stmt->execute([':cpf' => $cpf]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function existeEmail(string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM morador WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function findPendentes(): array
    {
        $stmt = $this->pdo->query("
            SELECT id_user, nome, apto, bloco, cpf, created_at
            FROM morador
            WHERE status = 'P'
            ORDER BY nome ASC
        ");
        return $stmt->fetchAll();
    }

    public function findPendentesComFiltros(array $filtros, int $limit, int $offset): array
    {
        $sql = "
            SELECT id_user, nome, apto, bloco, cpf, created_at
            FROM morador
            WHERE status = 'P'
        ";

        $params = $this->montarFiltrosPendentes($filtros);
        $sql   .= $params['sql'];

        $colunasPermitidas = [
            'nome'  => 'nome',
            'cpf'   => 'cpf',
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
        return $stmt->fetchAll();
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
            $sql .= ' AND cpf LIKE :cpf';
            $bindings[':cpf'] = '%' . $filtros['cpf'] . '%';
        }
        if (!empty($filtros['data_solicitacao'])) {
            $sql .= ' AND DATE(created_at) = :data_solicitacao';
            $bindings[':data_solicitacao'] = $filtros['data_solicitacao'];
        }

        return ['sql' => $sql, 'bindings' => $bindings];
    }

    public function save(array $data): int|bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO morador
                (identificador, nome, apto, bloco, cpf, email, telefone, tell_recado, senha, status)
             VALUES
                (:iden, :nome, :apto, :bloco, :cpf, :email, :cell, :recado, :senha, :status)"
        );

        $sucesso = $stmt->execute([
            ':iden'   => 1,
            ':nome'   => $data['nome'],
            ':apto'   => $data['apto'],
            ':bloco'  => $data['bloco'],
            ':cpf'    => $data['cpf'],
            ':email'  => $data['email'],
            ':cell'   => $data['telefone'],
            ':recado' => $data['telefone_recado'] ?? null,
            ':senha'  => $data['senha'],
            ':status' => 'P',
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

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM morador ORDER BY nome ASC");
        return $stmt->fetchAll();
    }

    public function atualizarDados(array $update): bool
    {
        $params = [
            ':nome'        => $update['nome'],
            ':email'       => $update['email'],
            ':apto'        => $update['apto'],
            ':bloco'       => $update['bloco'],
            ':telefone'    => $update['telefone'],
            ':tell_recado' => $update['tell_recado'],
            ':id'          => $update['id'],
        ];

        if (empty($update['senha'])) {
            $sql = "UPDATE morador
                    SET nome = :nome, email = :email, apto = :apto, bloco = :bloco,
                        telefone = :telefone, tell_recado = :tell_recado
                    WHERE id_user = :id";
        } else {
            $sql = "UPDATE morador
                    SET nome = :nome, email = :email, apto = :apto, bloco = :bloco,
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
                email       = :email,
                apto        = '***',
                bloco       = '***',
                telefone    = '***',
                tell_recado = '***',
                senha       = '***',
                status      = 'E'
             WHERE id_user = :id"
        );
        return $stmt->execute([
            ':nome'  => '***' . $id,
            ':email' => '***' . $id . '@deletado.com',
            ':id'    => $id,
        ]);
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
}
