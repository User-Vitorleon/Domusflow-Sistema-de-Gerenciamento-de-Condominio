<?php
<<<<<<< HEAD
=======

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
class LocalRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function findDisponiveis(): array
    {
        $stmt = $this->pdo->query("
            SELECT id_local, local, capacidade
            FROM locais_festivos
            WHERE disp_uso = 'S'
        ");
        return $stmt->fetchAll();
    }

    public function countDisponiveis(): int
    {
        $stmt = $this->pdo->query(
            "SELECT COUNT(*) FROM locais_festivos WHERE disp_uso = 'S'"
        );
        return (int)$stmt->fetchColumn();
    }

    public function save(array $data): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO locais_festivos (local, capacidade, disp_uso, id_user_cad)
            VALUES (:local, :capac, :disp, :id_user)
        ");
        return $stmt->execute([
            ':local'   => $data['local'],
            ':capac'   => $data['capacidade'],
            ':disp'    => $data['disp_uso'],
            ':id_user' => $data['id_user_cad'],
        ]);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
<<<<<<< HEAD
        SELECT * FROM locais_festivos WHERE id_local = :id
    ");
=======
            SELECT * FROM locais_festivos WHERE id_local = :id
        ");
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
