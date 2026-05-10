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

    public function existeConflito(int $id_local, string $data, string $hora_ini, string $hora_fim): bool
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
            ':id_local' => $id_local,
            ':data'     => $data,
            ':hora_ini' => $hora_ini,
            ':hora_fim' => $hora_fim,
        ]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function negarConflitantes(int $id_local, string $data, string $hora_ini, string $hora_fim, int $id_reserva_aprovada): array
    {

        $hora_fim_mais_2 = date('H:i:s', strtotime($hora_fim . ' +2 hours'));
        $stmt = $this->pdo->prepare("SELECT r.*, m.email, m.nome as nome_morador
        FROM reservas r
        INNER JOIN morador m ON r.id_user = m.id_user
        WHERE r.id_local      = :id_local
        AND r.data_reserva  = :data
        AND r.status        = 'P'
        AND r.id_reserva   != :id_aprovada
        AND r.hora_ini     >= :hora_ini
        AND r.hora_ini      < :hora_fim_mais_2");

        $stmt->execute([
            ':id_local'    => $id_local,
            ':data'        => $data,
            ':id_aprovada' => $id_reserva_aprovada,
            ':hora_ini'    => $hora_ini,
            ':hora_fim_mais_2' => $hora_fim_mais_2,
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
        $sql = "SELECT r.*, l.local, l.capacidade, m.nome as nome_morador, m.apto, m.bloco 
                FROM reservas r
                INNER JOIN locais_festivos l ON r.id_local = l.id_local
                INNER JOIN morador m ON r.id_user = m.id_user 
                WHERE r.status = 'P' 
                ORDER BY r.data_reserva ASC
                LIMIT :limite OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existeReservaPendente(int $id_user): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM reservas WHERE id_user = :id_user and status = 'P'");
        $stmt->execute([':id_user' => $id_user]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function countPendentesGeral(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM reservas WHERE status = 'P'");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function atualizarStatus(int $id, string $status): bool
    {
        $sql = "UPDATE reservas SET status = :status WHERE id_reserva = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['status' => $status, 'id' => $id]);
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
            SELECT r.*, l.local, m.email, m.nome as nome_morador
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
