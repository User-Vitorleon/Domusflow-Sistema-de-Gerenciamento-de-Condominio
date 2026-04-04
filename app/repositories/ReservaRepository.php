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
            VALUES (:id_local, :id_user, :data_reserva, :hora_ini, :hora_fim, :status)
        ");
        return $stmt->execute([
            ':id_local'     => $data['id_local'],
            ':id_user'      => $data['id_user'],
            ':data_reserva' => $data['data_reserva'],
            ':hora_ini'     => $data['hora_ini'],
            ':hora_fim'     => $data['hora_fim'],
            ':status'       => 'P',
        ]);
    }

    public function countByStatus(string $status): int
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM reservas WHERE status = :status"
        );
        $stmt->execute([':status' => $status]);
        return (int)$stmt->fetchColumn();
    }

    public function countPorMes(int $ano): array
    {
        $stmt = $this->pdo->prepare("
            SELECT MONTH(data_reserva) as mes, COUNT(*) as total
            FROM reservas
            WHERE YEAR(data_reserva) = :ano
            GROUP BY MONTH(data_reserva)
        ");
        $stmt->execute([':ano' => $ano]);
        $rows = $stmt->fetchAll();

        // Preenche os 12 meses com 0 por padrão
        $dados = array_fill(0, 12, 0);
        foreach ($rows as $row) {
            $dados[(int)$row['mes'] - 1] = (int)$row['total'];
        }
        return $dados;
    }
}
