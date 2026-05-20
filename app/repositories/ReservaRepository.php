<?php
<<<<<<< HEAD
=======

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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

<<<<<<< HEAD
    public function aprovar(int $id, int $id_user_aprov, string $nome_aprov): bool{
        $stmt = $this->pdo->prepare("UPDATE reservas SET status = 'A', id_user_aprov = :id_user_aprov, nome_user_aprov = :nome_aprov, data_aprov = CURDATE(), hora_aprov = CURTIME()
        WHERE id_reserva = :id");

        return $stmt ->execute([
            ':id_user_aprov' => $id_user_aprov,
            ':nome_aprov'    => $nome_aprov,
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            ':id'            => $id,
        ]);
    }

<<<<<<< HEAD
    public function existeConflito(int $id_local, string $data, string $hora_ini, string $hora_fim): bool
=======
    public function existeConflito(int $idLocal, string $data, string $horaIni, string $horaFim): bool
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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
<<<<<<< HEAD
            ':id_local' => $id_local,
            ':data'     => $data,
            ':hora_ini' => $hora_ini,
            ':hora_fim' => $hora_fim,
=======
            ':id_local' => $idLocal,
            ':data'     => $data,
            ':hora_ini' => $horaIni,
            ':hora_fim' => $horaFim,
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        ]);
        return (int)$stmt->fetchColumn() > 0;
    }

<<<<<<< HEAD
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
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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
<<<<<<< HEAD
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

=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarReservasPendentesGeral(int $offset = 0, int $limite = 10): array
    {
<<<<<<< HEAD
        $sql = "SELECT r.*, l.local, l.capacidade, m.nome as nome_morador, m.apto, m.bloco 
                FROM reservas r
                INNER JOIN locais_festivos l ON r.id_local = l.id_local
                INNER JOIN morador m ON r.id_user = m.id_user 
                WHERE r.status = 'P' 
                ORDER BY r.id_reserva ASC
                LIMIT :limite OFFSET :offset";
=======
        $sql = "
            SELECT r.*, l.local, l.capacidade, m.nome AS nome_morador, m.apto, m.bloco
            FROM reservas r
            INNER JOIN locais_festivos l ON r.id_local = l.id_local
            INNER JOIN morador m ON r.id_user = m.id_user
            WHERE r.status = 'P'
            ORDER BY r.id_reserva ASC
            LIMIT :limite OFFSET :offset
        ";
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
<<<<<<< HEAD

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existeReservaPendente(int $id_user): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM reservas WHERE id_user = :id_user and status = 'P'");
        $stmt->execute([':id_user' => $id_user]);
=======
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existeReservaPendente(int $idUser): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM reservas WHERE id_user = :id_user AND status = 'P'"
        );
        $stmt->execute([':id_user' => $idUser]);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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
<<<<<<< HEAD
        $sql = "UPDATE reservas SET status = :status WHERE id_reserva = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['status' => $status, 'id' => $id]);
=======
        $stmt = $this->pdo->prepare(
            "UPDATE reservas SET status = :status WHERE id_reserva = :id"
        );
        return $stmt->execute([':status' => $status, ':id' => $id]);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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
<<<<<<< HEAD
            SELECT r.*, l.local, m.email, m.nome as nome_morador
=======
            SELECT r.*, l.local, m.email, m.nome AS nome_morador
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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
<<<<<<< HEAD
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

=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
