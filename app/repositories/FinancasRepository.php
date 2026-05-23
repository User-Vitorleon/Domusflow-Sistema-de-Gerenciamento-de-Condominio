<?php

class FinancasRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function taxasCad(): array
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM taxas_padrao WHERE status = 'A' ORDER BY descricao ASC"
        );
        return $stmt->fetchAll();
    }

    public function salvarTaxas(array $dados): bool
    {
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
        $stmt = $this->pdo->prepare(
            "UPDATE taxas_padrao SET status = 'I' WHERE id_taxa = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

    public function taxasPorModulo(string $modulo): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM taxas_padrao WHERE status = 'A' AND modulo = :modulo"
        );
        $stmt->execute([':modulo' => $modulo]);
        return $stmt->fetchAll();
    }

    public function listarTodasTaxasAtivas(): array
    {
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
                (:modelo, :valor, :descricao, :id_user, :data_venc, 'F', :data_lanc, :id_user_cad)
        ");
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
        ");
        $stmt->execute([
            ':modelo'     => $modelo,
            ':descricao'  => $descricao,
            ':id_user'    => $idUser,
            ':data_venc1' => $dataVenc,
            ':data_venc2' => $dataVenc,
        ]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function historico(int $id): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM lancamentos WHERE id_user = :id AND status IN ('F', 'G')"
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
            ':id_user'     => $dados['id_user'],
            ':data'        => $dados['data'],
            ':valor'       => $dados['valor'],
            ':descricao'   => $dados['descricao'],
            ':id_user_cad' => $id,
        ]);

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

    public function gerarFaturaUnica(int $id, int $idLancamento): bool
{
    $lancamento = $this->findLancamentoById($idLancamento);

    if (!$lancamento) {
        return false;
    }

    $stmt = $this->pdo->prepare("
        INSERT INTO faturas (id_user, data, valor_total, descricao, id_user_cad)
        VALUES (:id_user, :data, :valor, :descricao, :id_user_cad)
    ");
    $sucesso = $stmt->execute([
        ':id_user'     => $lancamento['id_user'],
        ':data'        => date('Y-m-d'),
        ':valor'       => $lancamento['valor'],
        ':descricao'   => $lancamento['descricao'],
        ':id_user_cad' => $id,
    ]);

    if (!$sucesso) {
        return false;
    }

    $idFatura = (int)$this->pdo->lastInsertId();

    $stmt2 = $this->pdo->prepare("
        UPDATE lancamentos SET id_fatura = :id_fatura, status = 'F'
        WHERE id_lancamento = :id_lancamento AND status = 'P'
    ");
    $stmt2->execute([
        ':id_fatura'     => $idFatura,
        ':id_lancamento' => $idLancamento,
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
        return (float)$stmt->fetchColumn();
    }

    public function marcarComoPago(int $idLancamento): bool{
        $stmt = $this->pdo->prepare("
            UPDATE lancamentos
            SET status = 'G'
            WHERE id_lancamento = :id
            AND status = 'F'
        ");
        return $stmt->execute([':id' => $idLancamento]);
    }

    public function findLancamentoById(int $id): ?array{
        $stmt = $this->pdo->prepare("
            SELECT l.*, m.nome, m.apto, m.bloco, m.cpf
            FROM lancamentos l
            INNER JOIN morador m ON l.id_user = m.id_user
            WHERE l.id_lancamento = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function totalGeralPendente(): float{
        $stmt = $this->pdo->query("
            SELECT COALESCE(SUM(valor), 0)
            FROM lancamentos
            WHERE status = 'P' AND id_fatura IS NULL
        ");
        return (float)$stmt->fetchColumn();
    }

    public function countLancamentosPendentes(): int{
        $stmt = $this->pdo->query("
            SELECT COUNT(id_lancamento)
            FROM lancamentos
            WHERE status = 'P' AND id_fatura IS NULL
        ");
        return (int)$stmt->fetchColumn();
    }

    public function countFaturasGeradas(): int{
        $stmt = $this->pdo->query("SELECT COUNT(id_fatura) FROM faturas");
        return (int)$stmt->fetchColumn();
    }

    public function countMoradoresInadimplentes(): int{
        $stmt = $this->pdo->query("
            SELECT COUNT(DISTINCT id_user)
            FROM lancamentos
            WHERE status = 'P' AND id_fatura IS NULL
        ");
        return (int)$stmt->fetchColumn();
    }

    public function ultimosMoradoresCadastrados(int $limite = 5): array{
        $stmt = $this->pdo->prepare("
            SELECT id_user, nome, apto, bloco, status, created_at
            FROM morador
            WHERE status != 'E'
            ORDER BY created_at DESC
            LIMIT :limite
        ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
