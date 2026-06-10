<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use VeiculoService;
use Tests\Support\FakeMoradorRepository;
use Tests\Support\FakeVeiculoRepository;

final class VeiculoServiceTest extends TestCase
{
    private FakeVeiculoRepository $repo;
    private FakeMoradorRepository $moradorRepo;
    private VeiculoService $service;

    protected function setUp(): void
    {
        $this->repo = new FakeVeiculoRepository();
        $this->moradorRepo = new FakeMoradorRepository();
        $this->moradorRepo->moradores[7] = ['id_user' => 7, 'privilegio' => 2];
        $this->service = new VeiculoService($this->repo, $this->moradorRepo);
    }

    private function dadosValidos(array $override = []): array
    {
        return array_replace([
            'placa' => 'abc-1234',
            'id_user' => 7,
            'marca' => 'Fiat',
            'modelo' => 'Uno',
            'cor' => 'Prata',
        ], $override);
    }

    public function testCadastrarValidaPlacaCurta(): void
    {
        $resultado = $this->service->cadastrar($this->dadosValidos(['placa' => 'AB1']), 2, 2);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Placa', $resultado['mensagem']);
    }

    public function testCadastrarBloqueiaPlacaDuplicada(): void
    {
        $this->repo->placaExiste = true;

        $resultado = $this->service->cadastrar($this->dadosValidos(), 2, 2);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('placa', $resultado['mensagem']);
        $this->assertStringContainsString('cadastrada', $resultado['mensagem']);
    }

    public function testCadastrarValidaMarcaEModeloDoCatalogo(): void
    {
        $resultado = $this->service->cadastrar($this->dadosValidos(['modelo' => 'Modelo Inexistente']), 2, 2);

        $this->assertFalse($resultado['sucesso']);
        $this->assertSame('Selecione uma marca e modelo validos.', $resultado['mensagem']);
    }

    public function testCadastrarSalvaPlacaNormalizadaEPrimeiroVeiculoComoPrincipal(): void
    {
        $resultado = $this->service->cadastrar($this->dadosValidos(), 3, 2);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame('ABC1234', $this->repo->dadosSalvos['placa']);
        $this->assertSame(1, $this->repo->dadosSalvos['principal']);
        $this->assertSame(7, $this->repo->usuarioDesmarcado);
        $this->assertSame(3, $this->repo->dadosSalvos['id_user_cad']);
    }

    public function testCadastrarPodeSalvarVeiculoNaoPrincipalQuandoUsuarioJaTemVeiculo(): void
    {
        $this->repo->quantidadeUsuario = 1;

        $resultado = $this->service->cadastrar($this->dadosValidos(), 3, 2);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(0, $this->repo->dadosSalvos['principal']);
        $this->assertNull($this->repo->usuarioDesmarcado);
    }

    public function testCadastrarRetornaErroQuandoRepositorioFalha(): void
    {
        $this->repo->saveResultado = false;

        $resultado = $this->service->cadastrar($this->dadosValidos(), 3, 2);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Erro ao salvar', $resultado['mensagem']);
    }

    public function testListagensDelegamAoRepositorio(): void
    {
        $this->repo->todos = [['placa' => 'AAA1111']];
        $this->repo->porUsuario = [['placa' => 'BBB2222']];
        $this->repo->filtrados = [['placa' => 'CCC3333']];
        $this->repo->totalFiltrado = 8;
        $this->repo->quantidadeUsuario = 1;

        $this->assertSame($this->repo->todos, $this->service->listarTodos());
        $this->assertSame($this->repo->porUsuario, $this->service->listarPorUsuario(7));
        $this->assertSame($this->repo->filtrados, $this->service->listarTodosComFiltros(['placa' => 'C'], 10, 20));
        $this->assertSame(8, $this->service->contarTodosComFiltros(['placa' => 'C']));
        $this->assertSame(1, $this->service->contarPorUsuario(7));
    }

    public function testConsultarPorPlacaNormalizaBusca(): void
    {
        $this->repo->veiculoPorPlaca = ['placa' => 'ABC1234'];

        $resultado = $this->service->consultarPorPlaca('abc-1234');

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(['placa' => 'ABC1234'], $resultado['veiculo']);
    }

    public function testConsultarPorPlacaInexistenteRetornaErro(): void
    {
        $resultado = $this->service->consultarPorPlaca('abc-1234');

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Nenhum', $resultado['mensagem']);
        $this->assertStringContainsString('placa', $resultado['mensagem']);
    }

    public function testEditarExigePrivilegioPermitido(): void
    {
        $resultado = $this->service->editar(1, $this->dadosValidos(), 1);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('permi', $resultado['mensagem']);
    }

    public function testEditarAtualizaDadosValidos(): void
    {
        $resultado = $this->service->editar(5, $this->dadosValidos(['placa' => 'abc1d23']), 2);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(5, $this->repo->idAtualizado);
        $this->assertSame('ABC1D23', $this->repo->dadosAtualizados['placa']);
    }

    public function testDefinirPrincipalExigeVeiculoExistente(): void
    {
        $resultado = $this->service->definirPrincipal(44, 2, 7);

        $this->assertFalse($resultado['sucesso']);
        $this->assertSame('Veiculo nao encontrado.', $resultado['mensagem']);
    }

    public function testDefinirPrincipalPermiteDonoOuGestao(): void
    {
        $this->repo->veiculoPorId = ['id_veiculo' => 44, 'id_user' => 7];

        $resultado = $this->service->definirPrincipal(44, 1, 7);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(7, $this->repo->usuarioDesmarcado);
        $this->assertSame(44, $this->repo->veiculoPrincipal);
    }

    public function testExcluirMoradorNaoPodeExcluirVeiculoDeOutroUsuario(): void
    {
        $this->repo->veiculoPorId = ['id_veiculo' => 44, 'id_user' => 99];

        $resultado = $this->service->excluir(44, 1, 7);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('permi', $resultado['mensagem']);
    }

    public function testExcluirReorganizaPrincipalQuandoNecessario(): void
    {
        $this->repo->veiculoPorId = ['id_veiculo' => 44, 'id_user' => 7, 'principal' => 1];
        $this->repo->porUsuario = [['id_veiculo' => 45, 'id_user' => 7]];

        $resultado = $this->service->excluir(44, 2, 20);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(44, $this->repo->idExcluido);
        $this->assertSame(45, $this->repo->veiculoPrincipal);
    }

    public function testCatalogoRetornaMarcasConhecidas(): void
    {
        $catalogo = VeiculoService::catalogoMarcaModelo();

        $this->assertArrayHasKey('Fiat', $catalogo);
        $this->assertContains('Uno', $catalogo['Fiat']);
    }
}
