<?php

namespace Tests\Unit\Repositories;

use LocalRepository;
use Tests\Support\RepositoryTestCase;

final class LocalRepositoryTest extends RepositoryTestCase
{
    private LocalRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pdo->exec('
            CREATE TABLE locais_festivos (
                id_local INTEGER PRIMARY KEY AUTOINCREMENT,
                local TEXT NOT NULL,
                capacidade INTEGER NOT NULL,
                disp_uso TEXT NOT NULL,
                id_user_cad INTEGER,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            )
        ');

        $this->repo = $this->repository(LocalRepository::class);
    }

    public function testSaveEFindById(): void
    {
        $this->assertTrue($this->repo->save([
            'local' => 'Salao',
            'capacidade' => 50,
            'disp_uso' => 'S',
            'id_user_cad' => 2,
        ]));

        $local = $this->repo->findById(1);

        $this->assertSame('Salao', $local['local']);
        $this->assertSame(50, (int)$local['capacidade']);
        $this->assertSame('S', $local['disp_uso']);
    }

    public function testFindDisponiveisRetornaSomenteLocaisEmUso(): void
    {
        $this->repo->save(['local' => 'Salao', 'capacidade' => 50, 'disp_uso' => 'S', 'id_user_cad' => 1]);
        $this->repo->save(['local' => 'Piscina', 'capacidade' => 20, 'disp_uso' => 'N', 'id_user_cad' => 1]);

        $locais = $this->repo->findDisponiveis();

        $this->assertCount(1, $locais);
        $this->assertSame('Salao', $locais[0]['local']);
    }

    public function testUpdateAlteraDadosDoLocal(): void
    {
        $this->repo->save(['local' => 'Salao', 'capacidade' => 50, 'disp_uso' => 'S', 'id_user_cad' => 1]);

        $this->assertTrue($this->repo->update(1, [
            'local' => 'Churrasqueira',
            'capacidade' => 30,
            'disp_uso' => 'N',
        ]));

        $local = $this->repo->findById(1);
        $this->assertSame('Churrasqueira', $local['local']);
        $this->assertSame('N', $local['disp_uso']);
    }

    public function testCountDisponiveis(): void
    {
        $this->repo->save(['local' => 'Salao', 'capacidade' => 50, 'disp_uso' => 'S', 'id_user_cad' => 1]);
        $this->repo->save(['local' => 'Piscina', 'capacidade' => 20, 'disp_uso' => 'S', 'id_user_cad' => 1]);
        $this->repo->save(['local' => 'Quadra', 'capacidade' => 10, 'disp_uso' => 'N', 'id_user_cad' => 1]);

        $this->assertSame(2, $this->repo->countDisponiveis());
    }
}
