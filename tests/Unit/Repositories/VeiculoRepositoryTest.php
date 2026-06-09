<?php

namespace Tests\Unit\Repositories;

use CryptoHelper;
use Tests\Support\RepositoryTestCase;
use VeiculoRepository;

final class VeiculoRepositoryTest extends RepositoryTestCase
{
    private VeiculoRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pdo->exec('
            CREATE TABLE morador (
                id_user INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT,
                apto TEXT,
                bloco TEXT
            )
        ');
        $this->pdo->exec('
            CREATE TABLE veiculos (
                id_veiculo INTEGER PRIMARY KEY AUTOINCREMENT,
                placa TEXT NOT NULL,
                marca TEXT NOT NULL,
                modelo TEXT NOT NULL,
                cor TEXT NOT NULL,
                principal INTEGER DEFAULT 0,
                id_user INTEGER NOT NULL,
                id_user_cad INTEGER NOT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            )
        ');

        $this->insertMorador('Ana', '101', 'A');
        $this->insertMorador('Sindico', '0', 'G');
        $this->repo = $this->repository(VeiculoRepository::class);
    }

    public function testSaveNormalizaPlacaERetornaId(): void
    {
        $id = $this->repo->save([
            'placa' => 'abc1234',
            'marca' => 'Fiat',
            'modelo' => 'Uno',
            'cor' => 'Prata',
            'principal' => 1,
            'id_user' => 1,
            'id_user_cad' => 2,
        ]);

        $this->assertSame(1, $id);
        $this->assertSame('ABC1234', $this->pdo->query('SELECT placa FROM veiculos')->fetchColumn());
    }

    public function testFindByPlacaRetornaDadosComNomeDescriptografado(): void
    {
        $this->insertVeiculo('ABC1234', 'Fiat', 'Uno', 'Prata', 1);

        $veiculo = $this->repo->findByPlaca('abc1234');

        $this->assertSame('ABC1234', $veiculo['placa']);
        $this->assertSame('Ana', $veiculo['nome_morador']);
        $this->assertSame('Sindico', $veiculo['cadastrado_por']);
    }

    public function testExistePlacaECountByUser(): void
    {
        $this->insertVeiculo('ABC1234', 'Fiat', 'Uno', 'Prata', 1);
        $this->insertVeiculo('DEF5678', 'Honda', 'Fit', 'Branco', 1);

        $this->assertTrue($this->repo->existePlaca('abc1234'));
        $this->assertFalse($this->repo->existePlaca('zzz9999'));
        $this->assertSame(2, $this->repo->countByUser(1));
    }

    public function testUpdateEDefinirPrincipal(): void
    {
        $this->insertVeiculo('ABC1234', 'Fiat', 'Uno', 'Prata', 1, 1);
        $this->insertVeiculo('DEF5678', 'Honda', 'Fit', 'Branco', 0, 1);

        $this->assertTrue($this->repo->update(1, [
            'placa' => 'xyz9999',
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'cor' => 'Preto',
        ]));
        $this->assertTrue($this->repo->desmarcarPrincipal(1));
        $this->assertTrue($this->repo->marcarPrincipal(2));

        $principal = $this->pdo->query('SELECT id_veiculo FROM veiculos WHERE principal = 1')->fetchColumn();
        $this->assertSame(2, (int)$principal);
        $this->assertSame('XYZ9999', $this->pdo->query('SELECT placa FROM veiculos WHERE id_veiculo = 1')->fetchColumn());
    }

    public function testFindAllComFiltrosPorPlacaBlocoEApto(): void
    {
        $this->insertVeiculo('ABC1234', 'Fiat', 'Uno', 'Prata', 1, 1);
        $this->insertVeiculo('DEF5678', 'Honda', 'Fit', 'Branco', 0, 1);

        $resultado = $this->repo->findAllComFiltros(['placa' => 'abc', 'bloco' => 'A', 'apto' => '101'], 10, 0);

        $this->assertCount(1, $resultado);
        $this->assertSame('ABC1234', $resultado[0]['placa']);
        $this->assertSame(1, $this->repo->countAllComFiltros(['placa' => 'abc']));
    }

    public function testTopMarcasCoresEModelos(): void
    {
        $this->insertVeiculo('ABC1234', 'Fiat', 'Uno', 'Prata', 1);
        $this->insertVeiculo('DEF5678', 'Fiat', 'Palio', 'Prata', 1);
        $this->insertVeiculo('GHI9012', 'Honda', 'Fit', 'Branco', 1);

        $this->assertSame(['marca' => 'Fiat', 'total' => 2], $this->repo->topMarcas(1)[0]);
        $this->assertSame(['cor' => 'Prata', 'total' => 2], $this->repo->topCores(1)[0]);
        $this->assertSame(['modelo' => 'Fit', 'total' => 1], $this->repo->topModelos(1)[0]);
    }

    public function testDeleteRemoveRegistro(): void
    {
        $this->insertVeiculo('ABC1234', 'Fiat', 'Uno', 'Prata', 1);

        $this->assertTrue($this->repo->delete(1));
        $this->assertSame(0, $this->repo->countAll());
    }

    private function insertMorador(string $nome, string $apto, string $bloco): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO morador (nome, apto, bloco) VALUES (:nome, :apto, :bloco)');
        $stmt->execute([
            ':nome' => CryptoHelper::encrypt($nome),
            ':apto' => $apto,
            ':bloco' => $bloco,
        ]);
    }

    private function insertVeiculo(
        string $placa,
        string $marca,
        string $modelo,
        string $cor,
        int $principal,
        int $idUser = 1
    ): void {
        $stmt = $this->pdo->prepare('
            INSERT INTO veiculos (placa, marca, modelo, cor, principal, id_user, id_user_cad)
            VALUES (:placa, :marca, :modelo, :cor, :principal, :id_user, 2)
        ');
        $stmt->execute([
            ':placa' => $placa,
            ':marca' => $marca,
            ':modelo' => $modelo,
            ':cor' => $cor,
            ':principal' => $principal,
            ':id_user' => $idUser,
        ]);
    }
}
