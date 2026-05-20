<?php

<<<<<<< HEAD
class AssembleiaRepository{
=======
class AssembleiaRepository
{
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

<<<<<<< HEAD
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
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        return $stmt->execute([
            ':titulo'      => $dados['titulo'],
            ':data'        => $dados['data'],
            ':hora'        => $dados['hora'],
            ':local'       => $dados['local'],
            ':pauta'       => $dados['pauta'],
            ':id_user_cad' => $dados['id_user_cad'],
        ]);
    }

<<<<<<< HEAD
    public function confirmarPresenca(int $id_assembleia, int $id_user, string $presenca): bool{
=======
    public function confirmarPresenca(int $idAssembleia, int $idUser, string $presenca): bool
    {
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $stmt = $this->pdo->prepare("
            INSERT INTO assembleias_presencas (id_assembleia, id_user, presenca)
            VALUES (:id_assembleia, :id_user, :presenca)
            ON DUPLICATE KEY UPDATE presenca = :presenca2
        ");
        return $stmt->execute([
<<<<<<< HEAD
            ':id_assembleia' => $id_assembleia,
            ':id_user'       => $id_user,
=======
            ':id_assembleia' => $idAssembleia,
            ':id_user'       => $idUser,
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            ':presenca'      => $presenca,
            ':presenca2'     => $presenca,
        ]);
    }

<<<<<<< HEAD
    public function registrarPresencasPendentes (int $id_assembleia, array $moradores): void{
        $stmt = $this->pdo->prepare("INSERT IGNORE INTO assembleias_presencas (id_assembleia, id_user, presenca)
        VALUES (:id_assembleia, :id_user, 'P') where status = 'L' "); 
            foreach ($moradores as $m) {
            $stmt->execute([
                ':id_assembleia' => $id_assembleia,
=======
    public function registrarPresencasPendentes(int $idAssembleia, array $moradores): void
    {
        $stmt = $this->pdo->prepare("
            INSERT IGNORE INTO assembleias_presencas (id_assembleia, id_user, presenca)
            VALUES (:id_assembleia, :id_user, 'P')
        ");
        foreach ($moradores as $m) {
            $stmt->execute([
                ':id_assembleia' => $idAssembleia,
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
                ':id_user'       => $m['id_user'],
            ]);
        }
    }

<<<<<<< HEAD
    public function ultimoId(): int{
        return (int)$this->pdo->lastInsertId();
    }

    public function listarPresencas():array{
        $stmt = $this->pdo->query("SELECT 
            ap.presenca,
            ap.created_at,
            m.nome,
            m.apto,
            m.bloco,
            a.titulo,
            a.data as data_assembleia
        FROM assembleias_presencas ap
        INNER JOIN morador m ON ap.id_user = m.id_user
        INNER JOIN assembleias a ON ap.id_assembleia = a.id_assembleia
        ORDER BY a.data DESC, m.nome ASC");

        return $stmt->fetchAll();
    }

    public function excluir(int $id):bool{
=======
    public function ultimoId(): int
    {
        return (int)$this->pdo->lastInsertId();
    }

    public function listarPresencas(): array
    {
        $stmt = $this->pdo->query("
            SELECT
                ap.presenca,
                ap.created_at,
                m.nome,
                m.apto,
                m.bloco,
                a.titulo,
                a.data AS data_assembleia
            FROM assembleias_presencas ap
            INNER JOIN morador m ON ap.id_user = m.id_user
            INNER JOIN assembleias a ON ap.id_assembleia = a.id_assembleia
            ORDER BY a.data DESC, m.nome ASC
        ");
        return $stmt->fetchAll();
    }

    public function excluir(int $id): bool
    {
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $stmt = $this->pdo->prepare("UPDATE assembleias SET status = 'I' WHERE id_assembleia = :id");
        return $stmt->execute([':id' => $id]);
    }

<<<<<<< HEAD
    public function verificarPresenca(int $id_assembleia, int $id_user): ?string{
        $stmt = $this->pdo->prepare(" SELECT presenca FROM assembleias_presencas
        WHERE id_assembleia = :id_assembleia AND id_user = :id_user");
        
        $stmt->execute([
        ':id_assembleia' => $id_assembleia,
        ':id_user'       => $id_user,]);
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

        $result = $stmt->fetch();
        return $result ? $result['presenca'] : null;
    }
}
<<<<<<< HEAD

?>
=======
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
