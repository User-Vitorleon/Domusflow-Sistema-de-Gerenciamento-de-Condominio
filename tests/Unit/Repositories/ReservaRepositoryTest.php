<?php

namespace Tests\Unit\Repositories;

use ReservaRepository;
use Tests\Support\RepositoryTestCase;

final class ReservaRepositoryTest extends RepositoryTestCase
{
    private ReservaRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pdo->exec('
            CREATE TABLE reservas (
                id_reserva INTEGER PRIMARY KEY AUTOINCREMENT,
                id_local INTEGER NOT NULL,
                id_user INTEGER NOT NULL,
                data_reserva TEXT NOT NULL,
                hora_ini TEXT NOT NULL,
                hora_fim TEXT NOT NULL,
                status TEXT NOT NULL DEFAULT "P",
                id_user_aprov INTEGER NULL,
                nome_user_aprov TEXT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            )
        ');
        $this->pdo->exec('
            CREATE TABLE locais_festivos (
                id_local INTEGER PRIMARY KEY AUTOINCREMENT,
                local TEXT NOT NULL,
                capacidade INTEGER NOT NULL
            )
        ');
        $this->pdo->exec('
            CREATE TABLE morador (
                id_user INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT,
                email TEXT,
                apto TEXT,
                bloco TEXT
            )
        ');
        $this->pdo->exec("INSERT INTO locais_festivos (local, capacidade) VALUES ('Salao', 50)");
        $this->pdo->exec("INSERT INTO morador (nome, email, apto, bloco) VALUES ('Ana', 'ana@example.com', '101', 'A')");

        $this->repo = $this->repository(ReservaRepository::class);
    }

    public function testSaveCriaReservaPendente(): void
    {
        $this->assertTrue($this->repo->save([
            'id_local' => 1,
            'id_user' => 1,
            'data_reserva' => '2099-01-10',
            'hora_ini' => '10:00',
            'hora_fim' => '12:00',
        ]));

        $row = $this->pdo->query('SELECT * FROM reservas')->fetch();
        $this->assertSame('P', $row['status']);
        $this->assertSame('2099-01-10', $row['data_reserva']);
    }

    public function testExisteConflitoConsideraApenasReservasAprovadasSobrepostas(): void
    {
        $this->insertReserva('A', '10:00', '12:00');

        $this->assertTrue($this->repo->existeConflito(1, '2099-01-10', '11:00', '13:00'));
        $this->assertFalse($this->repo->existeConflito(1, '2099-01-10', '12:00', '13:00'));
    }

    public function testExisteReservaPendentePorUsuario(): void
    {
        $this->insertReserva('P', '10:00', '12:00', 1);
        $this->insertReserva('A', '13:00', '14:00', 2);

        $this->assertTrue($this->repo->existeReservaPendente(1));
        $this->assertFalse($this->repo->existeReservaPendente(2));
    }

    public function testBuscarReservasPendentesGeralComPaginacao(): void
    {
        $this->insertReserva('P', '10:00', '12:00');
        $this->insertReserva('A', '13:00', '14:00');
        $this->insertReserva('P', '15:00', '16:00');

        $pendentes = $this->repo->buscarReservasPendentesGeral(0, 10);

        $this->assertCount(2, $pendentes);
        $this->assertSame('Salao', $pendentes[0]['local']);
        $this->assertSame(2, $this->repo->countPendentesGeral());
    }

    public function testAtualizarStatus(): void
    {
        $this->insertReserva('P', '10:00', '12:00');

        $this->assertTrue($this->repo->atualizarStatus(1, 'N'));
        $this->assertSame('N', $this->pdo->query('SELECT status FROM reservas WHERE id_reserva = 1')->fetchColumn());
    }

    private function insertReserva(string $status, string $horaIni, string $horaFim, int $idUser = 1): void
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO reservas (id_local, id_user, data_reserva, hora_ini, hora_fim, status)
            VALUES (1, :id_user, "2099-01-10", :hora_ini, :hora_fim, :status)
        ');
        $stmt->execute([
            ':id_user' => $idUser,
            ':hora_ini' => $horaIni,
            ':hora_fim' => $horaFim,
            ':status' => $status,
        ]);
    }
}
