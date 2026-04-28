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

    public function existeEmail(string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM morador WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function findPendentes(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM morador WHERE status = 'P' ORDER BY nome ASC");
        return $stmt->fetchAll();
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
            ':iden'   => 1, // 1 para Morador comum
            ':nome'   => $data['nome'],
            ':apto'   => $data['apto'],
            ':bloco'  => $data['bloco'],
            ':cpf'    => $data['cpf'],
            ':email'  => $data['email'],
            ':cell'   => $data['telefone'],
            ':recado' => $data['telefone_recado'] ?? null,
            ':senha'  => $data['senha'],
            ':status' => 'P', // Sempre nasce como Pendente
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

    public function atualizarDados(array $update){
        if (empty($update['senha'])){
            $stmt = $this->pdo->prepare(
                "UPDATE morador SET nome = :nome, email = :email, apto = :apto, bloco = :bloco, telefone = :telefone, tell_recado = :tell_recado WHERE id_user = :id"
                );
                return $stmt->execute([
                            'nome' => $update['nome'],
                            'email' => $update['email'],
                            'apto' => $update['apto'],
                            'bloco' => $update['bloco'], 
                            'telefone' => $update['telefone'],
                            'tell_recado' => $update['tell_recado'],
                            'id' => $update['id']
                    ]);
        }else{
            $stmt = $this->pdo->prepare(
                "UPDATE morador SET nome = :nome, email = :email, apto = :apto, bloco = :bloco, telefone = :telefone, tell_recado = :tell_recado, senha = :senha WHERE id_user = :id"
                );
                return $stmt->execute([
                            'nome' => $update['nome'],
                            'email' => $update['email'],
                            'apto' => $update['apto'],
                            'bloco' => $update['bloco'], 
                            'telefone' => $update['telefone'],
                            'tell_recado' => $update['tell_recado'],
                            'senha' => $update['senha'],
                            'id' => $update['id']
                    ]);
        }
    }
    
    public function deletarDados(int $id): bool {
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
            ':id'    => $id
        ]);
    }
}


