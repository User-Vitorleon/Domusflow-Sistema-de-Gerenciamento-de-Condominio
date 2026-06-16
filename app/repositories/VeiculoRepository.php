<?php

require_once __DIR__ . '/../helpers/CryptoHelper.php';

class VeiculoRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("
            SELECT v.*,
                   dono.nome AS nome_morador,
                   dono.apto AS apto,
                   dono.bloco AS bloco,
                   cad.nome  AS cadastrado_por
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            JOIN morador cad  ON cad.id_user  = v.id_user_cad
            ORDER BY v.created_at DESC, dono.nome ASC
        ");
        return $this->descriptografarNomes($stmt->fetchAll());
    }

    public function findByUsuario(int $idUser): array
    {
        $stmt = $this->pdo->prepare("
            SELECT v.*,
                   dono.nome AS nome_morador,
                   dono.apto AS apto,
                   dono.bloco AS bloco,
                   cad.nome  AS cadastrado_por
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            JOIN morador cad  ON cad.id_user  = v.id_user_cad
            WHERE v.id_user = :id
            ORDER BY v.created_at DESC, dono.nome ASC
        ");
        $stmt->execute([':id' => $idUser]);
        return $this->descriptografarNomes($stmt->fetchAll());
    }

    public function recentes(int $limite = 6): array
    {
        $stmt = $this->pdo->prepare("
            SELECT v.*,
                   dono.nome AS nome_morador,
                   dono.apto AS apto,
                   dono.bloco AS bloco,
                   cad.nome  AS cadastrado_por
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            JOIN morador cad  ON cad.id_user  = v.id_user_cad
            ORDER BY v.created_at DESC, v.id_veiculo DESC
            LIMIT :limite
        ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $this->descriptografarNomes($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findAllComFiltros(array $filtros, int $limite, int $offset): array
    {
        [$where, $params] = $this->montarFiltrosTodos($filtros);
        $temFiltroNome = trim((string)($filtros['nome'] ?? '')) !== '';

        $sql = "
            SELECT v.*,
                   dono.nome AS nome_morador,
                   dono.apto AS apto,
                   dono.bloco AS bloco,
                   cad.nome  AS cadastrado_por
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            JOIN morador cad  ON cad.id_user  = v.id_user_cad
            {$where}
            ORDER BY v.created_at DESC, dono.nome ASC
        ";

        if (!$temFiltroNome) {
            $sql .= " LIMIT :limite OFFSET :offset";
        }

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $chave => $valor) {
            $stmt->bindValue($chave, $valor);
        }
        if (!$temFiltroNome) {
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();

        $veiculos = $this->descriptografarNomes($stmt->fetchAll());
        $veiculos = $this->filtrarPorTexto($veiculos, 'nome_morador', $filtros['nome'] ?? '');

        return $temFiltroNome ? array_slice($veiculos, $offset, $limite) : $veiculos;
    }

    public function countAllComFiltros(array $filtros): int
    {
        [$where, $params] = $this->montarFiltrosTodos($filtros);
        $temFiltroNome = trim((string)($filtros['nome'] ?? '')) !== '';

        if ($temFiltroNome) {
            $stmt = $this->pdo->prepare("
                SELECT v.*,
                       dono.nome AS nome_morador,
                       cad.nome  AS cadastrado_por
                FROM veiculos v
                JOIN morador dono ON dono.id_user = v.id_user
                JOIN morador cad  ON cad.id_user  = v.id_user_cad
                {$where}
            ");
            $stmt->execute($params);
            return count($this->filtrarPorTexto($this->descriptografarNomes($stmt->fetchAll()), 'nome_morador', $filtros['nome']));
        }

        $stmt = $this->pdo->prepare("
            SELECT COUNT(v.id_veiculo)
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            JOIN morador cad  ON cad.id_user  = v.id_user_cad
            {$where}
        ");
        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    public function findByPlaca(string $placa): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT v.*,
                   dono.nome  AS nome_morador,
                   dono.apto  AS apto,
                   dono.bloco AS bloco,
                   cad.nome   AS cadastrado_por
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            JOIN morador cad  ON cad.id_user  = v.id_user_cad
            WHERE v.placa = :placa
            LIMIT 1
        ");
        $stmt->execute([':placa' => strtoupper($placa)]);
        return $this->descriptografarNome($stmt->fetch() ?: null);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT v.*,
                   dono.nome  AS nome_morador,
                   dono.apto  AS apto,
                   dono.bloco AS bloco
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            WHERE v.id_veiculo = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        return $this->descriptografarNome($stmt->fetch() ?: null);
    }

    public function existePlaca(string $placa): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM veiculos WHERE placa = :placa");
        $stmt->execute([':placa' => strtoupper($placa)]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function countByUser(int $idUser): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM veiculos WHERE id_user = :id");
        $stmt->execute([':id' => $idUser]);
        return (int)$stmt->fetchColumn();
    }

    public function desmarcarPrincipal(int $idUser): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE veiculos SET principal = 0 WHERE id_user = :id
        ");
        return $stmt->execute([':id' => $idUser]);
    }

    public function marcarPrincipal(int $idVeiculo): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE veiculos SET principal = 1 WHERE id_veiculo = :id
        ");
        return $stmt->execute([':id' => $idVeiculo]);
    }

    public function save(array $data): int|bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO veiculos (placa, marca, modelo, cor, principal, id_user, id_user_cad)
            VALUES (:placa, :marca, :modelo, :cor, :principal, :id_user, :id_user_cad)
        ");
        $sucesso = $stmt->execute([
            ':placa'       => strtoupper($data['placa']),
            ':marca'       => $data['marca'],
            ':modelo'      => $data['modelo'],
            ':cor'         => $data['cor'],
            ':principal'   => $data['principal'] ?? 0,
            ':id_user'     => $data['id_user'],
            ':id_user_cad' => $data['id_user_cad'],
        ]);
        return $sucesso ? (int)$this->pdo->lastInsertId() : false;
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE veiculos
            SET placa = :placa, marca = :marca, modelo = :modelo, cor = :cor
            WHERE id_veiculo = :id
        ");
        return $stmt->execute([
            ':placa'  => strtoupper($data['placa']),
            ':marca'  => $data['marca'],
            ':modelo' => $data['modelo'],
            ':cor'    => $data['cor'],
            ':id'     => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM veiculos WHERE id_veiculo = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function countAll(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(id_veiculo) FROM veiculos");
        return (int)$stmt->fetchColumn();
    }

    public function topMarcas(int $limite = 3): array
    {
        return $this->topPorCampo('marca', $limite);
    }

    public function topCores(int $limite = 3): array
    {
        return $this->topPorCampo('cor', $limite);
    }

    public function topModelos(int $limite = 3): array
    {
        return $this->topPorCampo('modelo', $limite);
    }

    private function topPorCampo(string $coluna, int $limite): array
    {
        $colunasPermitidas = ['marca', 'cor', 'modelo'];
        if (!in_array($coluna, $colunasPermitidas, true)) {
            return [];
        }

        $stmt = $this->pdo->prepare("
            SELECT {$coluna}, COUNT(id_veiculo) AS total
            FROM veiculos
            WHERE {$coluna} IS NOT NULL AND {$coluna} <> ''
            GROUP BY {$coluna}
            ORDER BY total DESC, {$coluna} ASC
            LIMIT :limite
        ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function montarFiltrosTodos(array $filtros): array
    {
        $where = [];
        $params = [];

        if (!empty($filtros['nome'])) {
            
        }

        if (!empty($filtros['placa'])) {
            $where[] = 'v.placa LIKE :placa';
            $params[':placa'] = '%' . strtoupper(preg_replace('/[^A-Z0-9]/i', '', $filtros['placa'])) . '%';
        }

        if (!empty($filtros['bloco'])) {
            $where[] = 'LOWER(dono.bloco) LIKE LOWER(:bloco)';
            $params[':bloco'] = '%' . trim($filtros['bloco']) . '%';
        }

        if (!empty($filtros['apto'])) {
            $where[] = 'LOWER(dono.apto) LIKE LOWER(:apto)';
            $params[':apto'] = '%' . trim($filtros['apto']) . '%';
        }

        if (!empty($filtros['data_cadastro'])) {
            $where[] = 'DATE(v.created_at) = :data_cadastro';
            $params[':data_cadastro'] = trim($filtros['data_cadastro']);
        }

        return [$where ? 'WHERE ' . implode(' AND ', $where) : '', $params];
    }

    private function descriptografarNomes(array $linhas): array
    {
        return array_map(fn($linha) => $this->descriptografarNome($linha), $linhas);
    }

    private function descriptografarNome(?array $linha): ?array
    {
        if (!$linha) {
            return $linha;
        }

        foreach (['nome_morador', 'cadastrado_por'] as $campo) {
            if (array_key_exists($campo, $linha)) {
                $linha[$campo] = CryptoHelper::decrypt($linha[$campo]);
            }
        }

        return $linha;
    }

    private function filtrarPorTexto(array $linhas, string $campo, ?string $termo): array
    {
        $termo = self::normalizarBusca((string)$termo);
        if ($termo === '') {
            return $linhas;
        }

        return array_values(array_filter($linhas, static function ($linha) use ($campo, $termo) {
            return str_contains(self::normalizarBusca((string)($linha[$campo] ?? '')), $termo);
        }));
    }

    private static function normalizarBusca(string $valor): string
    {
        $valor = trim($valor);
        return function_exists('mb_strtolower') ? mb_strtolower($valor, 'UTF-8') : strtolower($valor);
    }
}
