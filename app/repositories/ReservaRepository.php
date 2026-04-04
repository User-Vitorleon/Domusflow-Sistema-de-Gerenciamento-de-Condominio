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

    // ── Verifica conflito de horário (apenas reservas aprovadas) ──
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

    // ── Verifica se morador já tem reserva pendente no dia ────────
    public function existePendenteNoDia(int $id_user, string $data): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM reservas
            WHERE id_user      = :id_user
              AND data_reserva = :data
              AND status       = 'P'
        ");
        $stmt->execute([':id_user' => $id_user, ':data' => $data]);
        return (int)$stmt->fetchColumn() > 0;
    }

    // ── Lista reservas de um usuário com nome do local ────────────
    public function findByUsuario(int $id_user): array
    {
        $stmt = $this->pdo->prepare("
            SELECT r.*, l.local AS nome_local
            FROM reservas r
            JOIN locais_festivos l ON l.id_local = r.id_local
            WHERE r.id_user = :id_user
            ORDER BY r.data_reserva DESC
        ");
        $stmt->execute([':id_user' => $id_user]);
        return $stmt->fetchAll();
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
}
