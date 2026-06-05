<?php

class ReservaRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getConnection();
    }

    public function save(array $data): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO reservas (id_local, id_user, data_reserva, hora_ini, hora_fim, status)
            VALUES (:id_local, :id_user, :data_reserva, :hora_ini, :hora_fim, 'P')
        ");
        return $stmt->execute([
            ':id_local'     => $data['id_local'],
            ':id_user'      => $data['id_user'],
            ':data_reserva' => $data['data_reserva'],
            ':hora_ini'     => $data['hora_ini'],
            ':hora_fim'     => $data['hora_fim'],
        ]);
    }

    public function aprovar(int $id, int $idUserAprov, string $nomeAprov): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE reservas
            SET status          = 'A',
                id_user_aprov   = :id_user_aprov,
                nome_user_aprov = :nome_aprov,
                data_aprov      = CURDATE(),
                hora_aprov      = CURTIME()
            WHERE id_reserva = :id
        ");
        return $stmt->execute([
            ':id_user_aprov' => $idUserAprov,
            ':nome_aprov'    => $nomeAprov,
            ':id'            => $id,
        ]);
    }

    public function existeConflito(int $idLocal, string $data, string $horaIni, string $horaFim): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM reservas
            WHERE id_local     = :id_local
              AND data_reserva = :data
              AND status       = 'A'
              AND hora_ini     < :hora_fim
              AND hora_fim     > :hora_ini
        ");
        $stmt->execute([
            ':id_local' => $idLocal,
            ':data'     => $data,
            ':hora_ini' => $horaIni,
            ':hora_fim' => $horaFim,
        ]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function negarConflitantes(
        int $idLocal,
        string $data,
        string $horaIni,
        string $horaFim,
        int $idReservaAprovada
    ): array {
        $horaFimMais2 = date('H:i:s', strtotime($horaFim . ' +2 hours'));

        $stmt = $this->pdo->prepare("
            SELECT r.*, m.email, m.nome AS nome_morador
            FROM reservas r
            INNER JOIN morador m ON r.id_user = m.id_user
            WHERE r.id_local     = :id_local
              AND r.data_reserva = :data
              AND r.status       = 'P'
              AND r.id_reserva  != :id_aprovada
              AND r.hora_ini    >= :hora_ini
              AND r.hora_ini     < :hora_fim_mais_2
        ");

        $stmt->execute([
            ':id_local'        => $idLocal,
            ':data'            => $data,
            ':id_aprovada'     => $idReservaAprovada,
            ':hora_ini'        => $horaIni,
            ':hora_fim_mais_2' => $horaFimMais2,
        ]);

        $conflitantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($conflitantes as $r) {
            $this->atualizarStatus($r['id_reserva'], 'N');
        }

        return $conflitantes;
    }

    public function buscarReservasDashboardPorUsuario(int $idUser): array
    {
        $sql = "
            SELECT
                r.id_reserva,
                r.data_reserva,
                r.hora_ini,
                r.hora_fim,
                r.status,
                r.nome_user_aprov,
                l.local
            FROM reservas r
            INNER JOIN locais_festivos l ON l.id_local = r.id_local
            WHERE r.id_user = :id_user
              AND (
                    r.data_reserva >= CURDATE()
                    OR r.id_reserva = (
                        SELECT r2.id_reserva
                        FROM reservas r2
                        WHERE r2.id_user = r.id_user
                          AND r2.data_reserva < CURDATE()
                        ORDER BY r2.data_reserva DESC, r2.hora_fim DESC, r2.id_reserva DESC
                        LIMIT 1
                    )
              )
            ORDER BY
                CASE WHEN r.data_reserva < CURDATE() THEN 0 ELSE 1 END,
                r.data_reserva ASC,
                r.hora_ini ASC
            LIMIT 15
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_user' => $idUser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarReservasPendentesGeral(int $offset = 0, int $limite = 10): array
    {
        $sql = "
            SELECT r.*, l.local, l.capacidade, m.nome AS nome_morador, m.apto, m.bloco
            FROM reservas r
            INNER JOIN locais_festivos l ON r.id_local = l.id_local
            INNER JOIN morador m ON r.id_user = m.id_user
            WHERE r.status = 'P'
            ORDER BY r.id_reserva ASC
            LIMIT :limite OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPendentesComFiltros(array $filtros, int $offset = 0, int $limite = 10): array
    {
        $params = $this->montarFiltrosPendentes($filtros);
        $sql = "
            SELECT r.*, l.local, l.capacidade, m.nome AS nome_morador, m.apto, m.bloco
            FROM reservas r
            INNER JOIN locais_festivos l ON r.id_local = l.id_local
            INNER JOIN morador m ON r.id_user = m.id_user
            WHERE r.status = 'P'
            {$params['sql']}
            ORDER BY r.created_at ASC, m.nome ASC, r.data_reserva ASC, r.hora_ini ASC
            LIMIT :limite OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params['bindings'] as $chave => $valor) {
            $stmt->bindValue($chave, $valor);
        }
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existeReservaPendente(int $idUser): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM reservas WHERE id_user = :id_user AND status = 'P'"
        );
        $stmt->execute([':id_user' => $idUser]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function buscarHistoricoPorUsuario(int $idUser, array $filtros, int $offset = 0, int $limite = 10): array
    {
        $params = $this->montarFiltrosHistorico($filtros);
        $sql = "
            SELECT r.*, l.local
            FROM reservas r
            INNER JOIN locais_festivos l ON r.id_local = l.id_local
            WHERE r.id_user = :id_user
            {$params['sql']}
            ORDER BY r.created_at DESC, r.data_reserva DESC, r.hora_ini DESC
            LIMIT :limite OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        foreach ($params['bindings'] as $chave => $valor) {
            $stmt->bindValue($chave, $valor);
        }
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countHistoricoPorUsuario(int $idUser, array $filtros): int
    {
        $params = $this->montarFiltrosHistorico($filtros);
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM reservas r
            INNER JOIN locais_festivos l ON r.id_local = l.id_local
            WHERE r.id_user = :id_user
            {$params['sql']}
        ");
        $stmt->bindValue(':id_user', $idUser, PDO::PARAM_INT);
        foreach ($params['bindings'] as $chave => $valor) {
            $stmt->bindValue($chave, $valor);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function countPendentesGeral(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM reservas WHERE status = 'P'");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function countPendentesComFiltros(array $filtros): int
    {
        $params = $this->montarFiltrosPendentes($filtros);
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM reservas r
            INNER JOIN locais_festivos l ON r.id_local = l.id_local
            INNER JOIN morador m ON r.id_user = m.id_user
            WHERE r.status = 'P'
            {$params['sql']}
        ");
        $stmt->execute($params['bindings']);
        return (int)$stmt->fetchColumn();
    }

    private function montarFiltrosPendentes(array $filtros): array
    {
        $sql = '';
        $bindings = [];

        if (!empty($filtros['nome'])) {
            $sql .= ' AND m.nome LIKE :nome';
            $bindings[':nome'] = '%' . $filtros['nome'] . '%';
        }
        if (!empty($filtros['bloco'])) {
            $sql .= ' AND m.bloco LIKE :bloco';
            $bindings[':bloco'] = '%' . $filtros['bloco'] . '%';
        }
        if (!empty($filtros['apto'])) {
            $sql .= ' AND m.apto LIKE :apto';
            $bindings[':apto'] = '%' . $filtros['apto'] . '%';
        }
        if (!empty($filtros['data_solicitacao'])) {
            $sql .= ' AND DATE(r.created_at) = :data_solicitacao';
            $bindings[':data_solicitacao'] = $filtros['data_solicitacao'];
        }
        if (!empty($filtros['data_reserva'])) {
            $sql .= ' AND r.data_reserva = :data_reserva';
            $bindings[':data_reserva'] = $filtros['data_reserva'];
        }

        return ['sql' => $sql, 'bindings' => $bindings];
    }

    private function montarFiltrosHistorico(array $filtros): array
    {
        $sql = '';
        $bindings = [];

        if (!empty($filtros['local'])) {
            $sql .= ' AND l.local LIKE :local';
            $bindings[':local'] = '%' . $filtros['local'] . '%';
        }
        if (!empty($filtros['data_solicitacao'])) {
            $sql .= ' AND DATE(r.created_at) = :data_solicitacao';
            $bindings[':data_solicitacao'] = $filtros['data_solicitacao'];
        }
        if (!empty($filtros['data_reserva'])) {
            $sql .= ' AND r.data_reserva = :data_reserva';
            $bindings[':data_reserva'] = $filtros['data_reserva'];
        }

        return ['sql' => $sql, 'bindings' => $bindings];
    }

    public function atualizarStatus(int $id, string $status): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE reservas SET status = :status WHERE id_reserva = :id"
        );
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }

    public function countByStatus(string $status): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM reservas WHERE status = :status");
        $stmt->execute([':status' => $status]);
        return (int)$stmt->fetchColumn();
    }

    public function countPorMes(int $ano): array
    {
        $stmt = $this->pdo->prepare("
            SELECT MONTH(data_reserva) AS mes, COUNT(*) AS total
            FROM reservas
            WHERE YEAR(data_reserva) = :ano
            GROUP BY MONTH(data_reserva)
        ");
        $stmt->execute([':ano' => $ano]);
        $dados = array_fill(0, 12, 0);
        foreach ($stmt->fetchAll() as $row) {
            $dados[(int)$row['mes'] - 1] = (int)$row['total'];
        }
        return $dados;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT r.*, l.local, m.email, m.nome AS nome_morador
            FROM reservas r
            INNER JOIN locais_festivos l ON r.id_local = l.id_local
            INNER JOIN morador m ON r.id_user = m.id_user
            WHERE r.id_reserva = :id
        ");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function buscarReservasSemana(int $limite = 5): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                r.id_reserva,
                r.data_reserva,
                r.hora_ini,
                r.hora_fim,
                r.status,
                l.local,
                m.nome AS nome_morador,
                m.apto,
                m.bloco
            FROM reservas r
            INNER JOIN locais_festivos l ON l.id_local = r.id_local
            INNER JOIN morador m ON m.id_user = r.id_user
            WHERE r.data_reserva BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
            ORDER BY r.data_reserva ASC, r.hora_ini ASC
            LIMIT :limite
        ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
