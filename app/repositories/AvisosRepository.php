<?php

    class AvisosRepository{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function listar():array{
        $stmt = $this->pdo->query("SELECT a.*, m.nome as nome_autor 
         FROM avisos a
         INNER JOIN morador m ON a.id_user_cad = m.id_user
         WHERE a.status = 'A'
         ORDER BY a.created_at DESC");

        return $stmt->fetchAll();
    }

    public function salvarAvisos (array $dados):bool {
        $stmt = $this->pdo->prepare(" INSERT INTO avisos (titulo, mensagem, id_user_cad) 
        VALUES (:titulo, :mensagem, :id_user_cad)");

        return $stmt->execute([
            ':titulo'      => $dados['titulo'],
            ':mensagem'    => $dados['mensagem'],
            ':id_user_cad' => $dados['id_user_cad'],        
        ]);
    }

    public function excluirAvisos(int $id):bool {
        $stmt = $this->pdo->prepare("UPDATE avisos SET status = 'I' WHERE id_aviso = :id");
            return $stmt->execute([':id' => $id]);              
    
    }

    public function contarNovos(string $desde): int{
    $stmt = $this->pdo->prepare("
        SELECT COUNT(*) FROM avisos 
        WHERE status = 'A' AND created_at > :desde
    ");
    $stmt->execute([':desde' => $desde]);
    return (int)$stmt->fetchColumn();
}

}
?>