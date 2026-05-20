<<<<<<< HEAD
'<?php

class FinancasRepository
{

=======
<?php

class FinancasRepository
{
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function taxasCad(): array
    {
<<<<<<< HEAD
        $stmt = $this->pdo->query("SELECT * FROM taxas_padrao where status = 'A' ORDER BY descricao ASC");
=======
        $stmt = $this->pdo->query(
            "SELECT * FROM taxas_padrao WHERE status = 'A' ORDER BY descricao ASC"
        );
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        return $stmt->fetchAll();
    }

    public function salvarTaxas(array $dados): bool
    {
<<<<<<< HEAD
        $stmt = $this->pdo->prepare("INSERT INTO taxas_padrao (descricao, valor, status, usuario_cad, data_cad, modulo) VALUES (:descricao, :valor, 'A', :usuario_cad, CURDATE(), :modulo)");
        //                                                                                                                                                                    
        return $stmt->execute([
            ':descricao'    => $dados['descricao'],
            ':valor'        => $dados['valor'],
            ':usuario_cad'  => $_SESSION['usuario_nome'],
            ':modulo'       => $dados['modulo'],
        ]);
    }

    public function excluirTaxa(int $id): bool{
    
=======
        $stmt = $this->pdo->prepare("
            INSERT INTO taxas_padrao (descricao, valor, status, usuario_cad, data_cad, modulo)
            VALUES (:descricao, :valor, 'A', :usuario_cad, CURDATE(), :modulo)
        ");
        return $stmt->execute([
            ':descricao'   => $dados['descricao'],
            ':valor'       => $dados['valor'],
            ':usuario_cad' => $_SESSION['usuario_nome'],
            ':modulo'      => $dados['modulo'],
        ]);
    }

    public function excluirTaxa(int $id): bool
    {
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $stmt = $this->pdo->prepare(
            "UPDATE taxas_padrao SET status = 'I' WHERE id_taxa = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

    public function taxasPorModulo(string $modulo): array
    {
<<<<<<< HEAD
        $stmt = $this->pdo->prepare("SELECT * FROM taxas_padrao WHERE status = 'A' AND modulo = :modulo");
        $stmt->execute([':modulo' => $modulo]);
        return $stmt - fetchAll();
=======
        $stmt = $this->pdo->prepare(
            "SELECT * FROM taxas_padrao WHERE status = 'A' AND modulo = :modulo"
        );
        $stmt->execute([':modulo' => $modulo]);
        return $stmt->fetchAll();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function listarTodasTaxasAtivas(): array
    {
<<<<<<< HEAD
        $stmt = $this->pdo->query("SELECT * FROM taxas_padrao WHERE status = 'A' ORDER BY modulo, descricao");
        return $stmt->fetchAll();
    }

public function lancamento(int $id, int $privilegio, int $offset = 0, int $limite = 10, string $busca = '', string $status = '', string $dt_lanc = '', string $dt_venc = '', string $atraso = ''): array
{
    $where = '';
    $params = [];

    if ($busca) {
        $where .= " AND (m.nome LIKE :busca OR l.descricao LIKE :busca2 OR l.modelo LIKE :busca3)";
        $params[':busca']  = "%$busca%";
        $params[':busca2'] = "%$busca%";
        $params[':busca3'] = "%$busca%";
    }
    if ($status && $status !== 'atraso') {
        $where .= " AND l.status = :status";
        $params[':status'] = $status;
    }
    if ($atraso === '1' || $status === 'atraso') {
        $where .= " AND l.data_vencimento < CURDATE() AND l.status = 'P'";
    }
    if ($dt_lanc) {
        $where .= " AND DATE(l.data_lancamento) = :dt_lanc";
        $params[':dt_lanc'] = $dt_lanc;
    }
    if ($dt_venc) {
        $where .= " AND DATE(l.data_vencimento) = :dt_venc";
        $params[':dt_venc'] = $dt_venc;
    }

    if ($privilegio == 2 || $privilegio == 4) {
        $stmt = $this->pdo->prepare("
            SELECT l.*, m.nome as nome_morador, m.bloco, m.apto
            FROM lancamentos l 
            INNER JOIN morador m ON l.id_user = m.id_user
            WHERE 1=1 $where
            ORDER BY l.data_lancamento DESC
            LIMIT :limite OFFSET :offset
        ");
    } else {
        $where .= " AND l.id_user = :id";
        $params[':id'] = $id;
        $stmt = $this->pdo->prepare("
            SELECT l.* FROM lancamentos l
            WHERE 1=1 $where
            ORDER BY l.data_lancamento DESC
            LIMIT :limite OFFSET :offset
        ");
    }

    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v);
    }
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

public function excluirLancamento(int $id): bool{
    $stmt = $this->pdo->prepare("DELETE FROM lancamentos WHERE id_lancamento = :id");

    return $stmt->execute([':id' => $id]);
}

public function countLancamentos(int $id, int $privilegio, string $busca = '', string $status = '', string $dt_lanc = '', string $dt_venc = '', string $atraso = ''): int{
    $where  = '';
    $params = [];

    if ($busca) {
        $where .= " AND (m.nome LIKE :busca OR l.descricao LIKE :busca2 OR l.modelo LIKE :busca3)";
        $params[':busca']  = "%$busca%";
        $params[':busca2'] = "%$busca%";
        $params[':busca3'] = "%$busca%";
    }
    if ($status && $status !== 'atraso') {
        $where .= " AND l.status = :status";
        $params[':status'] = $status;
    }
    if ($atraso === '1' || $status === 'atraso') {
        $where .= " AND l.data_vencimento < CURDATE() AND l.status = 'P'";
    }
    if ($dt_lanc) {
        $where .= " AND DATE(l.data_lancamento) = :dt_lanc";
        $params[':dt_lanc'] = $dt_lanc;
    }
    if ($dt_venc) {
        $where .= " AND DATE(l.data_vencimento) = :dt_venc";
        $params[':dt_venc'] = $dt_venc;
    }

    if ($privilegio == 2 || $privilegio == 4) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM lancamentos l
            INNER JOIN morador m ON l.id_user = m.id_user
            WHERE 1=1 $where
        ");
    } else {
        $where .= " AND l.id_user = :id";
        $params[':id'] = $id;
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM lancamentos l
            WHERE 1=1 $where
        ");
    }

    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v);
    }
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}

    public function salvarLancamento(array $dados, int $id): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO lancamentos(modelo, valor, descricao, id_user, data_vencimento, status, data_lancamento, id_user_cad) 
                                        VALUES (:modelo,:valor,:descricao,:id_user,:data_venc,'P',:data_lanc,:id_user_cad)");

=======
        $stmt = $this->pdo->query(
            "SELECT * FROM taxas_padrao WHERE status = 'A' ORDER BY modulo, descricao"
        );
        return $stmt->fetchAll();
    }

    public function lancamento(
        int $id,
        int $privilegio,
        int $offset = 0,
        int $limite = 10,
        string $busca = '',
        string $status = '',
        string $dtLanc = '',
        string $dtVenc = '',
        string $atraso = ''
    ): array {
        $params = [];
        $where  = $this->montarWhereLancamentos($busca, $status, $dtLanc, $dtVenc, $atraso, $params);

        if ($privilegio === 2 || $privilegio === 4) {
            $sql = "
                SELECT l.*, m.nome AS nome_morador, m.bloco, m.apto
                FROM lancamentos l
                INNER JOIN morador m ON l.id_user = m.id_user
                WHERE 1=1 {$where}
                ORDER BY l.data_lancamento DESC
                LIMIT :limite OFFSET :offset
            ";
        } else {
            $where        .= ' AND l.id_user = :id';
            $params[':id'] = $id;
            $sql = "
                SELECT l.*
                FROM lancamentos l
                WHERE 1=1 {$where}
                ORDER BY l.data_lancamento DESC
                LIMIT :limite OFFSET :offset
            ";
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function excluirLancamento(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM lancamentos WHERE id_lancamento = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function countLancamentos(
        int $id,
        int $privilegio,
        string $busca = '',
        string $status = '',
        string $dtLanc = '',
        string $dtVenc = '',
        string $atraso = ''
    ): int {
        $params = [];
        $where  = $this->montarWhereLancamentos($busca, $status, $dtLanc, $dtVenc, $atraso, $params);

        if ($privilegio === 2 || $privilegio === 4) {
            $sql = "
                SELECT COUNT(*)
                FROM lancamentos l
                INNER JOIN morador m ON l.id_user = m.id_user
                WHERE 1=1 {$where}
            ";
        } else {
            $where        .= ' AND l.id_user = :id';
            $params[':id'] = $id;
            $sql = "
                SELECT COUNT(*)
                FROM lancamentos l
                WHERE 1=1 {$where}
            ";
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    private function montarWhereLancamentos(
        string $busca,
        string $status,
        string $dtLanc,
        string $dtVenc,
        string $atraso,
        array &$params
    ): string {
        $where = '';

        if ($busca !== '') {
            $where             .= ' AND (m.nome LIKE :busca OR l.descricao LIKE :busca2 OR l.modelo LIKE :busca3)';
            $params[':busca']   = "%{$busca}%";
            $params[':busca2']  = "%{$busca}%";
            $params[':busca3']  = "%{$busca}%";
        }
        if ($status !== '' && $status !== 'atraso') {
            $where            .= ' AND l.status = :status';
            $params[':status'] = $status;
        }
        if ($atraso === '1' || $status === 'atraso') {
            $where .= " AND l.data_vencimento < CURDATE() AND l.status = 'P'";
        }
        if ($dtLanc !== '') {
            $where             .= ' AND DATE(l.data_lancamento) = :dt_lanc';
            $params[':dt_lanc'] = $dtLanc;
        }
        if ($dtVenc !== '') {
            $where             .= ' AND DATE(l.data_vencimento) = :dt_venc';
            $params[':dt_venc'] = $dtVenc;
        }

        return $where;
    }

    public function salvarLancamento(array $dados, int $id): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO lancamentos
                (modelo, valor, descricao, id_user, data_vencimento, status, data_lancamento, id_user_cad)
            VALUES
                (:modelo, :valor, :descricao, :id_user, :data_venc, 'P', :data_lanc, :id_user_cad)
        ");
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        return $stmt->execute([
            ':modelo'      => $dados['modelo'],
            ':valor'       => $dados['valor'],
            ':descricao'   => $dados['descricao'],
            ':id_user'     => $dados['id_user'],
            ':data_venc'   => $dados['data_venc'],
            ':data_lanc'   => $dados['data_lanc'],
            ':id_user_cad' => $id,
        ]);
    }

<<<<<<< HEAD
    public function existeLancamentoNoMes(string $modelo, string $descricao, int $id_user, string $data_venc): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM lancamentos 
            WHERE modelo    = :modelo
            AND descricao = :descricao
            AND id_user   = :id_user
            AND status    = 'P'
            AND MONTH(data_vencimento) = MONTH(:data_venc1)
            AND YEAR(data_vencimento)  = YEAR(:data_venc2)
=======
    public function existeLancamentoNoMes(string $modelo, string $descricao, int $idUser, string $dataVenc): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM lancamentos
            WHERE modelo    = :modelo
              AND descricao = :descricao
              AND id_user   = :id_user
              AND status    = 'P'
              AND MONTH(data_vencimento) = MONTH(:data_venc1)
              AND YEAR(data_vencimento)  = YEAR(:data_venc2)
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        ");
        $stmt->execute([
            ':modelo'     => $modelo,
            ':descricao'  => $descricao,
<<<<<<< HEAD
            ':id_user'    => $id_user,
            ':data_venc1' => $data_venc,
            ':data_venc2' => $data_venc,
=======
            ':id_user'    => $idUser,
            ':data_venc1' => $dataVenc,
            ':data_venc2' => $dataVenc,
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        ]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function historico(int $id): array
    {
<<<<<<< HEAD
        $stmt = $this->pdo->prepare("SELECT * FROM lancamentos where id_user = :id AND status IN ('P', 'F')");
        $stmt->execute([
            ':id'   =>  $id,
        ]);

        return $stmt->fetchAll();
    }

    public function gerarFatura(int $id, $dados): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO faturas(id_user, data, valor_total, descricao, id_user_cad) 
                                        VALUES (:id_user, :data, :valor, :descricao, :id_user_cad)");
        $quey = $stmt->execute([
=======
        $stmt = $this->pdo->prepare(
            "SELECT * FROM lancamentos WHERE id_user = :id AND status IN ('P', 'F')"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll();
    }

    public function gerarFatura(int $id, array $dados): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO faturas (id_user, data, valor_total, descricao, id_user_cad)
            VALUES (:id_user, :data, :valor, :descricao, :id_user_cad)
        ");
        $sucesso = $stmt->execute([
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            ':id_user'     => $dados['id_user'],
            ':data'        => $dados['data'],
            ':valor'       => $dados['valor'],
            ':descricao'   => $dados['descricao'],
            ':id_user_cad' => $id,
        ]);

<<<<<<< HEAD
        if ($quey) {
            $id_fatura = (int)$this->pdo->lastInsertId();

            $stmt2 = $this->pdo->prepare("UPDATE lancamentos SET id_fatura = :id_fatura, status = 'F' WHERE id_user = :id_user AND status = 'P' ");

            $stmt2->execute([
                ':id_fatura' => $id_fatura,
                ':id_user'   => $dados['id_user'],
            ]);

            return $id_fatura > 0;
        }   

        return false;
    }

    public function totalPendente(int $id_user): float{
        $stmt = $this->pdo->prepare("
            SELECT COALESCE(SUM(valor), 0) 
            FROM lancamentos 
            WHERE id_user = :id_user 
            AND status = 'P'
        ");
        $stmt->execute([':id_user' => $id_user]);
=======
        if (!$sucesso) {
            return false;
        }

        $idFatura = (int)$this->pdo->lastInsertId();

        $stmt2 = $this->pdo->prepare("
            UPDATE lancamentos
            SET id_fatura = :id_fatura, status = 'F'
            WHERE id_user = :id_user AND status = 'P'
        ");
        $stmt2->execute([
            ':id_fatura' => $idFatura,
            ':id_user'   => $dados['id_user'],
        ]);

        return $idFatura > 0;
    }

    public function totalPendente(int $idUser): float
    {
        $stmt = $this->pdo->prepare("
            SELECT COALESCE(SUM(valor), 0)
            FROM lancamentos
            WHERE id_user = :id_user
              AND status = 'P'
        ");
        $stmt->execute([':id_user' => $idUser]);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        return (float)$stmt->fetchColumn();
    }

    public function totalGeralPendente(): float
    {
        $stmt = $this->pdo->query("
<<<<<<< HEAD
        SELECT COALESCE(SUM(valor), 0)
        FROM lancamentos
        WHERE status = 'P' AND id_fatura IS NULL
    ");
        return (float) $stmt->fetchColumn();
=======
            SELECT COALESCE(SUM(valor), 0)
            FROM lancamentos
            WHERE status = 'P' AND id_fatura IS NULL
        ");
        return (float)$stmt->fetchColumn();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function countLancamentosPendentes(): int
    {
        $stmt = $this->pdo->query("
<<<<<<< HEAD
        SELECT COUNT(id_lancamento)
        FROM lancamentos
        WHERE status = 'P' AND id_fatura IS NULL
    ");
        return (int) $stmt->fetchColumn();
=======
            SELECT COUNT(id_lancamento)
            FROM lancamentos
            WHERE status = 'P' AND id_fatura IS NULL
        ");
        return (int)$stmt->fetchColumn();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function countFaturasGeradas(): int
    {
<<<<<<< HEAD
        $stmt = $this->pdo->query("
        SELECT COUNT(id_fatura) FROM faturas
    ");
        return (int) $stmt->fetchColumn();
=======
        $stmt = $this->pdo->query("SELECT COUNT(id_fatura) FROM faturas");
        return (int)$stmt->fetchColumn();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function countMoradoresInadimplentes(): int
    {
        $stmt = $this->pdo->query("
<<<<<<< HEAD
        SELECT COUNT(DISTINCT id_user)
        FROM lancamentos
        WHERE status = 'P' AND id_fatura IS NULL
    ");
        return (int) $stmt->fetchColumn();
=======
            SELECT COUNT(DISTINCT id_user)
            FROM lancamentos
            WHERE status = 'P' AND id_fatura IS NULL
        ");
        return (int)$stmt->fetchColumn();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function ultimosMoradoresCadastrados(int $limite = 5): array
    {
        $stmt = $this->pdo->prepare("
<<<<<<< HEAD
        SELECT id_user, nome, apto, bloco, status, created_at
        FROM morador
        WHERE status != 'E'
        ORDER BY created_at DESC
        LIMIT :limite
    ");
=======
            SELECT id_user, nome, apto, bloco, status, created_at
            FROM morador
            WHERE status != 'E'
            ORDER BY created_at DESC
            LIMIT :limite
        ");
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
