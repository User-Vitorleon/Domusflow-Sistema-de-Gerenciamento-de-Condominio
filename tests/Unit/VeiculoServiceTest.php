<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use MoradorRepository;
use VeiculoRepository;
use VeiculoService;

require_once __DIR__ . '/../../app/repositories/VeiculoRepository.php';
require_once __DIR__ . '/../../app/repositories/MoradorRepository.php';
require_once __DIR__ . '/../../app/services/VeiculoService.php';

final class VeiculoServiceTest extends TestCase
{
    private function criarService(?FakeVeiculoRepository $repo = null): VeiculoService
    {
        return new VeiculoService($repo ?? new FakeVeiculoRepository(), new FakeMoradorRepository());
    }

    private function invocarNormalizarPlaca(string $placa): string
    {
        $service = $this->criarService();
        $ref     = new ReflectionClass($service);
        $metodo  = $ref->getMethod('normalizarPlaca');
        $metodo->setAccessible(true);
        return $metodo->invoke($service, $placa);
    }

    public function testNormalizarPlacaConverteParaMaiusculo(): void
    {
        $this->assertSame('ABC1D23', $this->invocarNormalizarPlaca('abc1d23'));
    }

    public function testNormalizarPlacaRemoveHifenEEspacos(): void
    {
        $this->assertSame('ABC1234', $this->invocarNormalizarPlaca('abc-1234'));
        $this->assertSame('ABC1234', $this->invocarNormalizarPlaca(' abc 1234 '));
    }

    public function testNormalizarPlacaRemoveCaracteresEspeciais(): void
    {
        $this->assertSame('XYZ9999', $this->invocarNormalizarPlaca('xyz/9999@'));
    }

    public function testCadastroComPlacaCurtaRetornaErro(): void
    {
        $service = $this->criarService();
        $resultado = $service->cadastrar(
            ['placa' => 'AB1', 'id_user' => 1, 'marca' => 'x', 'modelo' => 'y', 'cor' => 'z'],
            1,
            1
        );

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Placa inv', $resultado['mensagem']);
    }

    public function testCadastrarComPlacaExistenteRetornaErro(): void
    {
        $repo = new FakeVeiculoRepository();
        $repo->placaExiste = true;

        $resultado = $this->criarService($repo)->cadastrar(
            ['placa' => 'abc-1234', 'id_user' => 1, 'marca' => 'Fiat', 'modelo' => 'Uno', 'cor' => 'Branca'],
            99,
            2
        );

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('cadastrada', $resultado['mensagem']);
    }

    public function testCadastrarSalvaDadosNormalizados(): void
    {
        $repo = new FakeVeiculoRepository();

        $resultado = $this->criarService($repo)->cadastrar(
            [
                'placa' => 'abc-1234',
                'id_user' => 7,
                'marca' => ' fiat ',
                'modelo' => ' uno way ',
                'cor' => 'Prata',
                'principal' => '1',
            ],
            99,
            2
        );

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame('ABC1234', $repo->dadosSalvos['placa']);
        $this->assertSame('Fiat', $repo->dadosSalvos['marca']);
        $this->assertSame('Uno Way', $repo->dadosSalvos['modelo']);
        $this->assertSame(1, $repo->dadosSalvos['principal']);
        $this->assertSame(7, $repo->desmarcouPrincipalDoUsuario);
    }

    public function testCadastrarRetornaErroQuandoRepositorioNaoSalva(): void
    {
        $repo = new FakeVeiculoRepository();
        $repo->idSalvo = 0;

        $resultado = $this->criarService($repo)->cadastrar(
            ['placa' => 'ABC1234', 'id_user' => 7, 'marca' => 'Fiat', 'modelo' => 'Uno', 'cor' => 'Prata'],
            99,
            2
        );

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Erro ao salvar', $resultado['mensagem']);
    }

    public function testListarTodosRetornaDadosDoRepositorio(): void
    {
        $repo = new FakeVeiculoRepository();
        $repo->todos = [['placa' => 'ABC1234']];

        $this->assertSame($repo->todos, $this->criarService($repo)->listarTodos());
    }

    public function testListarPorUsuarioRetornaDadosDoRepositorio(): void
    {
        $repo = new FakeVeiculoRepository();
        $repo->porUsuario = [['id_user' => 5]];

        $this->assertSame($repo->porUsuario, $this->criarService($repo)->listarPorUsuario(5));
        $this->assertSame(5, $repo->usuarioConsultado);
    }

    public function testConsultarPorPlacaQuandoNaoEncontraRetornaErro(): void
    {
        $resultado = $this->criarService()->consultarPorPlaca('abc-1234');

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Nenhum', $resultado['mensagem']);
    }

    public function testConsultarPorPlacaQuandoEncontraRetornaVeiculo(): void
    {
        $repo = new FakeVeiculoRepository();
        $repo->veiculoPorPlaca = ['placa' => 'ABC1234'];

        $resultado = $this->criarService($repo)->consultarPorPlaca('abc-1234');

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(['placa' => 'ABC1234'], $resultado['veiculo']);
        $this->assertSame('ABC1234', $repo->placaConsultada);
    }

    public function testEditarSemPrivilegioRetornaErro(): void
    {
        $resultado = $this->criarService()->editar(
            1,
            ['placa' => 'ABC1234', 'marca' => 'Fiat', 'modelo' => 'Uno', 'cor' => 'Branca'],
            1
        );

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('permiss', $resultado['mensagem']);
    }

    public function testEditarComPlacaCurtaRetornaErro(): void
    {
        $resultado = $this->criarService()->editar(
            1,
            ['placa' => 'AB1', 'marca' => 'Fiat', 'modelo' => 'Uno', 'cor' => 'Branca'],
            2
        );

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Placa inv', $resultado['mensagem']);
    }

    public function testEditarComPrivilegioAtualizaDadosNormalizados(): void
    {
        $repo = new FakeVeiculoRepository();

        $resultado = $this->criarService($repo)->editar(
            8,
            ['placa' => 'abc-1234', 'marca' => ' fiat ', 'modelo' => ' uno ', 'cor' => 'Branca'],
            2
        );

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(8, $repo->idAtualizado);
        $this->assertSame('ABC1234', $repo->dadosAtualizados['placa']);
        $this->assertSame('Fiat', $repo->dadosAtualizados['marca']);
        $this->assertSame('Uno', $repo->dadosAtualizados['modelo']);
    }

    public function testDefinirPrincipalDesmarcaEAtualizaVeiculo(): void
    {
        $repo = new FakeVeiculoRepository();

        $resultado = $this->criarService($repo)->definirPrincipal(3, 5);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(5, $repo->desmarcouPrincipalDoUsuario);
        $this->assertSame(3, $repo->veiculoMarcadoPrincipal);
    }

    public function testExcluirSemPrivilegioRetornaErro(): void
    {
        $resultado = $this->criarService()->excluir(1, 99, 1);
        $this->assertFalse($resultado['sucesso']);
    }

    public function testExcluirComoSindicoRemoveVeiculo(): void
    {
        $repo = new FakeVeiculoRepository();

        $resultado = $this->criarService($repo)->excluir(12, 2, 99);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(12, $repo->idExcluido);
    }

    public function testExcluirMoradorQuandoVeiculoNaoExisteRetornaErro(): void
    {
        $resultado = $this->criarService()->excluir(12, 1, 7);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('ncontrado', $resultado['mensagem']);
    }

    public function testExcluirMoradorNaoPermiteVeiculoDeOutroUsuario(): void
    {
        $repo = new FakeVeiculoRepository();
        $repo->veiculoPorId = ['id_user' => 8];

        $resultado = $this->criarService($repo)->excluir(12, 1, 7);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('permiss', $resultado['mensagem']);
    }

    public function testExcluirMoradorRemoveProprioVeiculo(): void
    {
        $repo = new FakeVeiculoRepository();
        $repo->veiculoPorId = ['id_user' => 7];

        $resultado = $this->criarService($repo)->excluir(12, 1, 7);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(12, $repo->idExcluido);
    }
}

final class FakeVeiculoRepository extends VeiculoRepository
{
    public bool $placaExiste = false;
    public int $idSalvo = 1;
    public ?array $dadosSalvos = null;
    public ?array $dadosAtualizados = null;
    public ?array $veiculoPorPlaca = null;
    public ?array $veiculoPorId = null;
    public array $todos = [];
    public array $porUsuario = [];
    public ?int $desmarcouPrincipalDoUsuario = null;
    public ?int $veiculoMarcadoPrincipal = null;
    public ?int $idAtualizado = null;
    public ?int $idExcluido = null;
    public ?int $usuarioConsultado = null;
    public ?string $placaConsultada = null;

    public function __construct()
    {
    }

    public function existePlaca(string $p): bool
    {
        return $this->placaExiste;
    }

    public function countByUser(int $id): int
    {
        return 0;
    }

    public function desmarcarPrincipal(int $id): bool
    {
        $this->desmarcouPrincipalDoUsuario = $id;
        return true;
    }

    public function marcarPrincipal(int $id): bool
    {
        $this->veiculoMarcadoPrincipal = $id;
        return true;
    }

    public function save(array $d): int
    {
        $this->dadosSalvos = $d;
        return $this->idSalvo;
    }

    public function update(int $id, array $d): bool
    {
        $this->idAtualizado = $id;
        $this->dadosAtualizados = $d;
        return true;
    }

    public function delete(int $id): bool
    {
        $this->idExcluido = $id;
        return true;
    }

    public function findAll(): array
    {
        return $this->todos;
    }

    public function findByUsuario(int $id): array
    {
        $this->usuarioConsultado = $id;
        return $this->porUsuario;
    }

    public function findByPlaca(string $p): ?array
    {
        $this->placaConsultada = $p;
        return $this->veiculoPorPlaca;
    }

    public function findById(int $id): ?array
    {
        return $this->veiculoPorId;
    }
}

final class FakeMoradorRepository extends MoradorRepository
{
    public function __construct()
    {
    }

    public function findById(int $id): ?array
    {
        return ['id_user' => $id, 'privilegio' => 2];
    }
}
