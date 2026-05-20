<?php

class OcorrenciaRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

<<<<<<< HEAD
    // ── Ocorrências ─────────────────────────────────────────

    public function criar(array $dados): int
=======
public function criar(array $dados): int
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO ocorrencias (id_user, categoria, titulo, descricao, status)
            VALUES (:id_user, :categoria, :titulo, :descricao, 'A')
        ");
        $stmt->execute([
            ':id_user'   => $dados['id_user'],
            ':categoria' => strtoupper($dados['categoria']),
            ':titulo'    => strtoupper($dados['titulo']),
            ':descricao' => strtoupper($dados['descricao']),
        ]);
<<<<<<< HEAD
        return (int) $this->pdo->lastInsertId();
=======
        return (int)$this->pdo->lastInsertId();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT o.*, m.nome AS nome_morador, m.apto, m.bloco
            FROM ocorrencias o
            JOIN morador m ON m.id_user = o.id_user
            WHERE o.id_ocorrencia = :id
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

<<<<<<< HEAD
    public function listarPorUsuario(int $id_user): array
=======
    public function listarPorUsuario(int $idUser): array
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM ocorrencias
            WHERE id_user = :id_user
            ORDER BY created_at DESC
        ");
<<<<<<< HEAD
        $stmt->execute([':id_user' => $id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ← MÉTODO ÚNICO: substitui o antigo listarTodas() e suporta paginação
=======
        $stmt->execute([':id_user' => $idUser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    public function listarTodas(?string $status = null, int $limit = 15, int $offset = 0): array
    {
        $sql = "
            SELECT o.*, m.nome AS nome_morador, m.apto, m.bloco
            FROM ocorrencias o
            JOIN morador m ON m.id_user = o.id_user
            WHERE 1=1
        ";
<<<<<<< HEAD
        $params = [];

        if ($status) {
            $sql .= " AND o.status = :status";
            $params[':status'] = $status;
        }

        $sql .= " ORDER BY o.created_at DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        if ($status) {
            $stmt->bindValue(':status', $params[':status']);
=======

        if ($status) {
            $sql .= ' AND o.status = :status';
        }

        $sql .= ' ORDER BY o.created_at DESC LIMIT :limit OFFSET :offset';

        $stmt = $this->pdo->prepare($sql);
        if ($status) {
            $stmt->bindValue(':status', $status);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        }
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarTodas(?string $status = null): int
    {
<<<<<<< HEAD
        $sql = "SELECT COUNT(*) FROM ocorrencias o WHERE 1=1";
        $params = [];
        if ($status) {
            $sql .= " AND o.status = :status";
=======
        $sql    = 'SELECT COUNT(*) FROM ocorrencias o WHERE 1=1';
        $params = [];
        if ($status) {
            $sql .= ' AND o.status = :status';
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            $params[':status'] = $status;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
<<<<<<< HEAD
        return (int) $stmt->fetchColumn();
=======
        return (int)$stmt->fetchColumn();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function atualizarStatus(int $id, string $status): void
    {
<<<<<<< HEAD
        $stmt = $this->pdo->prepare("
            UPDATE ocorrencias SET status = :status WHERE id_ocorrencia = :id
        ");
=======
        $stmt = $this->pdo->prepare(
            "UPDATE ocorrencias SET status = :status WHERE id_ocorrencia = :id"
        );
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $stmt->execute([':status' => $status, ':id' => $id]);
    }

    public function contarPorStatus(): array
    {
        $stmt = $this->pdo->query("
            SELECT status, COUNT(*) AS total
            FROM ocorrencias
            GROUP BY status
        ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
<<<<<<< HEAD
        $map  = ['total' => 0, 'aberto' => 0, 'andamento' => 0, 'resolvido' => 0, 'cancelado' => 0];
        foreach ($rows as $r) {
            $map['total'] += (int) $r['total'];
            match ($r['status']) {
                'A' => $map['aberto']    += (int) $r['total'],
                'E' => $map['andamento'] += (int) $r['total'],
                'R' => $map['resolvido'] += (int) $r['total'],
                'C' => $map['cancelado'] += (int) $r['total'],
=======

        $map = [
            'total'     => 0,
            'aberto'    => 0,
            'andamento' => 0,
            'resolvido' => 0,
            'cancelado' => 0,
        ];

        foreach ($rows as $r) {
            $total = (int)$r['total'];
            $map['total'] += $total;
            match ($r['status']) {
                'A'     => $map['aberto']    += $total,
                'E'     => $map['andamento'] += $total,
                'R'     => $map['resolvido'] += $total,
                'C'     => $map['cancelado'] += $total,
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
                default => null,
            };
        }
        return $map;
    }

<<<<<<< HEAD
    // ── Tramites ────────────────────────────────────────────

    public function adicionarTramite(array $dados): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO ocorrencia_tramites
              (id_ocorrencia, id_user_cad, nome_user_cad, descricao, status_novo)
            VALUES (:id_ocorrencia, :id_user_cad, :nome_user_cad, :descricao, :status_novo)
=======
public function adicionarTramite(array $dados): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO ocorrencia_tramites
                (id_ocorrencia, id_user_cad, nome_user_cad, descricao, status_novo)
            VALUES
                (:id_ocorrencia, :id_user_cad, :nome_user_cad, :descricao, :status_novo)
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        ");
        $stmt->execute([
            ':id_ocorrencia' => $dados['id_ocorrencia'],
            ':id_user_cad'   => $dados['id_user_cad'],
            ':nome_user_cad' => $dados['nome_user_cad'],
            ':descricao'     => strtoupper($dados['descricao']),
            ':status_novo'   => $dados['status_novo'],
        ]);
    }

<<<<<<< HEAD
    public function listarTramites(int $id_ocorrencia, int $limit = 10, int $offset = 0): array
    {
        $stmt = $this->pdo->prepare("
        SELECT id_tramite, id_ocorrencia, id_user_cad, nome_user_cad, descricao, status_novo, created_at
        FROM ocorrencia_tramites
        WHERE id_ocorrencia = :id
        ORDER BY created_at ASC
        LIMIT :limit OFFSET :offset
    ");
        $stmt->bindValue(':id', $id_ocorrencia, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
=======
    public function listarTramites(int $idOcorrencia, int $limit = 10, int $offset = 0): array
    {
        $stmt = $this->pdo->prepare("
            SELECT id_tramite, id_ocorrencia, id_user_cad, nome_user_cad,
                   descricao, status_novo, created_at
            FROM ocorrencia_tramites
            WHERE id_ocorrencia = :id
            ORDER BY created_at ASC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':id',     $idOcorrencia, PDO::PARAM_INT);
        $stmt->bindValue(':limit',  $limit,        PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset,       PDO::PARAM_INT);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

<<<<<<< HEAD
    public function contarTramites(int $id_ocorrencia): int
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(*)
        FROM ocorrencia_tramites
        WHERE id_ocorrencia = :id
    ");
        $stmt->execute([':id' => $id_ocorrencia]);
        return (int) $stmt->fetchColumn();
    }

    // ── Notificações ─────────────────────────────────────────

    public function criarNotificacao(int $id_user, int $id_ocorrencia): void
=======
    public function contarTramites(int $idOcorrencia): int
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM ocorrencia_tramites
            WHERE id_ocorrencia = :id
        ");
        $stmt->execute([':id' => $idOcorrencia]);
        return (int)$stmt->fetchColumn();
    }

public function criarNotificacao(int $idUser, int $idOcorrencia): void
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO ocorrencia_notificacoes (id_user, id_ocorrencia)
            VALUES (:id_user, :id_ocorrencia)
        ");
<<<<<<< HEAD
        $stmt->execute([':id_user' => $id_user, ':id_ocorrencia' => $id_ocorrencia]);
=======
        $stmt->execute([':id_user' => $idUser, ':id_ocorrencia' => $idOcorrencia]);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function contarNaoLidas(int $idUser): int
    {
        try {
<<<<<<< HEAD
            $pdo  = getConnection();
            $stmt = $pdo->prepare("
            SELECT COUNT(id_notificacao)
            FROM ocorrencia_notificacoes
            WHERE id_user = :id AND lida = 0
        ");
            $stmt->execute([':id' => $idUser]);
            return (int) $stmt->fetchColumn();
=======
            $stmt = $this->pdo->prepare("
                SELECT COUNT(id_notificacao)
                FROM ocorrencia_notificacoes
                WHERE id_user = :id AND lida = 0
            ");
            $stmt->execute([':id' => $idUser]);
            return (int)$stmt->fetchColumn();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        } catch (\PDOException $e) {
            return 0;
        }
    }

<<<<<<< HEAD
    public function marcarTodasLidas(int $id_user): void
=======
    public function marcarTodasLidas(int $idUser): void
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    {
        $stmt = $this->pdo->prepare("
            UPDATE ocorrencia_notificacoes SET lida = 1
            WHERE id_user = :id_user
        ");
<<<<<<< HEAD
        $stmt->execute([':id_user' => $id_user]);
    }

    // ── Filtros avançados ─────────────────────────────────────

    public function listarComFiltros(array $filtros, int $limit = 15, int $offset = 0): array
=======
        $stmt->execute([':id_user' => $idUser]);
    }

public function listarComFiltros(array $filtros, int $limit = 15, int $offset = 0): array
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    {
        $sql = "
            SELECT o.id_ocorrencia, o.id_user, o.categoria, o.titulo,
                   o.descricao, o.status, o.created_at,
                   m.nome AS nome_morador, m.apto, m.bloco
            FROM ocorrencias o
            INNER JOIN morador m ON m.id_user = o.id_user
            WHERE 1=1
        ";
        $params = [];
<<<<<<< HEAD


        if (!empty($filtros['id_ocorrencia'])) {
            $sql .= " AND o.id_ocorrencia = ?";
            $params[] = (int)$filtros['id_ocorrencia'];
        }
        if (!empty($filtros['status'])) {
            $sql .= " AND o.status = ?";
            $params[] = $filtros['status'];
        }
        if (!empty($filtros['morador'])) {
            $sql .= " AND m.nome LIKE ?";
            $params[] = '%' . $filtros['morador'] . '%';
        }
        if (!empty($filtros['categoria'])) {
            $sql .= " AND o.categoria = ?";
            $params[] = $filtros['categoria'];
        }
        if (!empty($filtros['titulo'])) {
            $sql .= " AND o.titulo LIKE ?";
            $params[] = '%' . $filtros['titulo'] . '%';
        }
        if (!empty($filtros['data_ini'])) {
            $sql .= " AND DATE(o.created_at) >= ?";
            $params[] = $filtros['data_ini'];
        }
        if (!empty($filtros['data_fim'])) {
            $sql .= " AND DATE(o.created_at) <= ?";
            $params[] = $filtros['data_fim'];
        }

        $sql .= " ORDER BY
            CASE o.status WHEN 'A' THEN 1 WHEN 'E' THEN 2 WHEN 'R' THEN 3 ELSE 4 END,
            o.created_at DESC
=======
        $this->aplicarFiltrosOcorrencia($filtros, $sql, $params);

        $sql .= "
            ORDER BY
                CASE o.status WHEN 'A' THEN 1 WHEN 'E' THEN 2 WHEN 'R' THEN 3 ELSE 4 END,
                o.created_at DESC
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            LIMIT ? OFFSET ?";

        $params[] = $limit;
        $params[] = $offset;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarComFiltros(array $filtros): int
    {
<<<<<<< HEAD
        $sql    = "SELECT COUNT(*) FROM ocorrencias o INNER JOIN morador m ON m.id_user = o.id_user WHERE 1=1";
        $params = [];

        if (!empty($filtros['id_ocorrencia'])) {
            $sql .= " AND o.id_ocorrencia = ?";
            $params[] = (int)$filtros['id_ocorrencia'];
        }
        if (!empty($filtros['status'])) {
            $sql .= " AND o.status = ?";
            $params[] = $filtros['status'];
        }
        if (!empty($filtros['morador'])) {
            $sql .= " AND m.nome LIKE ?";
            $params[] = '%' . $filtros['morador'] . '%';
        }
        if (!empty($filtros['categoria'])) {
            $sql .= " AND o.categoria = ?";
            $params[] = $filtros['categoria'];
        }
        if (!empty($filtros['titulo'])) {
            $sql .= " AND o.titulo LIKE ?";
            $params[] = '%' . $filtros['titulo'] . '%';
        }
        if (!empty($filtros['data_ini'])) {
            $sql .= " AND DATE(o.created_at) >= ?";
            $params[] = $filtros['data_ini'];
        }
        if (!empty($filtros['data_fim'])) {
            $sql .= " AND DATE(o.created_at) <= ?";
            $params[] = $filtros['data_fim'];
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
=======
        $sql = "
            SELECT COUNT(*)
            FROM ocorrencias o
            INNER JOIN morador m ON m.id_user = o.id_user
            WHERE 1=1
        ";
        $params = [];
        $this->aplicarFiltrosOcorrencia($filtros, $sql, $params);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    private function aplicarFiltrosOcorrencia(array $filtros, string &$sql, array &$params): void
    {
        if (!empty($filtros['id_ocorrencia'])) {
            $sql .= ' AND o.id_ocorrencia = ?';
            $params[] = (int)$filtros['id_ocorrencia'];
        }
        if (!empty($filtros['status'])) {
            $sql .= ' AND o.status = ?';
            $params[] = $filtros['status'];
        }
        if (!empty($filtros['morador'])) {
            $sql .= ' AND m.nome LIKE ?';
            $params[] = '%' . $filtros['morador'] . '%';
        }
        if (!empty($filtros['categoria'])) {
            $sql .= ' AND o.categoria = ?';
            $params[] = $filtros['categoria'];
        }
        if (!empty($filtros['titulo'])) {
            $sql .= ' AND o.titulo LIKE ?';
            $params[] = '%' . $filtros['titulo'] . '%';
        }
        if (!empty($filtros['data_ini'])) {
            $sql .= ' AND DATE(o.created_at) >= ?';
            $params[] = $filtros['data_ini'];
        }
        if (!empty($filtros['data_fim'])) {
            $sql .= ' AND DATE(o.created_at) <= ?';
            $params[] = $filtros['data_fim'];
        }
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function listarMoradoresComOcorrencias(): array
    {
        $stmt = $this->pdo->query("
<<<<<<< HEAD
        SELECT DISTINCT m.nome, m.apto, m.bloco
        FROM ocorrencias o
        INNER JOIN morador m ON m.id_user = o.id_user
        ORDER BY m.nome ASC, m.bloco ASC, m.apto ASC
    ");
=======
            SELECT DISTINCT m.nome, m.apto, m.bloco
            FROM ocorrencias o
            INNER JOIN morador m ON m.id_user = o.id_user
            ORDER BY m.nome ASC, m.bloco ASC, m.apto ASC
        ");
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarPorStatusUsuario(int $idUser): array
    {
        $stmt = $this->pdo->prepare("
<<<<<<< HEAD
        SELECT status, COUNT(id_ocorrencia) AS total
        FROM ocorrencias
        WHERE id_user = :id_user
        GROUP BY status
    ");
=======
            SELECT status, COUNT(id_ocorrencia) AS total
            FROM ocorrencias
            WHERE id_user = :id_user
            GROUP BY status
        ");
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $stmt->execute([':id_user' => $idUser]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $map = [
<<<<<<< HEAD
            'aberto' => 0,
            'andamento' => 0,
            'resolvido' => 0,
            'cancelado' => 0
        ];

        foreach ($rows as $row) {
            switch ($row['status']) {
                case 'A':
                    $map['aberto'] = (int) $row['total'];
                    break;
                case 'E':
                    $map['andamento'] = (int) $row['total'];
                    break;
                case 'R':
                    $map['resolvido'] = (int) $row['total'];
                    break;
                case 'C':
                    $map['cancelado'] = (int) $row['total'];
=======
            'aberto'    => 0,
            'andamento' => 0,
            'resolvido' => 0,
            'cancelado' => 0,
        ];

        foreach ($rows as $row) {
            $total = (int)$row['total'];
            switch ($row['status']) {
                case 'A':
                    $map['aberto'] = $total;
                    break;
                case 'E':
                    $map['andamento'] = $total;
                    break;
                case 'R':
                    $map['resolvido'] = $total;
                    break;
                case 'C':
                    $map['cancelado'] = $total;
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
                    break;
            }
        }

        return $map;
    }
}
