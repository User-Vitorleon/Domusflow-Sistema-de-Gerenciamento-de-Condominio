<?php

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
                   cad.nome  AS cadastrado_por
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            JOIN morador cad  ON cad.id_user  = v.id_user_cad
            ORDER BY v.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function findByUsuario(int $idUser): array
    {
        $stmt = $this->pdo->prepare("
            SELECT v.*,
                   dono.nome AS nome_morador,
                   cad.nome  AS cadastrado_por
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            JOIN morador cad  ON cad.id_user  = v.id_user_cad
            WHERE v.id_user = :id
            ORDER BY v.principal DESC, v.created_at DESC
        ");
        $stmt->execute([':id' => $idUser]);
        return $stmt->fetchAll();
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
        return $stmt->fetch() ?: null;
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
        return $stmt->fetch() ?: null;
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
}
