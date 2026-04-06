<?php
class VeiculoRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    // Busca todos os veículos com nome do morador e de quem cadastrou
    public function findAll(): array
    {
        $stmt = $this->pdo->query("
            SELECT v.*, 
                   dono.nome      AS nome_morador,
                   cad.nome       AS cadastrado_por
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            JOIN morador cad  ON cad.id_user  = v.id_user_cad
            ORDER BY v.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    // Busca veículos de um morador específico
    public function findByUsuario(int $id_user): array
    {
        $stmt = $this->pdo->prepare("
            SELECT v.*,
                   dono.nome AS nome_morador,
                   cad.nome  AS cadastrado_por
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            JOIN morador cad  ON cad.id_user  = v.id_user_cad
            WHERE v.id_user = :id
            ORDER BY v.created_at DESC
        ");
        $stmt->execute([':id' => $id_user]);
        return $stmt->fetchAll();
    }

    // Consulta rápida por placa (porteiro)
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

    public function existePlaca(string $placa): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM veiculos WHERE placa = :placa");
        $stmt->execute([':placa' => strtoupper($placa)]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function save(array $data): int|bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO veiculos (placa, marca, modelo, cor, id_user, id_user_cad)
            VALUES (:placa, :marca, :modelo, :cor, :id_user, :id_user_cad)
        ");
        $sucesso = $stmt->execute([
            ':placa'       => strtoupper($data['placa']),
            ':marca'       => $data['marca'],
            ':modelo'      => $data['modelo'],
            ':cor'         => $data['cor'],
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
}
