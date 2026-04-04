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

    public function findPendentes(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM morador WHERE status = 'P'");
        return $stmt->fetchAll();
    }

    public function save(array $data): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO morador
                (identificador, nome, apto, bloco, cpf, email, sexo, telefone, tell_recado, senha, status)
             VALUES
                (:iden, :nome, :apto, :bloco, :cpf, :email, :sexo, :cell, :recado, :senha, :status)"
        );
        return $stmt->execute([
            ':iden'   => 1,
            ':nome'   => $data['nome'],
            ':apto'   => $data['apto'],
            ':bloco'  => $data['bloco'],
            ':cpf'    => $data['cpf'],
            ':email'  => $data['email'],
            ':sexo'   => $data['sexo'],
            ':cell'   => $data['telefone'],
            ':recado' => $data['telefone_recado'] ?? null,
            ':senha'  => $data['senha'],
            ':status' => 'P',
        ]);
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
}
