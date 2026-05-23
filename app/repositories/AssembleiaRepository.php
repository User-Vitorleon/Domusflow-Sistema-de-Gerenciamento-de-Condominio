<?php

class AssembleiaRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function listar(): array
    {
        $stmt = $this->pdo->query("
            SELECT a.*, m.nome AS nome_autor
            FROM assembleias a
            INNER JOIN morador m ON a.id_user_cad = m.id_user
            WHERE a.status = 'A'
            ORDER BY a.data DESC
        ");
        return $stmt->fetchAll();
    }

    public function salvarAssembleia(array $dados): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO assembleias (titulo, data, hora, local, pauta, id_user_cad)
            VALUES (:titulo, :data, :hora, :local, :pauta, :id_user_cad)
        ");
        return $stmt->execute([
            ':titulo'      => $dados['titulo'],
            ':data'        => $dados['data'],
            ':hora'        => $dados['hora'],
            ':local'       => $dados['local'],
            ':pauta'       => $dados['pauta'],
            ':id_user_cad' => $dados['id_user_cad'],
        ]);
    }

    public function confirmarPresenca(int $idAssembleia, int $idUser, string $presenca): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO assembleias_presencas (id_assembleia, id_user, presenca)
            VALUES (:id_assembleia, :id_user, :presenca)
            ON DUPLICATE KEY UPDATE presenca = :presenca2
        ");
        return $stmt->execute([
            ':id_assembleia' => $idAssembleia,
            ':id_user'       => $idUser,
            ':presenca'      => $presenca,
            ':presenca2'     => $presenca,
        ]);
    }

    public function registrarPresencasPendentes(int $idAssembleia, array $moradores): void
    {
        $stmt = $this->pdo->prepare("
            INSERT IGNORE INTO assembleias_presencas (id_assembleia, id_user, presenca)
            VALUES (:id_assembleia, :id_user, 'P')
        ");
        foreach ($moradores as $m) {
            $stmt->execute([
                ':id_assembleia' => $idAssembleia,
                ':id_user'       => $m['id_user'],
            ]);
        }
    }

    public function ultimoId(): int
    {
        return (int)$this->pdo->lastInsertId();
    }

    public function findById(int $id): ?array{
        $stmt = $this->pdo->prepare("
            SELECT * FROM assembleias WHERE id_assembleia = :id LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function listarPresencas(int $idAssembleia = 0): array{
        $where = $idAssembleia ? 'AND ap.id_assembleia = :id' : '';
        $stmt  = $this->pdo->prepare("
            SELECT ap.presenca, ap.created_at, m.nome, m.apto, m.bloco, a.titulo, a.data as data_assembleia
            FROM assembleias_presencas ap
            INNER JOIN morador m ON ap.id_user = m.id_user
            INNER JOIN assembleias a ON ap.id_assembleia = a.id_assembleia
            WHERE a.status = 'A' {$where}
            ORDER BY m.nome ASC
        ");
        $params = $idAssembleia ? [':id' => $idAssembleia] : [];
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function listarPresencasAgrupadas(): array{
        $stmt = $this->pdo->query("
            SELECT 
                a.id_assembleia,
                a.titulo,
                a.data,
                a.hora,
                a.local,
                COUNT(CASE WHEN ap.presenca = 'S' THEN 1 END) AS confirmados,
                COUNT(CASE WHEN ap.presenca = 'N' THEN 1 END) AS negados,
                COUNT(CASE WHEN ap.presenca = 'P' THEN 1 END) AS pendentes,
                COUNT(ap.id_presenca) AS total
            FROM assembleias a
            LEFT JOIN assembleias_presencas ap ON a.id_assembleia = ap.id_assembleia
            WHERE a.status = 'A'
            GROUP BY a.id_assembleia
            ORDER BY a.data DESC
        ");
        return $stmt->fetchAll();
    }


    public function excluir(int $id): bool{

        $stmt = $this->pdo->prepare("
            DELETE FROM assembleias_presencas WHERE id_assembleia = :id
        ");
        $stmt->execute([':id' => $id]);


        $stmt2 = $this->pdo->prepare("
            UPDATE assembleias SET status = 'I' WHERE id_assembleia = :id
        ");
        return $stmt2->execute([':id' => $id]);
    }

    public function verificarPresenca(int $idAssembleia, int $idUser): ?string
    {
        $stmt = $this->pdo->prepare("
            SELECT presenca
            FROM assembleias_presencas
            WHERE id_assembleia = :id_assembleia AND id_user = :id_user
        ");
        $stmt->execute([
            ':id_assembleia' => $idAssembleia,
            ':id_user'       => $idUser,
        ]);

        $result = $stmt->fetch();
        return $result ? $result['presenca'] : null;
    }
}
