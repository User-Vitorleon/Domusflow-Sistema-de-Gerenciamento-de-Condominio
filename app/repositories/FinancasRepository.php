'<?php

class FinancasRepository
{

    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function taxasCad(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM taxas_padrao where status = 'A' ORDER BY descricao ASC");
        return $stmt->fetchAll();
    }

    public function salvarTaxas(array $dados): bool
    {
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
    
        $stmt = $this->pdo->prepare(
            "UPDATE taxas_padrao SET status = 'I' WHERE id_taxa = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

    public function taxasPorModulo(string $modulo): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM taxas_padrao WHERE status = 'A' AND modulo = :modulo");
        $stmt->execute([':modulo' => $modulo]);
        return $stmt - fetchAll();
    }

    public function listarTodasTaxasAtivas(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM taxas_padrao WHERE status = 'A' ORDER BY modulo, descricao");
        return $stmt->fetchAll();
    }

    public function lancamento(int $id, int $previlegio, int $offset = 0, int $limite = 10, string $busca = ''): array{
    if ($previlegio == 2 || $previlegio == 4) {
        $where = $busca ? "AND (m.nome LIKE :busca OR l.descricao LIKE :busca2 OR l.modelo LIKE :busca3)" : '';
        $stmt = $this->pdo->prepare("
            SELECT l.*, m.nome as nome_morador, m.bloco, m.apto
            FROM lancamentos l 
            INNER JOIN morador m ON l.id_user = m.id_user
            WHERE 1=1 $where
            ORDER BY l.data_lancamento DESC
            LIMIT :limite OFFSET :offset
        ");
        if ($busca) {
            $stmt->bindValue(':busca',  "%$busca%");
            $stmt->bindValue(':busca2', "%$busca%");
            $stmt->bindValue(':busca3', "%$busca%");
        }
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();

    } else if ($previlegio == 1) {
        $where = $busca ? "AND (l.descricao LIKE :busca OR l.modelo LIKE :busca2)" : '';
        $stmt = $this->pdo->prepare("
            SELECT * FROM lancamentos l
            WHERE id_user = :id $where
            ORDER BY data_vencimento DESC
            LIMIT :limite OFFSET :offset
        ");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if ($busca) {
            $stmt->bindValue(':busca',  "%$busca%");
            $stmt->bindValue(':busca2', "%$busca%");
        }
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();

    } else {
        return [];
    }
}

public function excluirLancamento(int $id): bool{
    $stmt = $this->pdo->prepare("DELETE FROM lancamentos WHERE id_lancamento = :id");

    return $stmt->execute([':id' => $id]);
}

public function countLancamentos(int $id, int $previlegio): int
{
    if ($previlegio == 2 || $previlegio == 4) {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM lancamentos");
    } else {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM lancamentos WHERE id_user = :id");
        $stmt->execute([':id' => $id]);
        return (int)$stmt->fetchColumn();
    }
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}

    public function salvarLancamento(array $dados, int $id): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO lancamentos(modelo, valor, descricao, id_user, data_vencimento, status, data_lancamento, id_user_cad) 
                                        VALUES (:modelo,:valor,:descricao,:id_user,:data_venc,'P',:data_lanc,:id_user_cad)");

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
        ");
        $stmt->execute([
            ':modelo'     => $modelo,
            ':descricao'  => $descricao,
            ':id_user'    => $id_user,
            ':data_venc1' => $data_venc,
            ':data_venc2' => $data_venc,
        ]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function historico(int $id): array
    {
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
            ':id_user'     => $dados['id_user'],
            ':data'        => $dados['data'],
            ':valor'       => $dados['valor'],
            ':descricao'   => $dados['descricao'],
            ':id_user_cad' => $id,
        ]);

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
        return (float)$stmt->fetchColumn();
    }

    public function totalGeralPendente(): float
    {
        $stmt = $this->pdo->query("
        SELECT COALESCE(SUM(valor), 0)
        FROM lancamentos
        WHERE status = 'P' AND id_fatura IS NULL
    ");
        return (float) $stmt->fetchColumn();
    }

    public function countLancamentosPendentes(): int
    {
        $stmt = $this->pdo->query("
        SELECT COUNT(id_lancamento)
        FROM lancamentos
        WHERE status = 'P' AND id_fatura IS NULL
    ");
        return (int) $stmt->fetchColumn();
    }

    public function countFaturasGeradas(): int
    {
        $stmt = $this->pdo->query("
        SELECT COUNT(id_fatura) FROM faturas
    ");
        return (int) $stmt->fetchColumn();
    }

    public function countMoradoresInadimplentes(): int
    {
        $stmt = $this->pdo->query("
        SELECT COUNT(DISTINCT id_user)
        FROM lancamentos
        WHERE status = 'P' AND id_fatura IS NULL
    ");
        return (int) $stmt->fetchColumn();
    }

    public function ultimosMoradoresCadastrados(int $limite = 5): array
    {
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
