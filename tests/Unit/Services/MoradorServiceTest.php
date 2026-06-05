<?php

namespace Tests\Unit;

use MoradorRepository;
use MoradorService;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../../app/repositories/MoradorRepository.php';
require_once __DIR__ . '/../../../app/services/MoradorService.php';

final class MoradorServiceTest extends TestCase
{
    public function testCadastrarComSenhasDiferentesRetornaErro(): void
    {
        $resultado = (new MoradorService(new MoradorServiceRepositoryFake()))
            ->cadastrar($this->dadosCadastro(['senha' => '123', 'conf_senha' => '456']));

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('senhas', $resultado['mensagem']);
    }

    public function testCadastrarComCpfExistenteRetornaErro(): void
    {
        $repo = new MoradorServiceRepositoryFake();
        $repo->cpfExiste = true;

        $resultado = (new MoradorService($repo))->cadastrar($this->dadosCadastro());

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('CPF', $resultado['mensagem']);
        $this->assertSame('12345678900', $repo->cpfConsultado);
    }

    public function testCadastrarQuandoRepositorioFalhaRetornaErro(): void
    {
        $repo = new MoradorServiceRepositoryFake();
        $repo->idSalvo = false;

        $resultado = (new MoradorService($repo))->cadastrar($this->dadosCadastro());

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Erro interno', $resultado['mensagem']);
        $this->assertSame('12345678900', $repo->dadosSalvos['cpf']);
        $this->assertSame('P', $repo->dadosSalvos['status']);
        $this->assertTrue(password_verify('123456', $repo->dadosSalvos['senha']));
    }

    public function testListarPendentesRetornaRepositorio(): void
    {
        $repo = new MoradorServiceRepositoryFake();
        $repo->pendentes = [['nome' => 'Ana']];

        $this->assertSame($repo->pendentes, (new MoradorService($repo))->listarPendentes());
    }

    public function testLiberarOuBloquearSemPermissaoRetornaErro(): void
    {
        $repo = new MoradorServiceRepositoryFake();
        $repo->usuarios[10] = ['privilegio' => 1];

        $resultado = (new MoradorService($repo))->liberarOuBloquear(5, 'aceitar', 10);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('permiss', $resultado['mensagem']);
    }

    public function testAtualizarComCampoObrigatorioVazioRetornaErro(): void
    {
        $resultado = (new MoradorService(new MoradorServiceRepositoryFake()))
            ->atualizar($this->dadosAtualizacao(['email' => '']));

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Email', $resultado['mensagem']);
    }

    public function testAtualizarComSenhaGeraHashESalva(): void
    {
        $repo = new MoradorServiceRepositoryFake();

        $resultado = (new MoradorService($repo))->atualizar($this->dadosAtualizacao([
            'senha' => 'nova-senha',
            'conf_senha' => 'nova-senha',
        ]));

        $this->assertTrue($resultado['sucesso']);
        $this->assertTrue(password_verify('nova-senha', $repo->dadosAtualizados['senha']));
    }

    public function testAtualizarQuandoRepositorioFalhaRetornaErro(): void
    {
        $repo = new MoradorServiceRepositoryFake();
        $repo->atualizacaoOk = false;

        $resultado = (new MoradorService($repo))->atualizar($this->dadosAtualizacao());

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Erro ao atualizar', $resultado['mensagem']);
    }

    public function testDeletarChamaRepositorio(): void
    {
        $repo = new MoradorServiceRepositoryFake();

        $resultado = (new MoradorService($repo))->deletar(['id' => 33]);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(33, $repo->idDeletado);
    }

    public function testAtualizarStatusGestaoValidaStatusPermitido(): void
    {
        $repo = new MoradorServiceRepositoryFake();

        $resultado = (new MoradorService($repo))->atualizarStatusGestao(8, 'I');

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame([8, 'I'], $repo->statusAtualizado);
    }

    public function testAtualizarStatusGestaoPermiteReativar(): void
    {
        $repo = new MoradorServiceRepositoryFake();

        $resultado = (new MoradorService($repo))->atualizarStatusGestao(8, 'L');

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame([8, 'L'], $repo->statusAtualizado);
    }

    public function testAtualizarStatusGestaoRecusaStatusInvalido(): void
    {
        $repo = new MoradorServiceRepositoryFake();

        $resultado = (new MoradorService($repo))->atualizarStatusGestao(8, 'E');

        $this->assertFalse($resultado['sucesso']);
        $this->assertNull($repo->statusAtualizado);
    }

    public function testAtualizarPrivilegioRetornaResultadoDoRepositorio(): void
    {
        $repo = new MoradorServiceRepositoryFake();

        $this->assertTrue((new MoradorService($repo))->atualizarPrivilegio(8, 4));
        $this->assertSame([8, 4], $repo->privilegioAtualizado);
    }

    private function dadosCadastro(array $sobrescrever = []): array
    {
        return array_merge([
            'nome' => 'Maria Silva',
            'cpf' => '123.456.789-00',
            'apto' => '101',
            'bloco' => 'A',
            'email' => 'maria@example.com',
            'telefone' => '11999999999',
            'telefone_recado' => null,
            'senha' => '123456',
            'conf_senha' => '123456',
            'termos' => '1',
        ], $sobrescrever);
    }

    private function dadosAtualizacao(array $sobrescrever = []): array
    {
        return array_merge([
            'id' => 7,
            'nome' => 'Maria Silva',
            'email' => 'maria@example.com',
            'apto' => '101',
            'bloco' => 'A',
            'telefone' => '11999999999',
            'tell_recado' => null,
            'senha' => '',
            'conf_senha' => '',
        ], $sobrescrever);
    }
}

final class MoradorServiceRepositoryFake extends MoradorRepository
{
    public bool $cpfExiste = false;
    public int|bool $idSalvo = 1;
    public bool $atualizacaoOk = true;
    public ?string $cpfConsultado = null;
    public ?array $dadosSalvos = null;
    public ?array $dadosAtualizados = null;
    public array $pendentes = [];
    public array $usuarios = [];
    public ?int $idDeletado = null;
    public ?array $privilegioAtualizado = null;
    public ?array $statusAtualizado = null;

    public function __construct()
    {
    }

    public function existeCpf(string $cpf): bool
    {
        $this->cpfConsultado = $cpf;
        return $this->cpfExiste;
    }

    public function existeEmail(string $email): bool
    {
        return false;
    }

    public function existeEmailParaOutro(string $email, int $idAtual): bool
    {
        return false;
    }

    public function save(array $data): int|bool
    {
        $this->dadosSalvos = $data;
        return $this->idSalvo;
    }

    public function findPendentes(): array
    {
        return $this->pendentes;
    }

    public function findById(int $id): ?array
    {
        return $this->usuarios[$id] ?? null;
    }

    public function atualizarDados(array $update): bool
    {
        $this->dadosAtualizados = $update;
        return $this->atualizacaoOk;
    }

    public function deletarDados(int $id): bool
    {
        $this->idDeletado = $id;
        return true;
    }

    public function atualizarPrivilegio(int $id, int $privilegio): bool
    {
        $this->privilegioAtualizado = [$id, $privilegio];
        return true;
    }

    public function atualizarStatus(int $id, string $status): bool
    {
        $this->statusAtualizado = [$id, $status];
        return true;
    }
}
