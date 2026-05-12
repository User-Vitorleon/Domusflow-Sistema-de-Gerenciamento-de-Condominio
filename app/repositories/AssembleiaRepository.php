<?php

class AssembleiaRepository{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function listar():array {
        $stmt = $this->pdo->query("SELECT a.*, m.nome as nome_autor
        FROM assembleias a
        INNER JOIN morador m ON a.id_user_cad = m.id_user
        WHERE a.status = 'A'
        ORDER BY a.data DESC");

        return $stmt->fetchAll();
    }    

    public function salvarAssembleia(array $dados):bool {
        $stmt = $this->pdo->prepare("INSERT INTO assembleias (titulo, data, hora, local, pauta, id_user_cad)
        VALUES (:titulo, :data, :hora, :local, :pauta, :id_user_cad)");
        return $stmt->execute([
            ':titulo'      => $dados['titulo'],
            ':data'        => $dados['data'],
            ':hora'        => $dados['hora'],
            ':local'       => $dados['local'],
            ':pauta'       => $dados['pauta'],
            ':id_user_cad' => $dados['id_user_cad'],
        ]);
    }

    public function confirmarPresenca(int $id_assembleia, int $id_user, string $presenca): bool{
        $stmt = $this->pdo->prepare("
            INSERT INTO assembleias_presencas (id_assembleia, id_user, presenca)
            VALUES (:id_assembleia, :id_user, :presenca)
            ON DUPLICATE KEY UPDATE presenca = :presenca2
        ");
        return $stmt->execute([
            ':id_assembleia' => $id_assembleia,
            ':id_user'       => $id_user,
            ':presenca'      => $presenca,
            ':presenca2'     => $presenca,
        ]);
    }

    public function excluir(int $id):bool{
        $stmt = $this->pdo->prepare("UPDATE assembleias SET status = 'I' WHERE id_assembleia = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function verificarPresenca(int $id_assembleia, int $id_user): ?string{
        $stmt = $this->pdo->prepare(" SELECT presenca FROM assembleias_presencas
        WHERE id_assembleia = :id_assembleia AND id_user = :id_user");
        
        $stmt->execute([
        ':id_assembleia' => $id_assembleia,
        ':id_user'       => $id_user,]);

        $result = $stmt->fetch();
        return $result ? $result['presenca'] : null;
    }
}

?>