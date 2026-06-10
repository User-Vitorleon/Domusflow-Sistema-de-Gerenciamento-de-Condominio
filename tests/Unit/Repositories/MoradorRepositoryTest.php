<?php

namespace Tests\Unit\Repositories;

use CryptoHelper;
use MoradorRepository;
use Tests\Support\RepositoryTestCase;

final class MoradorRepositoryTest extends RepositoryTestCase
{
    private MoradorRepository $repo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pdo->exec('
            CREATE TABLE morador (
                id_user INTEGER PRIMARY KEY AUTOINCREMENT,
                uuid TEXT,
                nome TEXT,
                apto TEXT,
                bloco TEXT,
                cpf TEXT,
                cpf_hash TEXT,
                email TEXT,
                email_hash TEXT,
                telefone TEXT,
                tell_recado TEXT,
                senha TEXT,
                status TEXT,
                privilegio INTEGER,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            )
        ');
        $this->pdo->exec('CREATE TABLE ocorrencia_tramites (id_user_cad INTEGER, nome_user_cad TEXT)');
        $this->pdo->exec('CREATE TABLE reservas (id_user_aprov INTEGER, nome_user_aprov TEXT)');

        $this->repo = $this->repository(MoradorRepository::class);
    }

    public function testSaveCriaRegistroCriptografadoEFindByIdDescriptografa(): void
    {
        $id = $this->repo->save($this->dadosMorador());

        $this->assertSame(1, $id);
        $bruto = $this->pdo->query('SELECT nome, email, cpf_hash, status FROM morador WHERE id_user = 1')->fetch();
        $this->assertNotSame('Ana Silva', $bruto['nome']);
        $this->assertSame(CryptoHelper::hashCpf('52998224725'), $bruto['cpf_hash']);
        $this->assertSame('P', $bruto['status']);

        $morador = $this->repo->findById(1);
        $this->assertSame('Ana Silva', $morador['nome']);
        $this->assertSame('ana@example.com', $morador['email']);
    }

    public function testBuscaPorCpfEEmailUsaHash(): void
    {
        $this->repo->save($this->dadosMorador());

        $this->assertTrue($this->repo->existeCpf('529.982.247-25'));
        $this->assertTrue($this->repo->existeEmail('ana@example.com'));
        $this->assertFalse($this->repo->existeEmail('outra@example.com'));
        $this->assertSame('Ana Silva', $this->repo->findByCpf('52998224725')['nome']);
    }

    public function testAtualizarStatusEContadores(): void
    {
        $this->repo->save($this->dadosMorador(['status' => 'P']));

        $this->assertTrue($this->repo->atualizarStatus(1, 'L'));
        $this->assertSame('L', $this->repo->getStatus(1));
        $this->assertSame(1, $this->repo->countByStatus('L'));
        $this->assertSame(1, $this->repo->countMoradoresAtivos());
    }

    public function testExisteMoradorAtivoNaUnidadeIgnoraIdInformado(): void
    {
        $this->repo->save($this->dadosMorador(['apto' => '101', 'bloco' => 'A']));
        $this->repo->atualizarStatus(1, 'L');

        $this->assertTrue($this->repo->existeMoradorAtivoNaUnidade('101', 'A'));
        $this->assertFalse($this->repo->existeMoradorAtivoNaUnidade('101', 'A', 1));
    }

    public function testAtualizarDadosComESemSenha(): void
    {
        $this->repo->save($this->dadosMorador());

        $this->assertTrue($this->repo->atualizarDados([
            'id' => 1,
            'nome' => 'Ana Atualizada',
            'email' => 'ana2@example.com',
            'apto' => '202',
            'bloco' => 'B',
            'telefone' => '11888888888',
            'tell_recado' => '',
            'senha' => '',
        ]));

        $morador = $this->repo->findById(1);
        $this->assertSame('Ana Atualizada', $morador['nome']);
        $this->assertSame('202', $morador['apto']);

        $this->assertTrue($this->repo->atualizarDados([
            'id' => 1,
            'nome' => 'Ana Senha',
            'email' => 'ana3@example.com',
            'apto' => '203',
            'bloco' => 'C',
            'telefone' => '11777777777',
            'tell_recado' => '',
            'senha' => 'hash-novo',
        ]));
        $this->assertSame('hash-novo', $this->pdo->query('SELECT senha FROM morador WHERE id_user = 1')->fetchColumn());
    }

    public function testAtualizarPrivilegioUnidadeESenha(): void
    {
        $this->repo->save($this->dadosMorador());

        $this->assertTrue($this->repo->atualizarPrivilegio(1, 2));
        $this->assertTrue($this->repo->atualizarUnidade(1, '303', 'C'));
        $this->assertTrue($this->repo->atualizarSenha(1, 'hash-senha'));

        $row = $this->pdo->query('SELECT privilegio, apto, bloco, senha FROM morador WHERE id_user = 1')->fetch();
        $this->assertSame(2, (int)$row['privilegio']);
        $this->assertSame('303', $row['apto']);
        $this->assertSame('C', $row['bloco']);
        $this->assertSame('hash-senha', $row['senha']);
    }

    public function testContarPorStatusPreencheTodosOsStatus(): void
    {
        $this->repo->save($this->dadosMorador(['status' => 'P']));
        $this->repo->save($this->dadosMorador(['cpf' => '39053344705', 'email' => 'bia@example.com', 'status' => 'L']));
        $this->repo->atualizarStatus(2, 'L');

        $contagem = $this->repo->contarPorStatus();

        $this->assertSame(1, $contagem['P']);
        $this->assertSame(1, $contagem['L']);
        $this->assertSame(0, $contagem['B']);
    }

    private function dadosMorador(array $override = []): array
    {
        return array_replace([
            'nome' => 'Ana Silva',
            'cpf' => '52998224725',
            'apto' => '101',
            'bloco' => 'A',
            'email' => 'ana@example.com',
            'telefone' => '11999999999',
            'telefone_recado' => '',
            'senha' => 'hash',
            'status' => 'P',
            'privilegio' => 1,
        ], $override);
    }
}
