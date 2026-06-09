<?php

namespace Tests\Unit\Services;

use MoradorService;
use PHPUnit\Framework\TestCase;
use Tests\Support\FakeMoradorRepository;

final class MoradorServiceTest extends TestCase
{
    private FakeMoradorRepository $repo;
    private MoradorService $service;

    protected function setUp(): void
    {
        $_SESSION = [];
        $this->repo = new FakeMoradorRepository();
        $this->service = new MoradorService($this->repo);
    }

    private function dadosCadastro(array $override = []): array
    {
        return array_replace([
            'termos' => '1',
            'nome' => 'Ana Silva',
            'cpf' => '529.982.247-25',
            'apto' => '101',
            'bloco' => 'a',
            'email' => 'ana@example.com',
            'telefone' => '11999999999',
            'senha' => 'senha123',
            'conf_senha' => 'senha123',
            'privilegio' => 1,
        ], $override);
    }

    public function testCadastrarExigeAceiteDosTermos(): void
    {
        $resultado = $this->service->cadastrar($this->dadosCadastro(['termos' => '']));

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('termos', $resultado['mensagem']);
    }

    public function testCadastrarExigeCamposObrigatorios(): void
    {
        $resultado = $this->service->cadastrar($this->dadosCadastro(['email' => '']));

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('e-mail', $resultado['mensagem']);
    }

    public function testCadastrarValidaCpf(): void
    {
        $resultado = $this->service->cadastrar($this->dadosCadastro(['cpf' => '111.111.111-11']));

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('CPF', $resultado['mensagem']);
    }

    public function testCadastrarValidaAptoNumerico(): void
    {
        $resultado = $this->service->cadastrar($this->dadosCadastro(['apto' => 'ABC']));

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Apartamento', $resultado['mensagem']);
    }

    public function testCadastrarValidaBlocoComUmaLetra(): void
    {
        $resultado = $this->service->cadastrar($this->dadosCadastro(['bloco' => 'AB']));

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Bloco', $resultado['mensagem']);
    }

    public function testCadastrarValidaConfirmacaoDeSenha(): void
    {
        $resultado = $this->service->cadastrar($this->dadosCadastro(['conf_senha' => 'outra']));

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('senhas', $resultado['mensagem']);
    }

    public function testCadastrarBloqueiaCpfDuplicado(): void
    {
        $this->repo->cpfExiste = true;

        $resultado = $this->service->cadastrar($this->dadosCadastro());

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('CPF', $resultado['mensagem']);
    }

    public function testCadastrarBloqueiaEmailDuplicado(): void
    {
        $this->repo->emailExiste = true;

        $resultado = $this->service->cadastrar($this->dadosCadastro());

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('e-mail', $resultado['mensagem']);
    }

    public function testCadastrarNormalizaUnidadeDeFuncionarios(): void
    {
        $this->repo->saveResultado = false;

        $resultado = $this->service->cadastrar($this->dadosCadastro([
            'privilegio' => 3,
            'apto' => '999',
            'bloco' => 'Z',
        ]));

        $this->assertFalse($resultado['sucesso']);
        $this->assertSame('0', $this->repo->dadosSalvos['apto']);
        $this->assertSame('G', $this->repo->dadosSalvos['bloco']);
    }

    public function testAtualizarExigeCamposObrigatorios(): void
    {
        $resultado = $this->service->atualizar(['id' => 5, 'nome' => 'Ana']);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Email', $resultado['mensagem']);
    }

    public function testAtualizarValidaSenhaConfirmada(): void
    {
        $resultado = $this->service->atualizar([
            'id' => 5,
            'nome' => 'Ana',
            'email' => 'ana@example.com',
            'bloco' => 'A',
            'apto' => '101',
            'telefone' => '11999999999',
            'senha' => 'abc',
            'conf_senha' => 'xyz',
        ]);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('senhas', $resultado['mensagem']);
    }

    public function testAtualizarBloqueiaEmailDeOutroCadastro(): void
    {
        $this->repo->emailOutroExiste = true;

        $resultado = $this->service->atualizar([
            'id' => 5,
            'nome' => 'Ana',
            'email' => 'ana@example.com',
            'bloco' => 'A',
            'apto' => '101',
            'telefone' => '11999999999',
        ]);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('outro cadastro', $resultado['mensagem']);
    }

    public function testAtualizarPersisteDados(): void
    {
        $resultado = $this->service->atualizar([
            'id' => 5,
            'nome' => 'Ana',
            'email' => 'ana@example.com',
            'bloco' => 'A',
            'apto' => '101',
            'telefone' => '11999999999',
        ]);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame('Ana', $this->repo->dadosAtualizados['nome']);
    }

    public function testDeletarChamaRepositorio(): void
    {
        $resultado = $this->service->deletar(['id' => 42]);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(42, $this->repo->idDeletado);
    }

    public function testAtualizarStatusGestaoValidaEntrada(): void
    {
        $resultado = $this->service->atualizarStatusGestao(0, 'X');

        $this->assertFalse($resultado['sucesso']);
        $this->assertSame('Status invalido.', $resultado['mensagem']);
    }

    public function testAtualizarStatusGestaoBloqueiaUnidadeDuplicadaAoLiberar(): void
    {
        $this->repo->moradores[5] = ['id_user' => 5, 'privilegio' => 1, 'apto' => '101', 'bloco' => 'A'];
        $this->repo->unidadeOcupada = true;

        $resultado = $this->service->atualizarStatusGestao(5, 'L');

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('morador ativo', $resultado['mensagem']);
    }

    public function testAtualizarStatusGestaoAtualizaStatus(): void
    {
        $this->repo->moradores[5] = ['id_user' => 5, 'privilegio' => 1, 'apto' => '101', 'bloco' => 'A'];

        $resultado = $this->service->atualizarStatusGestao(5, 'i');

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame([5, 'I'], $this->repo->statusAtualizado);
    }

    public function testAtualizarPrivilegioValidaPerfil(): void
    {
        $this->assertFalse($this->service->atualizarPrivilegio(5, 99));
    }

    public function testAtualizarPrivilegioNaoAlteraAdministrador(): void
    {
        $this->repo->moradores[5] = ['id_user' => 5, 'privilegio' => 4];

        $this->assertFalse($this->service->atualizarPrivilegio(5, 2));
    }

    public function testAtualizarPrivilegioAlteraPerfilPermitido(): void
    {
        $this->repo->moradores[5] = ['id_user' => 5, 'privilegio' => 1];

        $this->assertTrue($this->service->atualizarPrivilegio(5, 2));
        $this->assertSame([5, 2], $this->repo->privilegioAtualizado);
    }

    public function testAtualizarUnidadeNormalizaAptoEBloco(): void
    {
        $resultado = $this->service->atualizarUnidade(5, 'Apto 301', 'b');

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame([5, '301', 'B'], $this->repo->unidadeAtualizada);
    }

    public function testAtualizarPrivilegioEUnidadeDefineUnidadeGenericaParaPerfilSemApartamento(): void
    {
        $this->repo->moradores[5] = ['id_user' => 5, 'privilegio' => 1, 'status' => 'P'];

        $resultado = $this->service->atualizarPrivilegioEUnidade(5, 3, '101', 'A');

        $this->assertTrue($resultado);
        $this->assertSame([5, 3], $this->repo->privilegioAtualizado);
        $this->assertSame([5, '0', 'G'], $this->repo->unidadeAtualizada);
    }
}
