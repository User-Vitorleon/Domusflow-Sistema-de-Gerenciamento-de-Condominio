<?php
<<<<<<< HEAD
=======

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
class VeiculoRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

<<<<<<< HEAD
    // Busca todos os veículos com nome do morador e de quem cadastrou
=======
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    public function findAll(): array
    {
        $stmt = $this->pdo->query("
            SELECT v.*,
<<<<<<< HEAD
                   dono.nome      AS nome_morador,
                   cad.nome       AS cadastrado_por
=======
                   dono.nome AS nome_morador,
                   cad.nome  AS cadastrado_por
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            JOIN morador cad  ON cad.id_user  = v.id_user_cad
            ORDER BY v.created_at DESC
        ");
        return $stmt->fetchAll();
    }

<<<<<<< HEAD
    // Busca veículos de um morador específico
    public function findByUsuario(int $id_user): array
=======
    public function findByUsuario(int $idUser): array
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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
<<<<<<< HEAD
        $stmt->execute([':id' => $id_user]);
        return $stmt->fetchAll();
    }

    // Consulta rápida por placa (porteiro)
=======
        $stmt->execute([':id' => $idUser]);
        return $stmt->fetchAll();
    }

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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
<<<<<<< HEAD
        SELECT v.*,
               dono.nome  AS nome_morador,
               dono.apto  AS apto,
               dono.bloco AS bloco
        FROM veiculos v
        JOIN morador dono ON dono.id_user = v.id_user
        WHERE v.id_veiculo = :id
        LIMIT 1
    ");
=======
            SELECT v.*,
                   dono.nome  AS nome_morador,
                   dono.apto  AS apto,
                   dono.bloco AS bloco
            FROM veiculos v
            JOIN morador dono ON dono.id_user = v.id_user
            WHERE v.id_veiculo = :id
            LIMIT 1
        ");
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function existePlaca(string $placa): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM veiculos WHERE placa = :placa");
        $stmt->execute([':placa' => strtoupper($placa)]);
        return (int)$stmt->fetchColumn() > 0;
    }

<<<<<<< HEAD
    // Conta veículos de um usuário
    public function countByUser(int $id_user): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM veiculos WHERE id_user = :id");
        $stmt->execute([':id' => $id_user]);
        return (int)$stmt->fetchColumn();
    }

    // Desmarca todos os veículos principais de um usuário
    public function desmarcarPrincipal(int $id_user): bool
=======
    public function countByUser(int $idUser): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM veiculos WHERE id_user = :id");
        $stmt->execute([':id' => $idUser]);
        return (int)$stmt->fetchColumn();
    }

    public function desmarcarPrincipal(int $idUser): bool
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    {
        $stmt = $this->pdo->prepare("
            UPDATE veiculos SET principal = 0 WHERE id_user = :id
        ");
<<<<<<< HEAD
        return $stmt->execute([':id' => $id_user]);
    }

    // Marca um veículo como principal
    public function marcarPrincipal(int $id_veiculo): bool
=======
        return $stmt->execute([':id' => $idUser]);
    }

    public function marcarPrincipal(int $idVeiculo): bool
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    {
        $stmt = $this->pdo->prepare("
            UPDATE veiculos SET principal = 1 WHERE id_veiculo = :id
        ");
<<<<<<< HEAD
        return $stmt->execute([':id' => $id_veiculo]);
=======
        return $stmt->execute([':id' => $idVeiculo]);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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
<<<<<<< HEAD
        return (int) $stmt->fetchColumn();
=======
        return (int)$stmt->fetchColumn();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function topMarcas(int $limite = 3): array
    {
<<<<<<< HEAD
        $stmt = $this->pdo->prepare("
        SELECT marca, COUNT(id_veiculo) AS total
        FROM veiculos
        WHERE marca IS NOT NULL AND marca <> ''
        GROUP BY marca
        ORDER BY total DESC, marca ASC
        LIMIT :limite
    ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
=======
        return $this->topPorCampo('marca', $limite);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function topCores(int $limite = 3): array
    {
<<<<<<< HEAD
        $stmt = $this->pdo->prepare("
        SELECT cor, COUNT(id_veiculo) AS total
        FROM veiculos
        WHERE cor IS NOT NULL AND cor <> ''
        GROUP BY cor
        ORDER BY total DESC, cor ASC
        LIMIT :limite
    ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
=======
        return $this->topPorCampo('cor', $limite);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function topModelos(int $limite = 3): array
    {
<<<<<<< HEAD
        $stmt = $this->pdo->prepare("
        SELECT modelo, COUNT(id_veiculo) AS total
        FROM veiculos
        WHERE modelo IS NOT NULL AND modelo <> ''
        GROUP BY modelo
        ORDER BY total DESC, modelo ASC
        LIMIT :limite
    ");
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
